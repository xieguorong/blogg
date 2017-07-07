<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
class CategoryController extends CommonController{
    //get.admin/category
    public function index()
    {
       $category=Category::all();
        return view("admin/category/index")->with('data',$category);
    }
  //post.admin/category
    public function store()
    {
        
    }
    //get.admin/create
    public function create()
    {

    }
    //get.admin/category/{category}
    public function show()
    {

    }
    //delete.admin/category/{category}
    public function destory()
    {

    }
    //put.admin/category/{category}
    public function update()
    {

    }
    //get.admin/category/
    public function edit()
    {

    }


}
?>