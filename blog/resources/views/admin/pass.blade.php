<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div class="result_wrap">
    <div class="result_title">
        <h3>修改密码</h3>
        @if(count($errors) > 0)
            <div class="mark">
                @if(is_object($errors))
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
                    @else
                    <p>{{$error}}</p>
                    @endif
            </div>
        @endif
    </div>
</div>
<form action="" method="post">
    {{csrf_field()}}

    原密码：<input type="text" name="password_o"><br><br>
    新密码：<input type="password" name="password">6-20位 <br><br>
    确认密码：<input type="password" name="password_confirmation">与新密码保持一致
    <input type="submit" value="提交">

</form>
</body>
</html>