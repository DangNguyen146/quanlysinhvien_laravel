<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
       'idUser','title', 'content', 'idStfile',  'status'
    ];

    /*
    * Relationships
    */
    public function files()
    {
        return $this->hasMany('App\Models\Files', 'idPost');
    }
    public function stfile()
    {
        return $this->belongsto('App\Models\Stfile', 'idStfile');
    }
    public function user()
    {
        return $this->belongsto('App\Models\User', 'idUser');
    }
    public function getStarAttribute() {
        return $this->id;
    }


    public function toSearchableArray()
    {
        $array = array('title'=>$this->title, 'content'=>$this->content, 'status'=>$this->status);
        // $array = $this->only('title', 'content', 'status');
        return $array;
    }




    public function getImgUrlAttribute()
    {
        $img = $this->img;
        if($img) {
            return '/storage/'.$img->name;
        } else {
            return '/img/cover.png';
        }
    }
}
