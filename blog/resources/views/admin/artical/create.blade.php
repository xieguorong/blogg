@extends('layouts.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加文章首页
</div>
<!--面包屑导航 结束-->
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
        @if(count($errors) > 0)
            <div class="mark">
                @foreach($errors->all() as $e)
                    {{$e}}
                @endforeach
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增文章</a>
            <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部文章</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/artical')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>父分类：</th>
                <td>
                    <select name="cat_id">

                        @foreach($pid as $p)
                        <option value="{{$p->cate_id}}">{{$p->_cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <th><i class="require">*</i>文章标题：</th>
                <td>
                    <input type="text" class="lg" name="art_title">
                </td>
            </tr>
            <tr>
                <th>文章编辑：</th>
                <td>
                    <input type="text" class="sm" name="art_editor">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>文章缩略图：</th>
                <td>
                    <script src="/front/org/uploadify/jquery.uploadify.min.js" ></script>
                    <link rel="stylesheet" type="text/css" href="/front/org/uploadify/uploadify.css">
                    <input type="text" class="lg" name="art_thumb">
                    <input id="file_upload" name="file_upload" type="file" multiple="true">

                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <img src="" alt="" id="art_thumb_img" style="max-width:350px;max-height:100px">
                </td>
            </tr>

            <tr>
                <th>文章关键字：</th>
                <td>
                    <input type="text" class="lg" name="art_tag">
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="art_description"></textarea>
                </td>
            </tr>

            <tr>
                <th>文章内容：</th>
                <td>
                    <script type="text/javascript" charset="utf-8" src="/front/org/ueditor/ueditor.config.js"></script>
                    <script type="text/javascript" charset="utf-8" src="/front/org/ueditor/ueditor.all.min.js"> </script>
                    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                    <script type="text/javascript" charset="utf-8" src="/front/org/ueditor/lang/zh-cn/zh-cn.js"></script>
                    <script id="editor" type="text/plain" name="art_content" style="width:1024px;height:500px;"></script>
                    <script>
                        var ue = UE.getEditor('editor');
                    </script>

                </td>
            </tr>
            {{--cate_order--}}

            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadify({
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     : "{{csrf_token()}}"
            },
            'swf'      : '{{'/front/org/uploadify/uploadify.swf'}}',
            'uploader' :'{{url('/admin/upload')}}',
            'onUploadSuccess' : function(file, data, response) {
               $("input[name=art_thumb]").val(data);
                $('#art_thumb_img').attr('src',data);
            }
        });
    });
</script>
@endsection


