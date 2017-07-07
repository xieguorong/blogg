<?php
namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;
class MainController extends CommonController{
    public function index()
    {
        return view("admin/main");
    }

}
?>