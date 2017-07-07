<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>main</title>

    <!-- Bootstrap -->
    <link href="/front/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/front/css/rightmain.css">
      {{--<link rel="stylesheet" type="text/css" href="/front/css/index.css">--}}
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 illu">
                <dl>
                    <dt>我的个人信息</dt>
                    <dd>
                        <ul>
                            <li>你好，</li>
                            <li>北京时间:<?php echo date('Y年m月d日h时m分s秒')?></li>
                            {{--<li>上次登录IP：0.0.0.0 </li>--}}
                        </ul>
                    </dd>
                </dl> 

        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 illu">
                <dl>
                    <dt>信息统计</dt>
                    <dd>
                        <ul>
                            <li>会员数：20000</li>
                            <li>文章数：10000</li>
                            <li>评论数：50002</li>
                            <li>商品数：50002</li>
                        </ul>
                    </dd>
                </dl>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 illu">
                <dl>
                    <dt>系统信息</dt>
                    <dd>
                        <ul>
                            <li>程序版本：V1.0 [20150610]</li>
                            <li>操作系统：WINNT</li> 
                            <li>服务器软件：{{$_SERVER['SERVER_SOFTWARE']}}</li>
                            <li>MySQL 版本：5.5.40</li>
                            <li>最大上传限制：<?PHP echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"?></li>
                        </ul>
                    </dd>
                </dl>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 illu">
                <dl>
                    <dt>网站信息</dt>
                    <dd>
                        <ul>
                            <li>版权所有：XXXX系统</li>
                            <li>官方网站：http://www.mycodes.net</li>
                            <li>官方论坛：http://bbs.xxx.com</li>
                        </ul>
                    </dd>
                </dl>
        </div>
      </div>
      <!-- 第一行结束 -->

    </div>
    <!-- 整个容器结束 -->
    <script src="/front/public/js/jquery-3.1.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/front/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      //alert($)
    </script>
  </body>
</html>