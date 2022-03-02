<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Files extends Model
{
    use HasFactory;
    protected $table = 'files';

    protected $fillable = [
        'idPost', 'idUser', 'idStfile', 'title', 'content', 'status', 'info'
    ];
    public function stfile()
    {
        return $this->belongsto('App\Models\Stfile', 'idStfile');
    }
    public function user()
    {
        return $this->belongsto('App\Models\User', 'idUser');
    }
    public function post()
    {
    	return $this->belongsto('App\Models\Posts', 'idPost' );
    }
    



    public function getInfoObjAttribute()
    {
        return $info = json_decode($this->info);
    }
    public function getImgUrlAttribute()
    {
        $txt = strtoupper($this->info_obj->extension);
        $ext = array('PNG','JPG','JPEG','BMP','MP4','3GP','AVI', 'FLV', 'MOV', 'GIF', 'PDF', 'DOC', 'DOCX', 'XLS', 'XLSX', 'PPT', 'PPTX');
        if(in_array($txt, $ext)) {
            return 'https://lh3.google.com/u/0/d/'.$this->idDrive.'=w300';
        }
            return 'https://dummyimage.com/300x150/E5E5E5/B5B5B5?text='.$txt;
    }
}
