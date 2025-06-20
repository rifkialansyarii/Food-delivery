<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $with = ['users', 'menus', 'drivers'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menus(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function drivers(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }


    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'menu_id',
        'driver_id',
        'amount',
        'total',
        'location',
    ];
}
