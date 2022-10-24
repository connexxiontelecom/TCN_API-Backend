<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TrainingCategory extends Model
{
    public function createCategory(Array $parameters){

        if(!$this->isExisting($parameters['name']))
        {
            $category = new TrainingCategory();
            $category->name = $parameters['name'];
            $category->description = $parameters['description'];
            $category->type = $parameters['type'];
            $category->save();
            return $category;
        }
        else{
            return  false;
        }

    }

    public  function isExisting($category){
        $result = TrainingCategory::where(DB::raw('LOWER(name)'), '=', strtolower($category))->first();
        //table('departments')->where("name", $department)->first();
        if(!is_null($result))
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getCategory($id){
        $category =  TrainingCategory::find($id);
        return $category;
    }

    public function allCategories(){
        $categories = TrainingCategory::all();
        return $categories;
    }

}
