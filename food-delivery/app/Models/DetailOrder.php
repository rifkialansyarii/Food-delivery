<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOrder extends Model
{
    protected $table = "detail_orders";
    protected $guarded = ["id"];
    protected $with = ["merchant", "menu"];

    function order(): BelongsTo {
        return $this->belongsTo(Order::class, "order_id", "id");
    }

    function menu(): BelongsTo {
        return $this->belongsTo(Menu::class, "menu_id", "id");
    }
    
    function merchant(): BelongsTo {
        return $this->belongsTo(Merchant::class, "merchant_id", "id");
    }

    function user(): BelongsTo {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    function driver(): BelongsTo {
        return $this->belongsTo(User::class, "driver_id", "id");
    }
}
