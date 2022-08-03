<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "videos";
    protected $fillable = ['name', 'viwers'];
    // الاشياء التي ممكن اعمل عليها ترانسكشن في الداتابيز
    //protected $hidden =['created_at','updated_at']; // الاشياء يلي مابدي ارجعها من الداتابيز
   // use HasFactory;
   
   public $timestamps = false; // to prevent add default time to table offer
}
