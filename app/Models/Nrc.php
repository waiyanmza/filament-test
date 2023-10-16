<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nrc extends Model
{
    use HasFactory;

    public function infos(){
        return $this->hasMany(Info::class);
    }

    public $guarded = [];

}
