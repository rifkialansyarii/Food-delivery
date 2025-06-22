<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $with = ['users', 'menus', 'drivers', 'detail_order', "merchant"];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function merchant() : BelongsTo {
        return $this->belongsTo(Merchant::class, "merchant_id");
    }

    public function menus(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function drivers(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    function detail_order(): HasMany {
        return $this->hasMany(DetailOrder::class, "order_id", "id");
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

    protected $casts = [
        'is_done' => 'boolean',
        'is_diambil' => 'boolean',
        'is_taken' => 'boolean',
    ];
}
