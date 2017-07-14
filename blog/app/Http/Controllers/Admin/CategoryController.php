<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController{
    //get.admin/category
    public function index()
    {
       $category=(new Category)->tree();

        return view("admin/category/index")->with('data',$category);
    }

    public function changeOrder()
    {
        $input=Input::all();
        $cate=Category::find($input["cate_id"]);
        $cate->cate_order=$input['cate_order'];
        $re=$cate->update();
        if($re){
            $data=[
               'status'=>0,
                'msg'=>'分类排序成功'

            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'分类排序失败'

            ];
        }
        return $data;

    }
  //post.admin/category
    public function store()//添加分类
    {
        $input=Input::except('_token');
        $rules=[
            'cate_name'=>'required'
        ];
        $message=[
          'cate_name.required' =>'分类名称不能为空'
        ];
        $validate=Validator::make($input,$rules,$message);
        if($validate->passes()){
         $re= Category::create($input);
           if($re){
               return redirect('/admin/category');
           }else{
              return back()->with('errors','填充错误');
           }

            //刷新数据库由于有保护措施
        }else{
            return back()->withErrors($validate);
        }
        
    }
    //get.admin/create
    public function create()//增加匪类
    {
        $pid=Category::where('cate_pid',0)->get();

     return view('admin/category/create',compact('pid'));//compact传参

    }
    //get.admin/category/{category}
    public function show()
    {

    }
    //delete.admin/category/{category}
    public function destory($cate_id)//删除
    {
        $rows = Category::where('cate_id',$cate_id)->delete();
        if($rows){
            $data=[
                'status'=>0,
                'msg'=>'删除成功'

            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'删除失败'

            ];
        }
        return $data;
    }
    //put.admin/category/{category}
    public function update($cate_id)//修改以后更新分类
    {
      $input=Input::except('_method','_token');
        $re=Category::where('cate_id',$cate_id)->update($input);//更新到数据库
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类信息更新失败');
        }

    }
    //get.admin/category/
    public function edit($cate_id)
    {
        $pid=Category::where('cate_pid',0)->get();

        $field= Category::find($cate_id);
        return view('admin/category/edit',compact('field','pid'));
    }


}
?>