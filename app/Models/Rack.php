<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;

    protected $fillable = ['rack_name'];

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
}
