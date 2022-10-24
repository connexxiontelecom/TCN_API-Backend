<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Department extends Model
{
    public function createDepartment(Array $parameters){

        if(!$this->isExisting($parameters['name']))
        {
            $dept = new Department();
            $dept->name = $parameters['name'];
            $dept->shortname = $parameters['shortname'];
            $dept->save();
            return $dept;
        }
        else{
            return  false;
        }

    }

    public  function isExisting($department){
        $result =  Department::where(DB::raw('LOWER(name)'), '=', strtolower($department))->first();
        //table('departments')->where("name", $department)->first();
        if(!is_null($result))
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getDepartment($id){
        $department =  Department::find($id);
        return $department;
    }

    public function allDepartments(){
       $departments = Department::all();
       return $departments;
    }

}
