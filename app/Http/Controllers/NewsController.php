<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function  all_news(Request $request){
      $all_news=News::all();
      return view('layout.all_news',compact('all_news'));

    }
    public function  insert_news(){
        $add=new News;
        $add->title=request('title');
        $add->add_by=request('add_by');
        $add->status=request('status');
        $add->description=request('description');
        $add->content=request('content');
        $add->id=request('id');
        $add->save();
        return redirect('all/news');

//      News::create(request()->all());    second method to insert data
//      News::create(['title'=>request('title'),'add_by'=>request('add_by')]);  third method to insert data called array data
        //for using create we must declare fallible in model to declare table
    }
    public function delete($id){
       $del= News::find($id);
       $del->delete();
        return redirect('all/news');
    }

}
