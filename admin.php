<?php
// session_start();
?>
<!-- Kết nối database -->
<?php
$connect = mysqli_connect('localhost', 'root', '', 'qlnt');
mysqli_set_charset($connect, "utf8");
?>
<!doctype html>
<html lang="vi">
<!-- HEAD TAG -->
<?php require_once("./components/head-tag.php") ?>

<body>
    <div class="full-screen">
        <!-- Tải dữ liệu Dịch vụ điện, nước, internet -->
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
        $arrs_tang = mysqli_query($connect, "select * from tang");
        $total_record = mysqli_num_rows($arrs_tang);
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

        <?php require_once('header.php') ?>
        <main>
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <!-- Tầng + Phòng -->
                        <div class="col-lg-8 col-xl-8 col-md-7 col-sm-6">
                            <div class="card">
                                <?php for ($i = 1; $i <= $total_record; $i++) { ?>
                                    <div class="card-header label-floor text-bold text-primary">
                                        <i class="far fa-building text-primary mr-2"></i>TẦNG <?php echo $i ?>
                                    </div>

                                    <?php
                                    $arrs_phong = mysqli_query($connect, "select * from phong where idtang = $i");
                                    ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php while ($arr = mysqli_fetch_array($arrs_phong)) { ?>
                                                <?php $arrs_check_hopdong = mysqli_query($connect, "select * from hopdong where idphong = " . $arr["Id"] . " and ngayketthuc >= NOW()");
                                                $total_hopdong = 0;
                                                $total_hopdong = mysqli_num_rows($arrs_check_hopdong);
                                                ?>
                                                <?php if ($total_hopdong < 1) { ?>
                                                    <div class="col-3">
                                                        <a href="checkin.php?idphong=<?php echo $arr["Id"] ?>" class="btn btn-room-sm btn-success" style="font-size: 14px; width: 100%; height: 62px;"><i class="fas fa-home"></i>
                                                            <?php echo $arr["TenPhong"] ?>
                                                        </a>
                                                    </div>
                                                <?php
                                                } else { ?>

                                                    <?php foreach ($arrs_check_hopdong as $arrHopDong) { ?>
                                                        <?php
                                                        $sub_date = strtotime($arrHopDong["NgayKetThuc"]) - strtotime(date("Y-m-d"));
                                                        $datediff = $sub_date;
                                                        $so_ngay_con_lai = floor($datediff / (60 * 60 * 24));
                                                        ?>
                                                        <div class="col-3">
                                                            <a href="details.php?idphong=<?php echo $arr["Id"] ?>&idnguoithue=<?php echo $arrHopDong["IdNguoiThue"] ?>" style="font-size: 14px; width: 100%; height: 62px;" class="btn btn-room-sm <?php if ($so_ngay_con_lai > 7) echo "btn-danger";
                                                                                                                                                                                                                                                    else echo "btn-warning"; ?>"><i class="fas fa-home"></i>
                                                                <?php echo $arr["TenPhong"] . "<br>" . $arrHopDong["TenNguoiThue"] ?>
                                                            </a>
                                                        </div>
                                                    <?php
                                                    } ?>
                                                <?php
                                                } ?>

                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <!-- Phí sinh hoạt -->
                        <div class="col-lg-4 col-xl-4 col-md-5 col-sm-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title text-danger font-weight-bold text-center">Phí sinh hoạt</h5>
                                    <h6 class="card-subtitle mb-2 text-muted blockquote-footer">Tính theo định giá của nhà nước</h6>
                                    <h6 class="card-subtitle mb-2 text-muted blockquote-footer">Internet 5G</h6>
                                    <?php
                                    $arrs_dichvu = mysqli_query($connect, "select * from dichvu");
                                    ?>

                                    <table>
                                        <?php foreach ($arrs_dichvu as $arrDichVu) { ?>
                                            <tr>
                                                <td><strong>
                                                        <?php
                                                        if ($arrDichVu["TenDichVu"] == "Điện")
                                                            echo  '<i class="fas fa-bolt mr-3"></i>';
                                                        else if ($arrDichVu["TenDichVu"] == "Nước")
                                                            echo  '<i class="fas fa-tint mr-3"></i>';
                                                        else
                                                            echo  '<i class="fas fa-wifi mr-2"></i>';
                                                        ?>
                                                        <?php echo  $arrDichVu["TenDichVu"] ?>:</strong></td>
                                                <td>
                                                    <span class="text-info">
                                                        <?php
                                                        if ($arrDichVu["TenDichVu"] == "Điện")
                                                            echo  '<span id="format-dien" class="ml-2">' . $arrDichVu["SoTien"] . '</span>' . " /kWh";
                                                        else if ($arrDichVu["TenDichVu"] == "Nước")
                                                            echo  '<span id="format-nuoc" class="ml-2">' . $arrDichVu["SoTien"] . '</span>' . " /m<sup>2</sup>";
                                                        else
                                                            echo  '<span id="format-wifi" class="ml-2">' . $arrDichVu["SoTien"] . '</span>' . " /tháng";
                                                        ?>
                                                    </span>
                                                </td>
                                            </tr>

                                        <?php
                                        } ?>
                                    </table>
                                </div>
                            </div>
                            <!-- Chú thích -->
                            <h6><em><i class="fas fa-info-circle text-primary"></i> <u>Chú thích:</u></em></h6>
                            <div class="d-flex flex-column">
                                <span class="mr-3">
                                    <i class="fas fa-square text-success mr-2"></i> Phòng trống
                                </span>
                                <span class="mr-3">
                                    <i class="fas fa-square text-warning mr-2"></i> Sắp hết hạn
                                </span>
                                <span class="mr-3">
                                    <i class="fas fa-square text-danger mr-2"></i> Đã có người thuê
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <hr>
        <?php require_once("./components/footer.php"); ?>
    </div>
    <?php require_once("./components/script-tag.php"); ?>

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