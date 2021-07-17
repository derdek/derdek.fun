<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    public function getLinks(){
        return view('links.dashboard', [
            'links' => Link::select('*')
                ->simplePaginate(15),
        ]);
    }
    
    public function getLink($id){
        return view('links.edit', [
            'link' => Link::find($id)->first(),
        ]);
    }
}
