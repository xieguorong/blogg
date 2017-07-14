@extends('layouts.admin')
@section('content')
    <meta name="_token" content=""/>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 全部分类
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('/admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href=""><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc" width="5%"><input type="checkbox" name=""></th>--}}
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名</th>
                        <th>标题</th>
                        <th>查看数</th>
                        <th>操作</th>
                    </tr>
                   @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" onchange="changeOrder(this,{{$v->cate_id}})" value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>{{$v->cate_title}}</td>
                            <td></td>
                            <td>
                                <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                                <a href="javsscript:void(0);" onclick="del({{$v->cate_id}});">删除</a>
                            </td>
                        </tr>

                 @endforeach
                </table>
                <div class="page_nav">
                    <div>
                        <a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
                        <a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
                        <span class="current">8</span>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
                        <a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
                        <a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
                        <span class="rows">11 条记录</span>
                    </div>
                </div>
                <div class="page_list">
                    <ul>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href ="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
       function changeOrder(obj,cate_id){
           var cate_order=$(obj).val();
           //发送异步请求
           $.post("{{url('admin/category/cateOrder')}}",{"_token":"{{csrf_token()}}","cate_id":cate_id,"cate_order":cate_order},function(data){
             if(data.status==0){
                 layer.msg(data.msg,{icon:6})
             }else{
                   layer.msg(data.msg,{icon:5})
               }
           })
       }
       function del(cate_id) {
           layer.confirm('您确定要删除这个分类吗？', {
               btn: ['确定','取消'] //按钮
           }, function(){
               $.ajax({
                   type:"DELETE",
                   url:"{{url('admin/category/')}}/"+cate_id,
                   data: {},
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                   },
                   dataType: "data",
                   success: function (data) {
                       if(data.status > 0){

                           //更新成功
                           location.href=location.href;
                           layer.alert(data.msg, {icon: 6});
                       }else{
                           layer.alert(data.msg, {icon: 5});
                       }
                       //alert(jsondata);
                   }
               });
//            layer.msg('的确很重要', {icon: 1});
           }, function(){
               //alert(456);
           });
       }
    </script>

@endsection

