<!DOCTYPE html>
<html lang="en">
<!-- HEAD TAG -->
<?php require_once("./components/head-tag.php") ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="" method="post" class="needs-validation">
                    <div class="col-md-6 col-md-offset-3 mt-5">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="email">Tên đăng nhập</label>
                                    <input type="text" class="form-control" name="user_name" placeholder="Nhập tên đăng nhập..." required>
                                </div>

                                <div class="form-group">
                                    <label for="pwd">Mật khẩu</label>
                                    <input required minlength="8" type="password" class="form-control" name="pass1" placeholder="Nhập mật khẩu...">
                                </div>

                                <div class="form-group">
                                    <label for="pwd">Nhập lại mật khẩu</label>
                                    <input required type="password" class="form-control" name="pass2" placeholder="Nhập lại mật khẩu...">
                                </div>

                                <div class="form-group">
                                    <label for="email">Tên đầy đủ của bạn</label>
                                    <input required type="text" class="form-control" name="full_name" placeholder="Nhập tên đầy đủ của bạn...">
                                </div>

                                <button type="submit" class="btn btn-default" name="dangky">Đăng ký</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <?php require_once("./components/footer.php"); ?>
            </div>
        </div>
    </div>
    <?php require_once("./components/script-tag.php"); ?>
</body>

</html>