<?php

namespace App\Http\Controllers;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->category = new TrainingCategory();
    }


    public function createCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);

        $parameters = $request->all();
        $response = $this->category->createCategory($parameters);
        if ($response != false) {
            return response()->json($response, 200);
        } else {
            return response()->json("Training Category With Name Exists Already", 409);
        }
    }

    public function allCategories()
    {
        $response = $this->category->allCategories();
        return response()->json($response, 200);
    }


}
