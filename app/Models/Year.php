<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Support\Facades\DB;
class Year extends Model
{
    //
    protected $fillable = [
        'y_year'
    ];

    public function createYear($year){
        return Year::firstOrCreate(['y_year' =>$year]);
    }

    public function years(){
        return Year::all();
    }


}
