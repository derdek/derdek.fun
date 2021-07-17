<?php
namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Category;
use App\Models\Link;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

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
        $program = Program::find($id)
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
}
