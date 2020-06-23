<?php
        session_start();
    ?>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

</head>

<body>
    <?php
    date_default_timezone_set("Asia/Bangkok");
    ?>
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'qlnt');
    mysqli_set_charset($connect, "utf8");
    $arr_dichvu = mysqli_query($connect, "
                            select * from dichvu where id = 1
                        ");
    foreach ($arr_dichvu as $dien) {
        $tiendien = $dien["SoTien"];
    }
    $arr_dichvu2 = mysqli_query($connect, "
                            select * from dichvu where id = 2
                        ");
    foreach ($arr_dichvu2 as $nuoc) {
        $tiennuoc = $nuoc["SoTien"];
    }
    $arr_dichvu3 = mysqli_query($connect, "
                            select * from dichvu where id = 4
                        ");
    foreach ($arr_dichvu3 as $internet) {
        $tieninternet = $internet["SoTien"];
    }
    ?>
    
    <?php 
    $get_thongtinphong = mysqli_query($connect, "select * from phong where id = " . $_GET["idphong"]);
    foreach ($get_thongtinphong as $ttphong) {
        $tenphong =  $ttphong["TenPhong"];
        $tentang = $ttphong["TenTang"];
        $giathue = $ttphong["SoTienThue"];
        $sodien = $ttphong["SoDien"];
        $sonuoc = $ttphong["SoNuoc"];
    }
    $get_thongtinnguoithue = mysqli_query($connect, "select * from nguoithue where id = " . $_GET["idnguoithue"]);
    foreach ($get_thongtinnguoithue as $ttnguoithue) {
        $ten =  $ttnguoithue["TenNguoiThue"];
        $sdt = $ttnguoithue["SDTNguoiThue"];
        $diachi = $ttnguoithue["QueQuan"];
        $cmnd = $ttnguoithue["CMND"];
    }
    $get_thongtinhopdong = mysqli_query($connect, "select * from hopdong where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
    foreach ($get_thongtinhopdong as $tthopdong) {
        $hethopdong =  $tthopdong["NgayKetThuc"];
        $ngaybatdauhopdong = $tthopdong["NgayBatDau"];
    }
    ?>
    <?php 
    if (isset($_POST["btnGiaHan"])) {
        $txtNgayGiaHan = $_POST["txtNgayGiaHan"];
        $ngayhethan = date('Y-m-d', strtotime("+".$txtNgayGiaHan." months", strtotime($hethopdong)));
        $hethopdong = $ngayhethan;
        mysqli_query($connect,"UPDATE `hopdong` SET `NgayKetThuc` = '" . $ngayhethan . "' where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
    }
    ?>
    <?php 
    if (isset($_POST["btnTraPhong"])) {
        mysqli_query($connect,"UPDATE `hopdong` SET `NgayKetThuc` = NOW() where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
        header('Location: index.php');
    }
    ?>
    <?php 
    $idphong = $_GET["idphong"];
    $idnguoithue = $_GET["idnguoithue"];
    $thoigian = date("Y/m/d H:i:s");
    $kiemtrathanhtoan = mysqli_query($connect, "select * from hoadonthang where thoigian <= '" . $thoigian . "' and IdPhong = " . $idphong . " and IdNguoiThue = " . $idnguoithue . " and MONTH(thoigian)=MONTH('" . $thoigian . "')");
    if (isset($_POST["btnCalculate"])) {
        $sodienthangnay = $_POST["txtElectricOfThisMonth"];
        $sonuocthangnay = $_POST["txtWaterOfThisMonth"];
        $kiemtrathanhtoan = mysqli_query($connect, "select * from hoadonthang where thoigian <= '" . $thoigian . "' and IdPhong = " . $idphong . " and IdNguoiThue = " . $idnguoithue . " and MONTH(thoigian)=MONTH('" . $thoigian . "')");

        $tongtiendien = ($sodienthangnay - $sodien) * $tiendien;
        $tongtiennuoc = ($sonuocthangnay - $sonuoc) * $tiennuoc;
        $tongtien = $tongtiendien + $tongtiennuoc + $tieninternet;

        $result1 = mysqli_query($connect, "INSERT INTO `hoadondichvu`" . "(Id,IdPhong,IdNguoiThue,ThoiGian,TienDien,TienNuoc,TienInternet) 
            VALUES (NULL," . $idphong . "," . $idnguoithue . ",'" . $thoigian . "'," . $tongtiendien . "," . $tongtiennuoc . "," . $tieninternet . ")");
        if ($result1) {
            $arr_hddv = mysqli_query($connect, "select * from hoadondichvu where thoigian = '" . $thoigian . "' and IdPhong = " . $idphong . " and IdNguoiThue = " . $idnguoithue . "");
            foreach ($arr_hddv as $hddv) {
                $idhddv = $hddv["Id"];
            }
            $result1 = mysqli_query($connect, "INSERT INTO `hoadonthang`" . "(Id,IdPhong,IdNguoiThue,IdHdDichVu,ThoiGian,TongTien) 
                VALUES (NULL," . $idphong . "," . $idnguoithue . "," . $idhddv . ",NOW()," . $tongtien . ")");

            $result2 = mysqli_query($connect, "UPDATE `phong` SET `SoDien` = " . $sodienthangnay . ", SoNuoc = " . $sonuocthangnay . " WHERE `phong`.`Id` = " . $idphong);
        }
    }
    ?>
    
    <?php  //Change renter info
    if (isset($_POST["btnSaveInfoChange"])) { //check if btn pressed yet
        $txtName = $_POST["txtName"]; //get text from input
        $txtNameID = $_POST["txtNameID"];
        $txtPhone = $_POST["txtPhone"];
        $txtAddress = $_POST["txtAddress"];

        //database update query
        $name = mysqli_query($connect, "UPDATE `nguoithue` SET `TenNguoiThue` = '" . $txtName . "' WHERE `nguoithue`.`Id` = " . $_GET["idnguoithue"]);
        $nameId = mysqli_query($connect, "UPDATE `nguoithue` SET `CMND` = '" . $txtNameID . "' WHERE `nguoithue`.`Id` = " . $_GET["idnguoithue"]);
        $Phone = mysqli_query($connect, "UPDATE `nguoithue` SET `SDTNguoiThue` = '" . $txtPhone . "' WHERE `nguoithue`.`Id` = " . $_GET["idnguoithue"]);
        $Address = mysqli_query($connect, "UPDATE `nguoithue` SET `QueQuan` = '" . $txtAddress . "' WHERE `nguoithue`.`Id` = " . $_GET["idnguoithue"]);

        $hopdong = mysqli_query($connect, "UPDATE `hopdong` SET `TenNguoiThue` = '" . $txtName . "' where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
    }
    ?>
    <?php 
    $idphong = $_GET["idphong"];
    $idnguoithue = $_GET["idnguoithue"];
    $thoigian = date("Y/m/d H:i:s");
    $kiemtrathanhtoan = mysqli_query($connect, "select * from hoadonthang where thoigian <= '" . $thoigian . "' and IdPhong = " . $idphong . " and IdNguoiThue = " . $idnguoithue . " and MONTH(thoigian)=MONTH('" . $thoigian . "')");
    ?>
    <?php
    $arr_history = mysqli_query($connect, "
        SELECT 
            MONTH(hoadonthang.ThoiGian) AS Thang,
            phong.SoTienThue,
            hoadondichvu.TienDien,
            hoadondichvu.TienNuoc,
            hoadondichvu.TienInternet,
            hoadonthang.TongTien + phong.SoTienThue AS TongCong
        FROM 
            `hoadonthang`,
            `hoadondichvu`,
            `phong`
        WHERE

            hoadondichvu.Id = hoadonthang.IdHdDichVu AND MONTH(hoadonthang.ThoiGian) >= MONTH(NOW()) AND hoadonthang.IdNguoiThue = hoadondichvu.IdNguoiThue AND hoadondichvu.IdNguoiThue = " . $_GET["idnguoithue"] . " AND hoadonthang.IdPhong = phong.Id AND phong.Id = " . $_GET["idphong"] . "");
    ?>
    <?php 
    if (isset($_POST["btnGiaHanPhong"])) {
        $txtNgayGiaHan = $_POST["txtName"];

        mysqli_query($connect, "UPDATE `hopdong` SET `NgayKetThuc` = '" . $txtNgayGiaHan . "' where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
    }
    ?>
    <?php 
    if (isset($_POST["btnTraPhong"])) {


        mysqli_query($connect, "UPDATE `hopdong` SET `NgayKetThuc` = NOW() where `hopdong`.`IdNguoiThue` = " . $_GET["idnguoithue"] . " and `hopdong`.`IdPhong` = " . $_GET["idphong"]);
    }
    ?>
    
    <?php 
    $get_thongtinphong = mysqli_query($connect, "select * from phong where id = " . $_GET["idphong"]);
    foreach ($get_thongtinphong as $ttphong) {
        $tenphong =  $ttphong["TenPhong"];
        $tentang = $ttphong["TenTang"];
        $giathue = $ttphong["SoTienThue"];
        $sodien = $ttphong["SoDien"];
        $sonuoc = $ttphong["SoNuoc"];
    }
    $get_thongtinnguoithue = mysqli_query($connect, "select * from nguoithue where id = " . $_GET["idnguoithue"]);
    foreach ($get_thongtinnguoithue as $ttnguoithue) {
        $ten =  $ttnguoithue["TenNguoiThue"];
        $sdt = $ttnguoithue["SDTNguoiThue"];
        $diachi = $ttnguoithue["QueQuan"];
        $cmnd = $ttnguoithue["CMND"];
    }
    ?>
    <?php require_once('header.php') ?>
    <main>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home text-primary"></i> Trang
                            chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quản lý cho thuê</li>
                </ol>
            </nav>
            <div class="row">
                <!-- Thông tin khách hàng -->
                <div class="col-md-5">
                    <div class="card details-panel">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Thông tin khách hàng</h5>
                            <h6 class="card-subtitle mb-2 text-muted blockquote-footer"><em>Người đại diện</em></h6>
                            <hr>
                            <table class="user-info">
                                <tr>
                                    <td><strong><i class="far fa-user"></i>
                                            &nbsp;Họ tên:</strong></td>
                                    <td>
                                        <span class="text-success font-weight-bold"><?php echo $ten ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="far fa-id-card"></i>
                                            Số CMND:</strong></td>
                                    <td>
                                        <?php echo $cmnd ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-mobile-alt"></i>
                                            &nbsp;&nbsp;Số điện thoại:</strong></td>
                                    <td>
                                        <a href="tel:<?php echo $sdt ?>" class="text-danger"><?php echo $sdt ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-map-marked-alt"></i>
                                            &nbsp;Địa chỉ:</strong></td>
                                    <td>
                                        <?php echo $diachi ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-image"></i>
                                            &nbsp;Ảnh chân dung:</strong></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#userImageModal"><i class="far fa-eye"></i> Bấm để xem</a>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <div class="btnUserConfig">
                                <a href="tel:<?php echo $sdt ?>" class="btn btn-success"><i class="fas fa-phone-volume"></i> Gọi
                                    cho khách</a>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#editModal"><i class="fas fa-user-edit"></i> Chỉnh sửa
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Thông tin Phòng -->
                <div class="col-md-4">
                    <div class="card details-panel">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Thông tin Phòng</h5>
                            <h6 class="card-subtitle mb-2 text-muted blockquote-footer"><em>Phòng đang cho thuê</em>
                            </h6>
                            <hr>
                            <table>
                                <tr>
                                    <td><strong><i class="fas fa-home"></i>
                                            Phòng:</strong></td>
                                    <td>
                                        <span class="text-primary font-weight-bold"><?php echo $tentang . " - Phòng " . $tenphong ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-file-invoice-dollar"></i>
                                            &nbsp;Giá thuê:</strong></td>
                                    <td>
                                        <span class="text-dark"><span id="format-giathue"><?php echo $giathue ?></span>
                                        ₫ /tháng</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-wifi"></i>
                                            Internet: </strong></td>
                                    <td>
                                        <span class="text-dark"><span id="format-giainternet"><?php echo $tieninternet ?></span> ₫ /tháng</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-bolt"></i>
                                            &nbsp;&nbsp;Giá Điện:</strong></td>
                                    <td>
                                        <span class="text-dark"><span id="format-giadien"><?php echo $tiendien ?></span>
                                        ₫ /kWh
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-tint"></i>
                                            &nbsp;&nbsp;Giá nước:</strong></td>
                                    <td>
                                        <span class="text-dark"><span id="format-gianuoc"><?php echo $tiennuoc ?></span>
                                        ₫ /m<sup>2</sup></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-calendar"></i>
                                            &nbsp;&nbsp;Hết Hợp đồng:</strong></td>
                                    <td>
                                        <span class="text-danger"><?php echo date('d/m/Y', strtotime($hethopdong)); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-image"></i>
                                            &nbsp;&nbsp;Ảnh hợp đồng:</strong></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#convenantModal"><i class="far fa-eye"></i> Bấm để xem</a>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <button class="btn btn-danger" type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnRoomModal"><i class="fas fa-redo-alt"></i> Trả phòng</button>
                            <button class="btn btn-default" type="button" class="btn btn-primary" data-toggle="modal" data-target="#renewedModal"><i class="fas fa-sync"></i> Gia hạn</button>
                        </div>
                    </div>
                </div>
                <!-- Tính tiền tháng -->
                <div class="col-md-3">
                    <div class="card details-panel">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Thanh toán</h5>
                            <h6 class="card-subtitle mb-2 text-muted blockquote-footer"><em>Tính tiền phòng tháng
                                    này</em>
                            </h6>
                            <hr>
                            <div class="form-calculate">
                                <?php if (mysqli_num_rows($kiemtrathanhtoan) > 0) { ?>
                                <h5 class="text-success text-center" style="margin-top:10px"><i class="far fa-check-circle"></i> Đã thanh toán</h5>
                                <?php 
                            } else { ?>
                                <!-- Forrm thanh toan -->
                                <form method="post" action="<?php $_PHP_SELF ?>">
                                    <div class="form-calculate">
                                        <div class="form-group">
                                            <label><i class="fas fa-bolt"></i> Số Điện</label>
                                            <input name="txtElectricOfThisMonth" type="number" class="form-control" placeholder="Nhập số Điện" required>
                                            <small class="form-text text-muted">Số Điện tháng trước:
                                                <?php echo $sodien ?> /kWh</small>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas fa-tint"></i> Số Nước</label>
                                            <input name="txtWaterOfThisMonth" type="number" class="form-control" placeholder="Nhập số Nước" required>
                                            <small class="form-text text-muted">Số Nước tháng trước:
                                                <?php echo $sonuoc ?>
                                                m<sup>2</sup></small>
                                        </div>
                                    </div>
                                    <button name="btnCalculate" type="submit" class="btn btn-success" data-toggle="modal" data-target="#calculateModal"><i class=" fas fa-calculator"></i> Xác nhận thanh toán</button>
                                </form>
                                <?php 
                            } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Lịch sử thanh toán -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Lịch sử thanh toán</h5>
                            <h6 class="card-subtitle mb-12 text-muted blockquote-footer"><em>Bản ghi nhật ký đóng tiền
                                    qua các tháng</em>
                            </h6>
                            <hr>
                            <div class="text-center">
                                <table id="example" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tháng</th>
                                            <th>Tiền Phòng</th>
                                            <th>Tiền Điện</th>
                                            <th>Tiền Nước</th>
                                            <th>Tiền Internet</th>
                                            <th>Tổng cộng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($arr_history as $arr) { ?>
                                        <tr class='clickable-row' data-href='details.php'>
                                            <td><?php echo $arr["Thang"] ?></td>
                                            <td><?php echo number_format($arr["SoTienThue"]).' ₫';  ?></td>
                                            <td><?php echo number_format($arr["TienDien"]).' ₫'; ?></td>
                                            <td><?php echo number_format($arr["TienNuoc"]).' ₫'; ?></td>
                                            <td><?php echo number_format($arr["TienInternet"]).' ₫'; ?></td>
                                            <td class="text-danger font-weight-bold"><?php echo number_format($arr["TongCong"]).' ₫ </span>'; ?></td>
                                        </tr>
                                        <?php 
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="index.php"><i class="fa fa-arrow-left"></i> Trở về trang quản lý</a>
        </div>

        <!-- Modal ảnh chụp hợp đồng -->
        <div class="modal fade" id="convenantModal" tabindex="-1" role="dialog" aria-labelledby="convenantLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="convenantLabel">Ảnh chụp hợp đồng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="http://www.inmobiliariagurdian.com/wp-content/uploads/2018/10/mau-hop-dong-thu-nha-tro-moi-nhat-nam-2018.png" alt="Không tìm thấy ảnh" width="100%">
                    </div>
                    <div class="modal-footer">
                        <a href="http://www.inmobiliariagurdian.com/wp-content/uploads/2018/10/mau-hop-dong-thu-nha-tro-moi-nhat-nam-2018.png" class="btn btn-success"><i class="fas fa-download"></i> Tải xuống</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal ảnh chụp hợp đồng -->
        <div class="modal fade" id="userImageModal" tabindex="-1" role="dialog" aria-labelledby="userImageLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userImageLabel">Chân dung người thuê</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="https://kenh14cdn.com/2017/2373545713584488009515432111733942250897408n-1514196978625.jpg" alt="Không tìm thấy ảnh" width="100%">
                    </div>
                    <div class="modal-footer">
                        <a href="https://kenh14cdn.com/2017/2373545713584488009515432111733942250897408n-1514196978625.jpg" class="btn btn-success"><i class="fas fa-download"></i> Tải xuống</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Chỉnh sửa thông tin -->
        <div width="100%" class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Thay đổi thông tin khách hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="post" action="<?php $_PHP_SELF ?>">
                                <div class="form-group">
                                    <label><i class="far fa-user"></i> Họ tên</label>
                                    <input name="txtName" type="text" class="form-control" value="<?php echo $ten ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="far fa-id-card"></i> Số CMND / Hộ chiếu</label>
                                    <input name="txtNameID" type="number" class="form-control" value="<?php echo $cmnd ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                                    <input name="txtPhone" type="number" class="form-control" value="<?php echo $sdt ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-map-marked-alt"></i> Địa chỉ</label>
                                    <textarea name="txtAddress" rows="4" class="form-control" required><?php echo $diachi ?></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button name="btnSaveInfoChange" type="submit" class="btn btn-warning"><i class="far fa-save"></i> Lưu thay
                                        đổi</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal trả phòng -->
        <div class="modal fade" id="returnRoomModal" tabindex="-1" role="dialog" aria-labelledby="returnRoomLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnRoomLabel">Trả phòng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>Bạn có chắc chắn muốn trả phòng không ?</h6>
                    </div>
                    <form action="<?php $_PHP_SELF ?>" method="post">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="btnTraPhong"><i class="far fa-check-circle"></i> Xác nhận trả phòng</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal gia hạn -->
        <form action="<?php $_PHP_SELF ?>" method="post">
        <div class="modal fade" id="renewedModal" tabindex="-1" role="dialog" aria-labelledby="renewedLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
            
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="renewedLabel">Gia hạn</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select name="txtNgayGiaHan" class="form-control">
                            <option value="0">--Chọn tháng--</option>
                            <option value="1">1 tháng</option>
                            <option value="2">2 tháng</option>
                            <option value="3">3 tháng</option>
                            <option value="4">4 tháng</option>
                            <option value="5">5 tháng</option>
                            <option value="6">6 tháng</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="btnGiaHan">Đồng ý gia hạn</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>

                    </div>
                </div>

            </div>
        </div>
        </form>
    </main>
    <hr>
    <?php require_once("./components/footer.php"); ?>
    
    <script src="asset/js/jquery-3.3.1.min.js">
    </script>
    <script src="asset/js/popper.min.js">
    </script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/custom.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            //Định dạng tiền

            $("#format-giathue").text(formatNumber(parseInt(<?php echo $giathue ?>), '.', '.'));
            $("#format-giainternet").text(formatNumber(parseInt(<?php echo $tieninternet ?>), '.', '.'));
            $("#format-giadien").text(formatNumber(parseInt(<?php echo $tiendien ?>), '.', '.'));
            $("#format-gianuoc").text(formatNumber(parseInt(<?php echo $tiennuoc ?>), '.', '.'));

            // Việt hóa datatable
            $('#example').DataTable({
                "language": {
                    "sProcessing": "Chờ chút xíu...",
                    "sLengthMenu": "Xem _MENU_ bản ghi",
                    "sZeroRecords": "Không tìm thấy bản ghi tương ứng...",
                    "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ bản ghi",
                    "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ bản ghi)",
                    "sInfoPostFix": "",
                    "sSearch": "Tìm tháng:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Trang đầu",
                        "sPrevious": "Trang trước",
                        "sNext": "Trang kế",
                        "sLast": "Trang cuối"
                    }
                }
            });
        });
    </script>
    <script>
        // ===== Scroll to Top ==== 
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
                $('#return-to-top').fadeIn(200); // Fade in the arrow
            } else {
                $('#return-to-top').fadeOut(200); // Else fade out the arrow
            }
        });
        $('#return-to-top').click(function() { // When arrow is clicked
            $('body,html').animate({
                scrollTop: 0 // Scroll to top of body
            }, 500);
        });
    </script>
</body>

</html> 