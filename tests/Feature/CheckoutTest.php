<?php

use App\Models\Address;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'customer']);

    $category = Category::factory()->create();
    $brand = Brand::factory()->create();

    $this->product = Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'price' => 1000,
        'discount_price' => 900,
        'stock_quantity' => 50,
        'status' => true,
    ]);

    ProductImage::factory()->create([
        'product_id' => $this->product->id,
        'is_primary' => true,
    ]);

    Cart::create([
        'user_id' => $this->user->id,
        'product_id' => $this->product->id,
        'quantity' => 2,
    ]);
});

test('guest cannot access checkout', function () {
    $response = $this->post(route('checkout.store'), [
        'address_id' => 1,
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect(route('login'));
});

test('checkout requires address_id', function () {
    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'payment_method' => 'cod',
    ]);

    $response->assertSessionHasErrors('address_id');
});

test('checkout with valid saved address creates order', function () {
    $address = Address::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'shipping',
    ]);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => $address->id,
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('orders', [
        'user_id' => $this->user->id,
        'shipping_address_id' => $address->id,
        'billing_address_id' => $address->id,
        'payment_method' => 'cod',
        'status' => 'pending',
        'subtotal' => 1800.00,
        'discount' => 0.00,
        'grand_total' => 1800.00,
    ]);

    $this->assertDatabaseMissing('carts', [
        'user_id' => $this->user->id,
    ]);
});

test('checkout with new address creates order', function () {
    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => 'new',
        'shipping_name' => 'John Doe',
        'shipping_phone' => '01234567890',
        'shipping_address_line1' => '123 Test Street',
        'shipping_city' => 'Dhaka',
        'shipping_state' => 'Dhaka Division',
        'shipping_zip' => '1205',
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('addresses', [
        'user_id' => $this->user->id,
        'name' => 'John Doe',
        'address_line1' => '123 Test Street',
    ]);

    $address = Address::where('user_id', $this->user->id)
        ->where('name', 'John Doe')
        ->first();

    $this->assertDatabaseHas('orders', [
        'user_id' => $this->user->id,
        'shipping_address_id' => $address->id,
        'billing_address_id' => $address->id,
        'subtotal' => 1800.00,
    ]);
});

test('checkout with coupon applies discount', function () {
    $address = Address::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $coupon = Coupon::create([
        'code' => 'TEST10',
        'type' => 'percentage',
        'value' => 10,
        'is_active' => true,
        'used_count' => 0,
        'max_uses' => 100,
    ]);

    session(['coupon' => [
        'code' => $coupon->code,
        'coupon_id' => $coupon->id,
        'discount' => 180.00,
    ]]);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => $address->id,
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('orders', [
        'user_id' => $this->user->id,
        'shipping_address_id' => $address->id,
        'coupon_code' => 'TEST10',
        'coupon_id' => $coupon->id,
        'discount' => 180.00,
        'grand_total' => 1620.00,
    ]);

    $coupon->refresh();
    $this->assertEquals(1, $coupon->used_count);
});

test('checkout with advance payment requires transaction_id', function () {
    $address = Address::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => $address->id,
        'payment_method' => 'bkash',
    ]);

    $response->assertSessionHasErrors('transaction_id');
});

test('checkout rejects address_id not owned by user', function () {
    $otherUser = User::factory()->create();
    $address = Address::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => $address->id,
        'payment_method' => 'cod',
    ]);

    $response->assertSessionHasErrors('address_id');
});

test('checkout with empty cart redirects back', function () {
    Cart::where('user_id', $this->user->id)->delete();

    $address = Address::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'address_id' => $address->id,
        'payment_method' => 'cod',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Your cart is empty');
});
