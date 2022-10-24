<?php

namespace App\Http\Controllers;
use App\Models\Year;
use Illuminate\Http\Request;

class YearsController extends Controller
{

    public function __construct(){
        $this->year =  new Year();
    }

    public function  getYears(){

        return response()->json($this->year->years(),  200);
    }

}
