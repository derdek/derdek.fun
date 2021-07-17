<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(){
        return view('categories.dashboard', [
            'categories' => Category::select('*')
                ->simplePaginate(15),
        ]);
    }
    
    public function getCategory($id){
        return view('categories.edit', [
            'category' => Category::find($id)->first(),
        ]);
    }
}
