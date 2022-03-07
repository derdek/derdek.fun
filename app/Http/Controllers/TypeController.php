<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function getTypes(){
        return view('types.dashboard', [
            'types' => Type::select('*')
                ->simplePaginate(15),
        ]);
    }
    
    public function getType($id){
        return view('types.edit', [
            'type' => Type::where('id', $id)->first(),
        ]);
    }
    
    public function updateType(Request $request, $id){
        $validated = $request->validate([
            'type-name' => 'required|max:255',
        ]);
        
        $type = Type::where('id', $id)->first();
        
        $type->name = $request->post('type-name');
        $type->save();
        
        return redirect()->route('type', $id);
    }
}
