<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="/static/js/jquery.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Login</title>

</head>
<body>
<div style="text-align: center">
    <h1>用户登录</h1>
    <div class="input-group" style="width: 400px;margin:20px auto;">
        <span class="input-group-addon">👒</span>
        <input type="text" id="user_name" class="form-control" placeholder="请输入账号">
    </div>

    <div class="input-group" style="width: 400px;margin:20px auto;">
        <span class="input-group-addon">🔑</span>
        <input type="password" id="password" class="form-control" placeholder="请输入密码">
    </div>
    <div style="width: 400px;margin:20px auto;">
        <button type="button" id="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;立即登陆&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
    </div>
</div>


<div id="test">

</div>
</body>
</html>


<script>
    $(function () {
        $("#submit").click(function () {
            $.ajax({
                url:"/loginChecking",
                type:"post",
                dataType:"json",
                async:false,
                data:{name:$("#user_name").val(), password:$("#password").val()},

                success:function (data) {
                    if (data.status == 200) {
                        alert("登陆成功！");
                        window.localStorage.setItem("token", data.token);
                        window.location.href="/";

                    } else {
                        alert("账号或密码有误，请重新登陆！");
                        window.location.href="/login";
                    }
                }
            });
        });
    });
</script>
