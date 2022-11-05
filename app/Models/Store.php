<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
    protected $table = "stores";
    protected $connection = "mysql";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}