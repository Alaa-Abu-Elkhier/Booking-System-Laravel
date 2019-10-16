<?php

use Illuminate\Database\Seeder;
use App\News;

class NewsDB extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<10;$i++){
            $add=new News;
            $add->title='new title'.rand(0,9);
            $add->add_by=1;
            $add->description='new description'.rand(0,9);;
            $add->content='new content'.rand(0,9);;
            $add->status='active';
            $add->save();

        }
    }
}
