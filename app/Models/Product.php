<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'uuid',
        'title',
        'price',
        'description',
        'metadata',
        'deleted_at',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
}
