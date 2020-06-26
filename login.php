<!DOCTYPE html>
<html lang="en">
<!-- HEAD TAG -->
<?php require_once("./components/head-tag.php") ?>

<body>
<div class="container body-content body-login">
        <div class="container h-100">
            <div class="row h-100 justify-content-center">
                <form class="col-md-4 col-md-offset-4" method="post">
                    <div class="form-group" align="center">
                        <img src="/asset/img/ui/homeflat_106039.png" alt="" srcset="" class="my-4">
                        
                        <input type="phone" class="form-control my-2" placeholder="Tên đăng nhập" name="user_name_lg" id="user_name_lg" required autofocus>
                        <input type="password" class="form-control my-2" placeholder="Mật khẩu" name="passlg" id="passlg" required>
                    </div>
                    <p class="text-right text-danger" id="txtWrongPassword"><i></i></p>
                    <button name="dangnhap" type="submit" class="btn btn-primary" id="dangnhap">Đăng nhập</button>
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
                                    <button type="submit" id="btnRecover" class="btn btn-primary" disabled>Chức năng đang hoàn thiện</button>
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
    <?php require_once("./components/script-tag.php"); ?>
</body>

</html>