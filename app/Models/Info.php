<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    public $guarded = [];

    public function education(){
        return $this->hasMany(Education::class);
    }

    public function work_exp(){
        return $this->hasMany(Work_experience::class);
    }

    // public function familyy(){
    //     return $this->hasMany(Family::class);
    // }

    public function nrc(){
        return $this->belongsTo(NRC::class);
    }
    // public function nrccode(){
    //     return $this->belongsTo(NRCCode::class);
    // }
    // public function religion(){
    //     return $this->belongsTo(Religion::class);
    // }
    // public function vacancy(){
    //     return $this->belongsTo(Vacancy::class);
    // }

}
