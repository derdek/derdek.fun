<?php
namespace App\Http\Controllers;

use Auth;
use App\Models\Program;
use App\Models\Category;
use App\Models\Link;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function getPrograms(){
        
        $programs = Program::select('programs.*', DB::raw('AVG(rate) as rating'))
                ->leftJoin('rates','rates.program_id','=','programs.id')
                ->groupBy('programs.id')
                ->with(['type','categories'])
                ->simplePaginate(15);
        
        return view('programs.dashboard', ['programs' => $programs]);
    }
    
    public function getProgram($id){
        $program = Program::where('id', $id)
                ->with(['type', 'categories', 'links'])
                ->first();
        
        $categories = Category::all();
        $types = Type::all();
        $links = Link::all();
        return view('programs.edit', [
            'program' => $program, 
            'categories' => $categories, 
            'types' => $types,
            'links' => $links,
        ]);
    }
    
    public function getProgramView($id){
        $program = Program::where('id', $id)
                ->with(['type', 'categories', 'links'])
                ->first();
        
        return view('programs.view', [
            'program' => $program,
        ]);
    }
    
    public function updateProgram(Request $request, $id){
        $validated = $request->validate([
            'program-name' => 'required|max:255',
            /*'links' => 'exists:link',
            'types' => 'exists:type',
            'categories' => 'exists:category',*/
        ]);
        
        
        $program = Program::where('id', $id)
                ->first();
        
        $program->name = $request->post('program-name');
        $program->save();
        
        return redirect()->route('program', $id);
    }
    
    public function createProgram(Request $request){
        $validated = $request->validate([
            'program-name' => 'required|string|max:255',
            'type' => 'exists:types,id',
        ]);
        
        $program = new Program();
        
        $program->name = $request->post('program-name');
        $program->type_id = $request->post('type');
        $program->user_id = auth()->user()->id;
        $program->save();
        $program->refresh();
        
        return redirect()->route('programView', $program->id);
    }
    
    public function getCreateProgram(){
        $types = Type::all();
        
        return view('programs.create', [
            'types' => $types,
        ]);
    }
}
