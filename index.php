<?php
session_start();
?>
<!-- Kết nối database -->
<?php
$connect = mysqli_connect('localhost', 'root', '', 'qlnt');
mysqli_set_charset($connect, "utf8");
?>
<!-- 'start thực hiện kiểm tra dữ liệu người dùng đăng ký' -->
<?php
if (isset($_POST["dangky"])) {
    $user_name = $_POST["user_name"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $name = $_POST["full_name"];
    //kiểm tra xem 2 mật khẩu có giống nhau hay không:
    if ($pass1 != $pass2) {
        header("location:index.php?page=dangky");
        setcookie("error", "Đăng ký không thành công!", time() + 1, "/", "", 0);
    } else {
        $pass = md5($pass1);
        mysqli_query($connect, "
					insert into user (user_name,password,full_name)
					values ('$user_name','$pass','$name')
				");
        header("location:index.php?page=dangky");
        setcookie("success", "Đăng ký thành công!", time() + 1, "/", "", 0);
    }
}

?>
<!-- 'end thực hiện kiểm tra dữ liệu người dùng đăng ký' -->
<!-- 'start thực hiện kiểm tra dữ liệu người dùng nhập ở form đăng nhập' -->
<?php
if (isset($_POST["dangnhap"])) {
    $tk = $_POST["user_name_lg"];
    $mk = md5($_POST["passlg"]);
    $rows = mysqli_query($connect, "
				select * from user where user_name = '$tk' and password = '$mk'
			");
    $count = mysqli_num_rows($rows);
    if ($count == 1) {
        $_SESSION["loged"] = true;
        header("location:index.php");
        setcookie("success", "Đăng nhập thành công!", time() + 1, "/", "", 0);
    } else {
        header("location:index.php");
        setcookie("error", "Đăng nhập không thành công!", time() + 1, "/", "", 0);
    }
}
?>
<!-- 'end thực hiện kiểm tra dữ liệu người dùng nhập ở form đăng nhập' -->
<!-- 'start thực hiện đăng xuất' -->
<?php
if (isset($_GET["act"]) && $_GET["act"] == "logout") {
    unset($_SESSION["loged"]);
    header("location:index.php");
    setcookie("success", "Bạn đã đăng xuất!", time() + 1, "/", "", 0);
}
?>
<!-- end thực hiện đăng xuất -->
<!doctype html>
<html lang="vi">
<!-- HEAD TAG -->
<?php require_once("./components/head-tag.php") ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- 'start nếu xảy ra lỗi thì hiện thông báo:' -->
                <?php
                if (isset($_COOKIE["error"])) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Có lỗi!</strong> <?php echo $_COOKIE["error"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <!-- 'end nếu xảy ra lỗi thì hiện thông báo:' -->


                <!-- 'start nếu thành công thì hiện thông báo:' -->
                <?php
                if (isset($_COOKIE["success"])) {
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Chúc mừng!</strong> <?php echo $_COOKIE["success"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <!-- 'end nếu thành công thì hiện thông báo:' -->
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-between align-items-center">
                <a href="/" class="text-bold text-primary">Admin Page</a>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="index.php?page=dangky" class="text-primary text-bold mr-3">Tạo Admin mới</a>
                    <?php if (isset($_SESSION["loged"])) echo "<a href='index.php?act=logout' class='text-danger text-bold'>Đăng xuất</a>"; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    //nếu tồn tại biến $_GET["page"] = "dangky" thì gọi trang đăng ký:
    if (isset($_GET["page"]) && $_GET["page"] == "dangky")
        include "register.php";


    //nếu không tồn tại biến $_GET["page"] = "dangky"
    if (!isset($_GET["page"])) {
        //nếu tồn tại biến session $_SESSION["loged"] thì gọi nội dung trang admin.php vào
        if (isset($_SESSION["loged"]))
            include "admin.php";
        //nếu không tồn tại biến session $_SESSION["loged"] thì gọi nội dung trang login.php vào
        else
            include "login.php";
    }
    ?>
</body>

</html>