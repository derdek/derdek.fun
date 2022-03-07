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
            'link' => Link::where('id', $id)->first(),
        ]);
    }
    
    public function updateLink(Request $request, $id){
        $validated = $request->validate([
            'link-title' => 'required|max:255',
            'link-url' => 'required|max:255',
        ]);
        
        $link = Link::where('id', $id)->first();
        
        $link->title = $request->post('link-title');
        $link->link = $request->post('link-url');
        $link->save();
        
        return redirect()->route('link', $id);
    }
}
