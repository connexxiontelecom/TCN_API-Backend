<?php

namespace App\Http\Controllers;
use App\Models\Permissions;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct()
    {

        $this->permissions = new Permissions();
    }

    public function getSystemPermissions(){
       $permissions =  $this->permissions->getSystemPermissions();
        return response()->json($permissions, 200);
    }


}
