<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Artical;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticalController extends CommonController{
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(3);
        return view('admin/artical/index',compact($data));
    }
    public function create()//增加匪类
    {
        $pid=(new Category())->tree();

       return view('admin.artical.create',compact('pid'));
    }

    public function store()//存储
    {
      $input=Input::except('_token');
        $input['art_time']=time();
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required'
        ];
        $message=[
            'art_title.required'=>"文章名称不能为空",
            'art_content.required'=>'文章内容不能为空'
        ];

        $validator=Validator::make($rules,$message);

        if($validator->passes()) {
            $re = Artical::create($input);
            if ($re) {
                return redirect('admin/artical');
            } else {
                return back()->with('errors', '数据库更新失败，请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

}
?>