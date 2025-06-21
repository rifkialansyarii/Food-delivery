<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'merchant_id');
    }

    protected $table = 'merchants'; // Nama tabel yang digunakan oleh model ini
    protected $guarded = ['id']; // Kunci primer tabel ini

    protected $fillable = [
        'name',
        'address',  
        'phone',
        'picture',
    ]; // Kolom yang dapat diisi secara massal

    function order(): HasMany {
        return $this->hasMany(Order::class, "merchant_id", "id");
    }
}
