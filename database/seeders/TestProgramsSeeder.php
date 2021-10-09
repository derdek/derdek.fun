<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Program;
use App\Models\Type;
use App\Models\Rate;
use App\Models\Link;
use App\Models\Category;

class TestProgramsSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(3)->first();
        
        $typeProgram = Type::create([
            'user_id' => $user->id, 
            'name' => 'Program',
        ]);
        
        $typeBrowserExtension = Type::create([
            'user_id' => $user->id, 
            'name' => 'Browser extension',
        ]);
        
        $programAtom = Program::create([
            'name' => 'Atom',
            'type_id' => $typeProgram->id, 
            'user_id' => $user->id,
        ]);
        
        $programSponsorBlock = Program::create([
            'name' => 'Sponsor Block',
            'type_id' => $typeBrowserExtension->id, 
            'user_id' => $user->id,
        ]);
        
        $categoryProgramming = Category::create([
            'name' => 'Programming',
            'user_id' => $user->id,
        ]);
        
        $categoryForEveryDay = Category::create([
            'name' => 'For every day',
            'user_id' => $user->id,
        ]);
        
        $atomLinkSite = Link::create([
            'title' => 'Main site',
            'link' => 'https://atom.io/',
            'program_id' => $programAtom->id,
        ]);
        
        $sponsorBlockChrome = Link::create([
            'title' => 'Sponsor block Chrome',
            'link' => 'https://chrome.google.com/webstore/detail/sponsorblock-for-youtube/mnjggcdmjocbbbhaepdhchncahnbgone',
            'program_id' => $programSponsorBlock->id,
        ]);
        
        $sponsorBlockFirefox = Link::create([
            'title' => 'Sponsor block Firefox',
            'link' => 'https://addons.mozilla.org/ru/firefox/addon/sponsorblock/',
            'program_id' => $programSponsorBlock->id,
        ]);
        
        $programAtom->categories()->attach($categoryProgramming->id);
        
        $programSponsorBlock->categories()->attach($categoryForEveryDay->id);
        
        foreach(range(1, 10) as $rate){
            Rate::create([
                'program_id' => $programAtom->id, 
                'rate' => random_int(1, 5)
            ]);
        }
        
        foreach(range(1, 10) as $rate){
            Rate::create([
                'program_id' => $programSponsorBlock->id, 
                'rate' => random_int(1, 5)
            ]);
        }
    }
}
