<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model

{
        protected  $fillable=['title','add_by','description','content','status','id']; //for create function to work
}
