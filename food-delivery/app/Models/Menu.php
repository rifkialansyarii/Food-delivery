<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    public function merchants(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'menu_id');
    }

    function driver(): BelongsTo {
        return $this->belongsTo(User::class, "driver_id", "id");
    }

    protected $table = 'menus'; // Nama tabel yang digunakan oleh model ini
    protected $guarded = ['id']; // Kunci primer tabel ini
    

    protected $fillable = [
        'merchant_id', // Asumsi ini adalah kolom yang mengacu pada Merchant ID
        'name',
        'price',
        'picture',
    ]; // Kolom yang dapat diisi secara massal
}
