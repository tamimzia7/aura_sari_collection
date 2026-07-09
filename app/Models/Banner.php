<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'button_text',
        'sort_order',
        'status',
    ];

    public function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
