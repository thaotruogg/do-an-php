<!doctype html>
<html lang="vi">

<head>
    <title>Google House</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="asset/favicon.ico">
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/custom.css">
    <link rel="stylesheet" href="asset/css/all.css">
</head>
<?php
$connect = mysqli_connect('localhost', 'root', '', 'qlnt');
mysqli_set_charset($connect, "utf8");
?>
<?php

if (isset($_POST["btnLogin"])) {
    $txtAccount = $_POST["txtAccount"];
    $txtPassword = $_POST["txtPassword"];

    $result = mysqli_query($connect, "SELECT * FROM `user` WHERE user_name = '" . $txtAccount . "' AND password='" . $txtPassword . "'");
    $rows_count = mysqli_num_rows($result);
    // $getName = mysqli_query($connect,"SELECT `admin`.`Name` FROM `admin` WHERE `admin`.`UserName` = '" . $txtAccount . "' AND `admin`.`Passwords`='" . $txtPassword . "'");

    if ($rows_count >= 1) {
        foreach ($result as $user) {
            $name = $user["Name"];
        }
        $rows_count = 10;
        session_start();
        $_SESSION['User'] = $name;
        header('Location: index.php');
    } else {
        $thongbao = '* Sai mật khẩu';
        header('Location: login_admin.php');
    }
}
?>

<body>
    <div class="container body-content body-login">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <form class="col-md-4 col-md-offset-4" method="post" action="<?php $_PHP_SELF ?>">
                    <div class="form-group" align="center">
                        <img src="asset/img/ui/logo.gif" width="100%">
                        <br>
                        <input type="phone" class="form-control" placeholder="Tên đăng nhập" name="txtAccount" id="txtAccount" required autofocus>
                        <input type="password" class="form-control" placeholder="Mật khẩu" name="txtPassword" id="txtPassword" required>
                    </div>
                    <input type="checkbox" id="ckbRemember" name="ckbRemember">
                    <label for="ckbRemember">Tự động đăng nhập</label>
                    <p class="text-right text-danger" id="txtWrongPassword"><i></i></p>
                    <button name="btnLogin" type="submit" class="btn btn-success" id="btnLogin">Đăng nhập</button>
                    <a style="float:right;padding-top:10px" href="#"" class=" text-right" data-toggle="modal" data-target="#forgotPasswordModal">Quên mật khẩu ?</a>
                </form>
                <form method="post" onsubmit="$('#btnRecover').text('Đã gửi').attr('class','btn btn-success')">
                    <div style="top:20%"" class=" modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="forgotPasswordModalLabel">Khôi phục mật khẩu</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="email" class="form-control" required placeholder="Nhập địa chỉ email" name="email" autofocus>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="btnRecover" class="btn btn-primary">Khôi phục</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <?php require_once("./components/footer.php"); ?>
    </div>
    <script src="asset/js/jquery-3.3.1.min.js"> </script>
    <script src="asset/js/popper.min.js"> </script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/custom.js"> </script>
</body>

</html>