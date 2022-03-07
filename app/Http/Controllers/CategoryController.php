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
            'category' => Category::where('id', $id)->first(),
        ]);
    }
    
    public function updateCategory(Request $request, $id){
        $validated = $request->validate([
            'category-name' => 'required|max:255',
        ]);
        
        $category = Category::where('id', $id)->first();
        
        $category->name = $request->post('category-name');
        $category->save();
        
        return redirect()->route('category', $id);
    }
}
