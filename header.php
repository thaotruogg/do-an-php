<?php
$connect = mysqli_connect('localhost', 'root', '', 'qlnt');
mysqli_set_charset($connect, "utf8");
$arr_dichvu = mysqli_query($connect, "select * from dichvu where id = 1");
foreach ($arr_dichvu as $dien) {
    $tiendien = $dien["SoTien"];
}
$arr_dichvu2 = mysqli_query($connect, "select * from dichvu where id = 2");
foreach ($arr_dichvu2 as $nuoc) {
    $tiennuoc = $nuoc["SoTien"];
}
$arr_dichvu3 = mysqli_query($connect, "select * from dichvu where id = 4");
foreach ($arr_dichvu3 as $internet) {
    $tieninternet = $internet["SoTien"];
}
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo/Brand -->
            <a class="navbar-brand d-flex align-items-center text-bold" href="/">
                <img src="./asset/img/ui/homeflat_106039.png" width="48" height="auto" class="d-inline-block align-top" alt="">
                <span class="ml-3">HOME ViLANDS</span>
            </a>

            <!-- Nút chức năng của Mobile -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Thanh Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link hover-links" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link hover-links" href="room.php">Quản lý phòng</a>
                    </li>
                    <li class="nav-item active">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#configModal">Điều chỉnh chi phí</a>
                        <!-- Modal thiết lập chi phí -->
                        <div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="configModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="index.php" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="configModalLabel">Điều chỉnh chi phí
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">

                                                <div class="form-group">
                                                    <label><i class="fas fa-bolt"></i> Giá Điện</label>
                                                    <input type="number" class="form-control" name="txtElectriConfig" placeholder="Nhập giá Điện mới (VD: 4000)" required>
                                                    <small class="form-text text-muted">Giá Điện cũ:
                                                        <span id="format-giadiencu"><?php echo number_format($tiendien) . ' ₫'; ?></span>
                                                        /kWh</small>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-tint"></i> Giá Nước</label>
                                                    <input type="number" class="form-control" name="txtWaterConfig" placeholder="Nhập giá Nước mới (VD: 16000)" required>
                                                    <small class="form-text text-muted">Giá Nước cũ:
                                                        <span id="format-giadiencu"><?php echo number_format($tiennuoc) . ' ₫'; ?></span>
                                                        /m<sup>2</sup></small>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fas fa-wifi"></i> Giá Internet</label>
                                                    <input type="number" class="form-control" name="txtInternetConfig" placeholder="Nhập giá Internet mới (VD: 120000)" required>
                                                    <small class="form-text text-muted">Giá Internet cũ:
                                                        <span id="format-giainternetcu"><?php echo number_format($tieninternet) . ' ₫'; ?></span>
                                                        /tháng</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button name="btnSaveConfigChange" type="submit" class="btn btn-success">Lưu
                                                thay đổi</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="revenue.php">Thống kê doanh thu</span></a>
                    </li>
                    <li class="nav-item active disable-block">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle btn-user" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user text-success"></i>
                                <?php
                                if (isset($_SESSION['User'])) {
                                    echo $_SESSION['User'];
                                } else {
                                    echo ' Guest';
                                }
                                ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fas fa-key text-primary"></i> Đổi
                                    mật
                                    khẩu</a>
                                <a class="dropdown-item" href="login_admin.php"><i class="fas fa-sign-out-alt text-danger"></i>
                                    Đăng xuất</a>
                            </div>
                            <!-- Modal đổi mật khẩu -->
                            <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModal"><i class="fas fa-key"></i> Đổi mật khẩu</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label>Mật khẩu hiện tại</label>
                                                        <input type="password" name="txtOldPassword" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mật khẩu mới</label>
                                                        <input type="password" name="txtNewPassword" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Xác nhận mật khẩu
                                                            mới</label>
                                                        <input type="password" name="txtRetypeNewPassword" class="form-control" required>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button name="btnSavePasswordChange" type="button" class="btn btn-success">Lưu thay đổi</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Quay lên đầu -->
    <a href="javascript:" id="return-to-top"><i class="far fa-arrow-alt-circle-up"></i></a>
</header>