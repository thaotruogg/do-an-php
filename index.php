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
    <?php require_once('header.php') ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-row">
                    <!-- Tầng + Phòng -->
                    <div class="col-10">
                        <div class="card">
                            <?php for ($i = 1; $i <= $total_record; $i++) { ?>
                                <div class="card-header label-floor">
                                    <i class="far fa-building text-primary"></i> Tầng <?php echo $i ?>
                                </div>

                                <?php
                                $arrs_phong = mysqli_query($connect, "select * from phong where idtang = $i");
                                ?>
                                <div class="card-body text-center">
                                    <?php while ($arr = mysqli_fetch_array($arrs_phong)) { ?>

                                        <?php $arrs_check_hopdong = mysqli_query($connect, "select * from hopdong where idphong = " . $arr["Id"] . " and ngayketthuc >= NOW()");
                                        $total_hopdong = 0;
                                        $total_hopdong = mysqli_num_rows($arrs_check_hopdong);
                                        ?>
                                        <?php if ($total_hopdong < 1) { ?>

                                            <a href="checkin.php?idphong=<?php echo $arr["Id"] ?>" class="btn btn-room btn-lg btn-success"><i class="fas fa-home"></i>
                                                <?php echo $arr["TenPhong"] ?>
                                                <br><em></em>
                                            </a>

                                        <?php
                                        } else { ?>

                                            <?php foreach ($arrs_check_hopdong as $arrHopDong) { ?>
                                                <?php
                                                $sub_date = strtotime($arrHopDong["NgayKetThuc"]) - strtotime(date("Y-m-d"));
                                                $datediff = $sub_date;
                                                $so_ngay_con_lai = floor($datediff / (60 * 60 * 24));
                                                ?>
                                                <a href="details.php?idphong=<?php echo $arr["Id"] ?>&idnguoithue=<?php echo $arrHopDong["IdNguoiThue"] ?>" class="btn btn-room btn-lg <?php if ($so_ngay_con_lai > 7) echo "btn-danger";
                                                                                                                                                                                        else echo "btn-warning"; ?>"><i class="fas fa-home"></i>
                                                    <?php echo $arr["TenPhong"] . "<br>" . $arrHopDong["TenNguoiThue"] ?>
                                                    <br> <em></em>
                                                </a>
                                            <?php
                                            } ?>
                                        <?php
                                        } ?>

                                    <?php
                                    } ?>
                                </div>
                            <?php
                            } ?>
                        </div>
                        <!-- Chú thích -->
                        <h6><em><i class="fas fa-info-circle text-primary"></i> <u>Chú thích:</u></em></h6>
                        <div>
                            <i class="fas fa-square text-success"></i>: Phòng trống
                            <i class="fas fa-square text-warning"></i>: Sắp hết hạn
                            <i class="fas fa-square text-danger"></i>: Đã có người thuê
                        </div>
                    </div>
                    <!-- Phí sinh hoạt -->
                    <div class="col-2" align="center">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-danger font-weight-bold">Phí sinh hoạt</h5>
                                <h6 class="card-subtitle mb-2 text-muted blockquote-footer">Tính theo định giá của nhà nước
                                </h6>
                                <?php
                                $arrs_dichvu = mysqli_query($connect, "
                                    select * from dichvu
                                ");
                                ?>

                                <table>
                                    <?php foreach ($arrs_dichvu as $arrDichVu) { ?>
                                        <tr>
                                            <td><strong>
                                                    <?php
                                                    if ($arrDichVu["TenDichVu"] == "Điện")
                                                        echo  '<i class="fas fa-bolt"></i>&nbsp;&nbsp;';
                                                    else if ($arrDichVu["TenDichVu"] == "Nước")
                                                        echo  '<i class="fas fa-tint"></i>&nbsp;&nbsp;';
                                                    else
                                                        echo  '<i class="fas fa-wifi"></i>';
                                                    ?>
                                                    <?php echo  $arrDichVu["TenDichVu"] ?>:</strong></td>
                                            <td>
                                                <span class="text-info">
                                                    <?php
                                                    if ($arrDichVu["TenDichVu"] == "Điện")
                                                        echo  '<span id="format-dien">' . $arrDichVu["SoTien"] . '</span>' . " /kWh";
                                                    else if ($arrDichVu["TenDichVu"] == "Nước")
                                                        echo  '<span id="format-nuoc">' . $arrDichVu["SoTien"] . '</span>' . " /m<sup>2</sup>";
                                                    else
                                                        echo  '<span id="format-wifi">' . $arrDichVu["SoTien"] . '</span>' . " /tháng";
                                                    ?>
                                                </span>
                                            </td>
                                        </tr>

                                    <?php
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <hr>
    <footer class="container">
        <div class="footer-line">
            <p>Trường Đại Học Công Nghệ TP.Hồ Chí Minh</p>
            <p>Khoa Công Nghệ Thông Tin</p>
            <p>Lớp: 16DTHJE1</p>
            <p>© 2020. Hoàng Trần Trí - Nguyễn Thị Kiều Thi - Trương Minh Thảo</p>
        </div>
    </footer>
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
            // Gán link cho tr của table
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
            // Format tiền dịch vụ niêm yết
            $("#format-wifi").text(formatNumber(parseInt($("#format-wifi").text()), '.', '.'));
            $("#format-dien").text(formatNumber(parseInt($("#format-dien").text()), '.', '.'));
            $("#format-nuoc").text(formatNumber(parseInt($("#format-nuoc").text()), '.', '.'));
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