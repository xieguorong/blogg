<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Artical extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'artical';
    protected $primaryKey = 'art_id';
    public $timestamps = false;
    protected $guarded=[];//排除不能填充的字端



}
