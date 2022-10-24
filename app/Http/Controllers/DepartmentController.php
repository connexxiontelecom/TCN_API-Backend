<?php

namespace App\Http\Controllers;

use App\Models\Department;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->department = new Department();
    }


    public function createDepartment(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'shortname' => 'required',
        ]);
        $parameters =  $request->all();
        $response =  $this->department->createDepartment($parameters);
        if($response !=false ){
            return response()->json($response, 200);
        }
        else{
            return response()->json("Department With Name Exists Already", 409);
        }
    }

    public function allDepartments(){
       $response = $this->department->allDepartments();
       return response()->json($response, 200);
    }


}
