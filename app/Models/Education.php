<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    public $guarded = [];

    public function infos(){
        return $this->hasMany(Info::class);
    }
}
