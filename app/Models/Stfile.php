<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUser', 'name', 'description', 'options'
    ];
}
