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
            'type' => Type::find($id)->first(),
        ]);
    }
}
