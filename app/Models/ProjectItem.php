<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'product_id',
        'quantity',
        'hpp_at_sale',
        'sell_price_at_sale',
        'subtotal'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'hpp_at_sale' => 'decimal:2',
        'sell_price_at_sale' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
