<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Project::create([
            'name'=>'أضاحي'
        ]);
        \App\Project::create([
            'name'=>'طرود'
        ]);
        \App\Project::create([
            'name'=>'كسوة'
        ]);
    }
}
