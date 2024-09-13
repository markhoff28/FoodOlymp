<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Find the menu
    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id','id');
    }

    // Find the clients
    public function client(){
        return $this->belongsTo(Client::class, 'client_id','id');
    }
}
