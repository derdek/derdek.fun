<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Support\Facades\DB;
/**
 * Description of ProgramsController
 *
 * @author derdek
 */
class ProgramsController extends Controller
{
    public function getPrograms(){
        
        $programs = Program::select('programs.*', DB::raw('AVG(rate) as rating'))
                ->leftJoin('rates','rates.program_id','=','programs.id')
                ->groupBy('programs.id')
                ->with(['type','category'])
                ->simplePaginate(15);
        
        return view('programs.dashboard', ['programs' => $programs]);
    }
}
