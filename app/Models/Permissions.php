<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permissions extends Model
{
    public function getPermissions($id){
        return Permissions::where('p_user_id', $id)->first();
    }

    public function getSystemPermissions(){
        return DB::getSchemaBuilder()->getColumnListing('permissions');
    }
}
