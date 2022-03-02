<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Challenge extends Model
{
    use HasFactory;
    protected $fillable = [
       'idStfile','dapan', 'title', 'content',  'status', 'noidungfile'
    ];

    /*
    * Relationships
    */
    public function stfile()
    {
        return $this->belongsto('App\Models\Stfile', 'idStfile');
    }
    public function getStarAttribute() {
        return $this->id;
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
