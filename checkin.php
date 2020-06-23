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
    <!-- Kết nối data base và lấy thông tin các dịch vụ -->
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'qlnt');
    mysqli_set_charset($connect, "utf8");

    ?>
    <!-- Lấy thông tin phòng từ id phòng -->
    <?php
    $get_thongtinphong = mysqli_query($connect, "
        select * from phong where id = " . $_GET["idphong"]);
    foreach ($get_thongtinphong as $ttphong) {
        $tenphong =  $ttphong["TenPhong"];
    }
    ?>
    <!-- 
        Xử lý sự kiện khi lick đăng ký:
        Thêm data vào bảng người thuê
        Thêm data vào bảng hợp đồng: mặc định ngày thuê = ngày hiện tại, ngày hết hạn: +2tháng
        Thêm vào bảng hợp đồng
        Di chuyển đến trang thông tin phòng sau khi đã đăng ký thành công
    -->
    <?php
    if (isset($_POST["btnRegis"])) {
        $txtName = $_POST["txtName"];
        $txtNameID = $_POST["txtNameID"];
        $txtPhone = $_POST["txtPhone"];
        $txtAddress = $_POST["txtAddress"];
        $idPhong = $_GET["idphong"];

        $result = mysqli_query($connect, "INSERT INTO `nguoithue`" . "(Id,TenNguoiThue,SDTNguoiThue,QueQuan,CMND) 
            VALUES (NULL,'" . $txtName . "','" . $txtPhone . "','" . $txtAddress . "','" . $txtNameID . "')");
        if ($result) {
            $user = mysqli_query($connect, "select * from nguoithue where TenNguoiThue='" . $txtName . "' and CMND='" . $txtNameID . "'");
            foreach ($user as $u) {
                $idUser = $u["Id"];
            }
            $hopdong = mysqli_query($connect, "INSERT INTO `hopdong` (`IdNguoiThue`,`TenNguoiThue`,`IdPhong`,`TenPhong`,`SoTienCoc`,`NgayBatDau`,`NgayKetThuc`)
                values (" . $idUser . ",'" . $txtName . "'," . $idPhong . ",'" . $tenphong . "',2000000,NOW(),ADDDATE(NOW(),INTERVAL 2 MONTH))
                ");
            header('Location: details.php?idphong=' . $idPhong . '&idnguoithue=' . $idUser);
        }
    }
    ?>
    <?php require_once('header.php') ?>
    <main>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home text-primary"></i> Trang
                            chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng ký thuê phòng</li>
                </ol>
            </nav>
            <form method="post" action="<?php $_PHP_SELF ?>">
                <div>
                    <div class="row">
                        <!-- Thông tin khách hàng -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-danger font-weight-bold">1) Điền thông tin khách hàng
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted blockquote-footer"><em>Người đại diện</em>
                                    </h6>
                                    <hr>
                                    <form>
                                        <div class="form-group">
                                            <label><i class="far fa-user"></i> Họ tên</label>
                                            <input type="text" class="form-control" name="txtName" placeholder="Nhập đầy đủ họ tên" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas fa-transgender"></i> Giới tính</label>
                                            <select name="cmbGender" class="form-control" required>
                                                <option>Nam</option>
                                                <option>Nữ</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="far fa-id-card"></i> Số CMND / Hộ chiếu</label>
                                            <input name="txtNameID" type="number" class="form-control" placeholder="Căn cứ theo số hiệu ghi trên thẻ" required>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                                            <input name="txtPhone" type="number" class="form-control" placeholder="Số điện thoại liên lạc của người thuê" required>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas fa-map-marked-alt"></i> Địa chỉ</label>
                                            <textarea name="txtAddress" rows="4" class="form-control" placeholder="Địa chỉ ghi trên CMND / Hộ chiếu" required></textarea>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Thông tin Phòng -->

                        <div class="col-md-6">
                            <div class="card panel-room-info-checkin">
                                <div class="card-body">
                                    <h5 class="card-title text-danger font-weight-bold">2) Điền thông tin Phòng</h5>
                                    <h6 class="card-subtitle mb-2 text-muted blockquote-footer"><em>Phòng chuẩn bị cho
                                            thuê</em></h6>
                                    <hr>
                                    <!-- Hiển thị ra thông tin phòng -->
                                    <?php foreach ($get_thongtinphong as $thong_tin_phong) { ?>
                                        <table>
                                            <tr>
                                                <td><strong><i class="fas fa-home"></i>
                                                        Phòng:</strong></td>
                                                <td>
                                                    <span class="text-primary">
                                                        <?php echo $thong_tin_phong["TenTang"] . " - Phòng " . $thong_tin_phong["TenPhong"] ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fas fa-file-invoice-dollar"></i>
                                                        &nbsp;Giá thuê:</strong></td>
                                                <td>
                                                    <span class="text-danger"><?php echo $thong_tin_phong["SoTienThue"] ?> /tháng</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fas fa-wifi"></i>
                                                        Internet: </strong></td>
                                                <td>
                                                    <span class="text-danger"><?php echo $tieninternet ?> /tháng</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fas fa-bolt"></i>
                                                        &nbsp;&nbsp;Giá Điện:</strong></td>
                                                <td>
                                                    <span class="text-danger"><?php echo $tiendien ?> /kWh
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong><i class="fas fa-tint"></i>
                                                        &nbsp;&nbsp;Giá nước:</strong></td>
                                                <td>
                                                    <span class="text-danger"><?php echo $tiennuoc ?> /m<sup>2</sup></span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="form-calculate">
                                            <div class="form-group">
                                                <label><i class="fas fa-tint"></i> Tiền cọc 1 tháng</label>
                                                <input name="txtDeposit" type="text" class="form-control" value="<?php echo $thong_tin_phong["SoTienThue"] ?>" readonly>
                                                <small class="form-text text-muted">Sẽ hoàn trả cho người thuê sau khi trả
                                                    phòng</small>
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fas fa-bolt"></i> Số Điện</label>
                                                <input name="txtCurrentElectric" type="number" class="form-control" value="<?php echo $thong_tin_phong["SoDien"] ?>" readonly>
                                                <small class="form-text text-muted">Số điên hiện tại(đơn vị: kwh)</small>
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fas fa-tint"></i> Số Nước</label>
                                                <input name="txtCurrentWater" type="number" class="form-control" value="<?php echo $thong_tin_phong["SoNuoc"] ?>" readonly>
                                                <small class="form-text text-muted">Số nước hiện tại(đơn vị: m<sup>2</sup>)
                                                </small>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <center>
                        <button name="btnRegis" type="submit" class="btn btn-lg btn-success"><i class="far fa-check-circle"></i> Bắt đầu
                            cho
                            thuê</button>
                        <a href="index.php" class="btn btn-default btn-lg"><i class="fas fa-times"></i> Hủy</a>
                    </center>
                </div>
            </form>
        </div>
    </main>
    <hr>
    <?php require_once("./components/footer.php"); ?>
    <script src="asset/js/jquery-3.3.1.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/custom.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Gán link cho tr của table
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
            // Việt hóa datatable
            $('#example').DataTable({
                "language": {
                    "sProcessing": "Chờ chút xíu...",
                    "sLengthMenu": "Xem _MENU_ phòng",
                    "sZeroRecords": "Không tìm thấy phòng tương ứng...",
                    "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ phòng",
                    "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 phòng",
                    "sInfoFiltered": "(được lọc từ _MAX_ câu hỏi)",
                    "sInfoPostFix": "",
                    "sSearch": "Tìm phòng:",
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
</body>

</html>