<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="/static/js/jquery.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Message Board</title>

</head>
<body>

<table class="table table-striped">
    <caption>留言板</caption>
    <thead>
    <tr>
        <th>序号</th>
        <th>留言用户</th>
        <th>内容</th>
        <th>留言日期</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($data as $value){
            echo "<tr>";
            foreach ($value as $key => $item) {
                if ($key == "userId") {
                    continue;
                }
                echo "<td>";
                echo $item;
                echo "</td>";
            }

            echo "<td>";
            echo "<a href='/deleContent?id=".$value['id']."' onclick='return tokenChecking(".$value['userId'].")'><button type=\"button\" class=\"btn btn-primary btn-sm\" >删除留言</button></a>";
            echo "</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>

<div>
    <div class="col-lg-4">
        <label for="name">留言框</label>
        <textarea class="form-control " rows="5" id="content"></textarea>
        <br />
        <button type="button" class="btn btn-primary" id="submit">提交留言</button>
    </div>
</div>
</body>
</html>
<script>
    function tokenChecking(id){
        var flag = false;
        $.ajax({
            url:"/tokenChecking",
            type:"post",
            dataType:"json",
            async:false,
            headers:{
                Token:window.localStorage.getItem("token"),
            },
            success:function (data) {
                if (data.error == 0) {
                    if (id != data.data.id) {
                        alert("只能删除自身的留言！");
                    } else {
                        if (confirm("确定要删除该条留言吗")) {
                            alert("删除成功！");
                            flag = true;
                        }
                    }
                } else if (data.error == 1) {
                    alert("用户未登录，请先登陆");
                    window.location.href="/login";
                } else if (data.error == 2) {
                    window.localStorage.removeItem('token');
                    alert("非法token,请先登陆");
                    window.location.href="/login";
                } else {
                    window.localStorage.removeItem('token');
                    alert("token已过期,请重新登陆");
                    window.location.href="/login";
                }

            }
        });
        return flag;
    }
    $(function () {
        $("#submit").click(function () {
            $.ajax({
                url:"/tokenChecking",
                type:"post",
                dataType:"json",
                async:false,
                headers:{
                  Token:window.localStorage.getItem("token"),
                },
                success:function (data) {
                    if (data.error == 0) {

                        if ($("#content").val()=="") {
                            alert("留言不能为空");
                        } else {
                            $.ajax({
                                url: "/addContent",
                                type: "post",
                                dataType: "json",
                                data: {content: $("#content").val(), id: data.data.id, name: data.data.name},
                                async: false,
                                success: function (data) {
                                    if (data.error == 0) {
                                        alert("留言成功");
                                    } else {
                                        alert("留言失败");
                                    }
                                    window.location.href = "/";
                                }
                            });
                        }


                    } else if (data.error == 1) {
                        alert("用户未登录，请先登陆");
                        window.location.href="/login";
                    } else if (data.error == 2) {
                        window.localStorage.removeItem('token');
                        alert("非法token,请先登陆");
                        window.location.href="/login";
                    } else {
                        window.localStorage.removeItem('token');
                        alert("token已过期,请重新登陆");
                        window.location.href="/login";
                    }

                }
            });
        });
    });
</script>



