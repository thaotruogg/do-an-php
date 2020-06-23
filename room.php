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
    $connect = mysqli_connect('localhost', 'root', '', 'qlnt');
    mysqli_set_charset($connect, "utf8");
    ?>
    <!-- 
        Author: Khoi
        Date  : 21/03/2019 9:49 AM
        Task  : Làm chức năng thêm phòng
    -->
    <?php 
    if (isset($_POST["btnAddRoom"])) {
        $cmbFloor    = $_POST["cmbFloor"];
        $txtRoomName = $_POST["txtRoomName"];
        $txtPrice    = $_POST["txtPrice"];
        $txtWater    = $_POST["txtWater"];
        $txtElec     = $_POST["txtElec"];
        if ($cmbFloor == "1") {
            $tentang = "Tầng 1";
            $idTang  = 1;
        } else if ($cmbFloor == "2") {
            $tentang = "Tầng 2";
            $idTang  = 2;
        } else if ($cmbFloor == "3") {
            $tentang = "Tầng 3";
            $idTang  = 3;
        } else {
            $tentang = "Tầng 4";
            $idTang  = 4;
        }
        $result = mysqli_query($connect, "INSERT INTO `phong` (Id,TenPhong,IdTang,TenTang,SoDien,SoNuoc,SoTienThue) VALUES (NULL, '" . $txtRoomName . "', " . $idTang . ", '" . $tentang . "', " . $txtElec . ", " . $txtWater . ", " . $txtPrice . ")");
        if ($result) { }
    }
    ?>
    <!--  -->
    <?php 
    if (isset($_POST["btnSaveConfigChange"])) {
        $txtElectriConfig = $_POST["txtElectriConfig"];
        $txtWaterConfig = $_POST["txtWaterConfig"];
        $txtInternetConfig = $_POST["txtInternetConfig"];

        $result = mysqli_query($connect, "UPDATE `dichvu` SET `SoTien` = " . $txtElectriConfig . " WHERE `dichvu`.`Id` = 1");
        $result2 = mysqli_query($connect, "UPDATE `dichvu` SET `SoTien` = " . $txtWaterConfig . " WHERE `dichvu`.`Id` = 2");
        $result3 = mysqli_query($connect, "UPDATE `dichvu` SET `SoTien` = " . $txtInternetConfig . " WHERE `dichvu`.`Id` = 4");
    }
    ?>
    <?php
    $arrs_tang = mysqli_query($connect, "
            select * from tang
        ");
    $total_record = mysqli_num_rows($arrs_tang);
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
    $arr_thongke = mysqli_query($connect, "SELECT * FROM `phong`");
    $number_row = mysqli_num_rows($arr_thongke);
    ?>





    <?php require_once('header.php') ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Quản lý phòng</h5>
                            <h6 class="card-subtitle mb-12 text-muted blockquote-footer"><em>Các phòng đang hoạt động kinh doanh</em>
                            </h6>
                            <a href="#" class="btn btn-success float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Thêm phòng mới</a>
                            <hr style="margin-top:50px">
                            <div class="text-center" style="margin-top:50px">
                                <table id="roomTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tầng</th>
                                            <th>Tên phòng</th>
                                            <th>Giá thuê</th>
                                            <th>Nước hiện tại</th>
                                            <th>Điện hiện tại</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form action="<?php $_PHP_SELF ?>" method="post">
                                            <!-- Đổ dữ liệu ra bảng -->
                                            <?php foreach ($arr_thongke as $arr) {
                                                $idPhong = $arr["Id"] ?>
                                            <!-- 
                                                Author: Khoi
                                                Date  : 21/03/2019 11:06 AM
                                                Task  : Làm chức năng xóa phòng
                                            -->
                                            <?php 
                                            if (isset($_POST["btnDeleteRoom" . $arr["Id"]])) {
                                                mysqli_query($connect, "DELETE FROM `phong` WHERE `phong`.`Id` =" . $idPhong);
                                                echo '<script>location.reload();</script>';
                                            }
                                            ?>
                                            <!--  -->
                                            <tr class='clickable-row' data-href='details.php'>
                                                <td><?php echo $arr["TenTang"]; ?></td>
                                                <td><?php echo '<a href="#" data-toggle="modal" data-target="#editModal">' . $arr["TenPhong"] . '&nbsp;&nbsp;<i class="far fa-edit text-warning"></i></a>'; ?></td>
                                                <td><?php echo number_format($arr["SoTienThue"]) . ' ₫'; ?></td>
                                                <td><?php echo number_format($arr["SoDien"]); ?></td>
                                                <td><?php echo number_format($arr["SoNuoc"]); ?></td>
                                                <td><button name="btnDeleteRoom<?php echo $arr["Id"] ?>" type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button></td>
                                            </tr><?php 
                                                } ?>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Sửa -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalTitle">Sửa thông tin phòng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><i class="far fa-building"></i> Chọn tầng</label>
                                        <select class="form-control" name="cmbEditFloor" required>
                                            <option value="1" selected>Tầng 1</option>
                                            <option value="2">Tầng 2</option>
                                            <option value="3">Tầng 3</option>
                                            <option value="4">Tầng 4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-home"></i> Đặt tên phòng</label>
                                        <input type="text" name="txtEditRoomName" class="form-control" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-dollar-sign"></i> Nhập giá cho thuê</label>
                                        <input type="number" name="txtEditPrice" class="form-control" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-bolt"></i> Số Điện hiện tại</label>
                                        <input type="number" name="txtEditElec" class="form-control" required value="">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-tint"></i> Số Nước hiện tại</label>
                                        <input type="number" name="txtEditWater" class="form-control" required value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btnEditRoom" class="btn btn-warning" disabled><i class="far fa-save"></i> Chức năng đang phát triển</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Thêm -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="<?php $_PHP_SELF ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Thêm phòng mới</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><i class="far fa-building"></i> Chọn tầng</label>
                                        <select class="form-control" name="cmbFloor" required>
                                            <option value="1" selected>Tầng 1</option>
                                            <option value="2">Tầng 2</option>
                                            <option value="3">Tầng 3</option>
                                            <option value="4">Tầng 4</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-home"></i> Đặt tên phòng</label>
                                        <input type="text" name="txtRoomName" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-dollar-sign"></i> Nhập giá cho thuê</label>
                                        <input type="number" name="txtPrice" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-bolt"></i> Số Điện hiện tại</label>
                                        <input type="number" name="txtElec" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-tint"></i> Số Nước hiện tại</label>
                                        <input type="number" name="txtWater" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btnAddRoom" class="btn btn-success"><i class="far fa-save"></i> Thêm phòng</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
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
            // Việt hóa datatable
            $('#roomTable').DataTable({
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