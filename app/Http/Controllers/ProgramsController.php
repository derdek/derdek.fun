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
    public function getPrograms(Request $request){
        
        $search = $request->get('search');
        
        $programsQuery = Program::select('programs.*', DB::raw('AVG(rate) as rating'))
                ->leftJoin('rates','rates.program_id','=','programs.id')
                ->groupBy('programs.id')
                ->with(['type','categories']);
        
        if (auth()->guest() || !auth()->user()->can('edit programs')) {
            $programsQuery->whereNotNull('programs.published_at');
        }
        
        if(!empty($search)){
            $programsQuery->where('programs.name','like',"%$search%");
        }
        
        $programs = $programsQuery->simplePaginate(15);
        
        return view('programs.dashboard', ['programs' => $programs]);
    }
    
    public function getSortedPrograms(Request $request, $sortBy){
        
        [$sortColumn, $sortType] = explode('-', $sortBy);
        
        if (
                !in_array($sortColumn, ['categories','types','rating','programs'])
                || empty($sortColumn)
                || empty($sortType)
        ) {
            return route('programs');
        }
        
        $programsQuery = Program::select('programs.*', DB::raw('AVG(rate) as rating'), 'categories.name as category_name', 'types.name as type_name')
                ->leftJoin('rates','rates.program_id','=','programs.id')
                ->groupBy('programs.id')
                ->leftJoin('programs_categories', 'programs_categories.program_id','=','programs.id')
                ->leftJoin('categories', 'categories.id','=','programs_categories.category_id')
                ->leftJoin('types','types.id','=','programs.type_id')
                ->with('categories','type');
        
        if (auth()->guest() || !auth()->user()->can('edit programs')) {
            $programsQuery->whereNotNull('programs.published_at');
        }
        
        if($sortColumn == 'rating'){
            $programsQuery->orderBy($sortColumn, $sortType);
        }else{
            $programsQuery->orderBy("$sortColumn.name", $sortType);
        }
        
        $programs = $programsQuery->simplePaginate(15);
        
        return view(
                'programs.dashboard',
                [
                    'programs' => $programs,
                    'sortColumn' => $sortColumn,
                    'sortType' => $sortType
                ]
            );
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
                ->whereNotNull('programs.published_at')
                ->first();
        
        return view('programs.view', [
            'program' => $program,
        ]);
    }
    
    public function updateProgram(Request $request, $id){
        $validated = $request->validate([
            'program-name' => 'string|max:255',
            /*'links' => 'exists:link',
            'types' => 'exists:type',
            'categories' => 'exists:category',*/
        ]);
        
        $publish = $request->post('publish');
        $unpublish = $request->post('unpublish');
        $programName = $request->post('program-name');
        
        $program = Program::where('id', $id)
                ->first();
        
        if(!is_null($publish)){
            $program->published_at = date('Y-m-d H:i:s');
            $program->save();
            return redirect()->route('program', $id);
        }
        
        if(!is_null($unpublish)){
            $program->published_at = null;
            $program->save();
            return redirect()->route('program', $id);
        }
        
        if(!is_null($programName)){
            $program->name = $programName;
            $program->save();
            return redirect()->route('program', $id);
        }
        
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
