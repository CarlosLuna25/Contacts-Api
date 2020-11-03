<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
   protected $table= 'directorios';
   protected  $fillable = [
    'name', 'direction','phone', 'email', 'photo_path',
    ];
}
