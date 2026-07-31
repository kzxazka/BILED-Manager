<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'customer_name',
        'license_plate',
        'labor_fee',
        'total_amount',
        'total_hpp',
        'net_profit',
        'status'
    ];

    protected $casts = [
        'labor_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'total_hpp' => 'decimal:2',
        'net_profit' => 'decimal:2'
    ];

    public function projectItems(): HasMany
    {
        return $this->hasMany(ProjectItem::class);
    }
}
