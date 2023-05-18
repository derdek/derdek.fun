<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function getTypes(){
        $types = Type::select('*')
            ->simplePaginate(15);

        return view(
            'types.dashboard',
            [
                'types' => $types,
            ]
        );
    }

    public function getType($id){
        $type = Type::where('id', $id)
            ->first();

        return view(
            'types.edit',
            [
                'type' => $type,
            ]
        );
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
