<?php

use App\Models\User;

beforeEach(function () {
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'user@test.com',
        'password' => bcrypt('password123'),
        'role' => 'customer',
    ]);
});

test('registered user can login', function () {
    $response = $this->post(route('login'), [
        'email' => 'user@test.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect();
    $this->assertAuthenticated();
});

test('user cannot login with invalid credentials', function () {
    $response = $this->post(route('login'), [
        'email' => 'user@test.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('new user can register', function () {
    $response = $this->post(route('register'), [
        'name' => 'New User',
        'email' => 'newuser@test.com',
        'phone' => '1234567890',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect();
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'newuser@test.com',
        'role' => 'customer',
    ]);
});

test('registration requires valid data', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'not-matching',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
});

test('registration requires unique email', function () {
    $response = $this->post(route('register'), [
        'name' => 'Duplicate',
        'email' => 'user@test.com',
        'phone' => '1234567890',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
});
