<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    protected $table = 'customers'; // Nama tabel yang digunakan oleh model ini
    protected $guarded = ['id', ]; // Kunci primer tabel ini

    protected $fillable = [
        'name',
        'phone',
    ]; // Kolom yang dapat diisi secara massal
}
