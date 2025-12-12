<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    Use HasFactory;
    /**
     * Properties of the Model that are fillable.
     *
     * @var string[] fillable - parts of model that are fillable
     */
    protected $fillable = [
        'name',
        'quantity',
        'sku',
        'notification_sent'
    ];
}
