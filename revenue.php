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
    <!-- Setup timzone cho dữ liệu datetime -->
    <?php
    date_default_timezone_set("Asia/Bangkok");
    ?>
    <!-- Kết nối database -->
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'qlnt');
    mysqli_set_charset($connect, "utf8");
    ?>
    <!-- Thực hiện query truy vấn ra được danh sách những phòng chưa trả tiền -->
    <?php 
    $arr_chuatratien = mysqli_query($connect, "
        SELECT
            phong.TenPhong,
            hopdong.NgayKetThuc,
            nguoithue.TenNguoiThue,
            phong.SoTienThue,
            phong.SoNuoc,
            phong.SoDien
        FROM
            `phong`,
            `nguoithue`,
            `hopdong`
        WHERE
            hopdong.NgayKetThuc > NOW() AND hopdong.IdPhong = phong.Id AND hopdong.IdNguoiThue = nguoithue.Id AND phong.Id NOT IN(
            SELECT
                hoadonthang.IdPhong
            FROM
                hoadonthang
            WHERE
                MONTH(hoadonthang.ThoiGian) = MONTH(NOW()))");
    ?>
    <!-- Thực hiện query truy vấn ra được danh sách những phòng đã trả tiền -->
    <?php
    $arr_thongke = mysqli_query($connect, "
        SELECT
            hoadonthang.TongTien,
            phong.TenPhong,
            nguoithue.TenNguoiThue,
            hoadondichvu.TienDien,
            hoadondichvu.TienNuoc,
            hoadondichvu.TienInternet,
            DATE(hoadonthang.ThoiGian) as ThoiGian,
            phong.SoTienThue
        FROM
            `hoadonthang`,
            `phong`,
            `nguoithue`,
            `hoadondichvu`
        WHERE
            MONTH(hoadonthang.ThoiGian) = MONTH(NOW()) AND hoadonthang.IdPhong = phong.Id AND hoadonthang.IdNguoiThue = nguoithue.Id AND hoadonthang.IdHdDichVu = hoadondichvu.Id
        ");
    $number_row = mysqli_num_rows($arr_thongke);
    ?>
    <?php
    function convert_number_to_words($number)
    {

        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
            0                   => 'Không',
            1                   => 'Một',
            2                   => 'Hai',
            3                   => 'Ba',
            4                   => 'Bốn',
            5                   => 'Năm',
            6                   => 'Sáu',
            7                   => 'Bảy',
            8                   => 'Tám',
            9                   => 'Chín',
            10                  => 'Mười',
            11                  => 'Mười một',
            12                  => 'Mười hai',
            13                  => 'Mười ba',
            14                  => 'Mười bốn',
            15                  => 'Mười năm',
            16                  => 'Mười sáu',
            17                  => 'Mười bảy',
            18                  => 'Mười tám',
            19                  => 'Mười chín',
            20                  => 'Hai mươi',
            30                  => 'Ba mươi',
            40                  => 'Bốn mươi',
            50                  => 'Năm mươi',
            60                  => 'Sáu mươi',
            70                  => 'Bảy mươi',
            80                  => 'Tám mươi',
            90                  => 'Chín mươi',
            100                 => 'trăm',
            1000                => 'ngàn đồng',
            1000000             => 'triệu đồng',
            1000000000          => 'tỷ đồng',
            1000000000000       => 'nghìn tỷ đồng',
            1000000000000000    => 'ngàn triệu triệu đồng',
            1000000000000000000 => 'tỷ tỷ đồng'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int)($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
    ?>
    <?php require_once('header.php') ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold">Phòng đã thu tiền</h5>
                            <h6 class="card-subtitle mb-12 text-muted blockquote-footer"><em>Số tiền thu được từ các
                                    phòng đã đóng tiền</em>
                            </h6>
                            <h5 class="text-right font-weight-bold">Tổng cộng đã thu được: <span class="text-success">
                                    <!-- Tính tổng tiền thu được -->
                                    <?php 
                                    $sum = 0;
                                    foreach ($arr_thongke as $arr) {
                                        $sum += $arr['TongTien'] + $arr["SoTienThue"];
                                    }
                                    echo number_format($sum) . ' ₫ </span></h5></br>';
                                    echo '<h6 class="text-right text-success font-italic">' . convert_number_to_words($sum) . '</h6>';
                                    ?>
                                    <hr>
                                    <div class="text-center">
                                        <table id="collectedTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Phòng</th>
                                                    <th>Tiền Phòng</th>
                                                    <th>Tiền Điện</th>
                                                    <th>Tiền Nước</th>
                                                    <th>Tiền Internet</th>
                                                    <th>Ngày thu tiền</th>
                                                    <th>Tiền đã thu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Đổ dữ liệu ra bảng -->
                                                <?php foreach ($arr_thongke as $arr) { ?>
                                                <tr class='clickable-row' data-href='details.php'>
                                                    <td><?php echo $arr["TenPhong"] ?></td>
                                                    <td><?php echo number_format($arr["SoTienThue"]) . ' ₫'; ?></td>
                                                    <td><?php echo number_format($arr["TienDien"]) . ' ₫'; ?></td>
                                                    <td><?php echo number_format($arr["TienNuoc"]) . ' ₫'; ?></td>
                                                    <td><?php echo number_format($arr["TienInternet"]) . ' ₫'; ?></td>
                                                    <td><?php echo $arr["ThoiGian"] ?></td>
                                                    <td class="text-danger font-weight-bold">
                                                        <?php
                                                        $tong =  $arr["TongTien"] + $arr["SoTienThue"];
                                                        echo number_format($tong) . ' ₫';;
                                                        ?>
                                                    </td>
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
        </div>
    </main>
    <hr>
    <footer class="container">
        <div class="footer-line">
            <p>Trường Đại Học Công Nghệ TP.Hồ Chí Minh (HUTECH)</p>
            <p>Khoa Công Nghệ Thông Tin</p>
            <p>Lớp : 15DTH13</p>
            <p>© 2019. Kiến Đình Khôi - Trần Đình Sơn - Lê Trương Kim Tài - Nguyễn Thị Thu Hiền</p>
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
            // Việt hóa datatable
            $('#no-collectedTable').DataTable({
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
            $('#collectedTable').DataTable({
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