<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded=[];//排除不能填充的字端

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function tree()
    {
        $category=$this->orderBy("cate_order","asc")->get();
       return $this->getTree($category,'cate_id','cate_name','cate_pid',0);
    }
//    public static function tree()
//    {
//        $category=Category::all();
//        return (new Category)->getTree($category,'cate_id','cate_name','cate_pid',0);
//    }
    public function getTree($data,$field_id,$field_name,$field_pid,$pid)
    {
        $arr=array();
        foreach ($data as $k => $v) {
            if ($v->$field_pid==$pid) {
                $data[$k]["_".$field_name]=$data[$k][$field_name];
                $arr[] = $data[$k];

                foreach ($data as $m => $n) {
                    if ($n->$field_pid == $v->$field_id) {
                        $data[$m]["_".$field_name]="ㅏㅡ".$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }

        }
        return $arr;
    }

}
