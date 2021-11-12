<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan Ly</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/gv.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="js/gv.js"></script>

    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- load header cho trang web  -->
    <?php
    include_once 'gvQuanLy.php';
    include_once 'KetNoiCSDL.php';
    ?>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <form action="" method="POST">
                <div class="modal-body" style="display: flex;">
                    <div class="form-group">
                        <label for="startDay">Ngày Bắt Đầu</label>
                        <input type="date" name="startDay" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="endDay">Ngày Kết Thúc</label>
                        <input type="date" name="endDay" class="form-control">
                    </div>
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" name="napDuLieu">Tải Dữ Liệu</button>
                    </div>
                </div>
            </form>

            <div class="col-12">
                <?php
                if (isset($_POST['napDuLieu'])) {
                    $date1 = date_create($_REQUEST['startDay']);
                    $date2 = date_create($_REQUEST['endDay']);
                    echo '<h3 style="text-align: center;">DANH SÁCH ĐĂNG KÝ THI TRẮC NGHIỆM CƠ SỞ 1 TỪ NGÀY ' . date_format($date1, "d/m/Y ") . ' ĐẾN NGÀY ' . date_format($date2, "d/m/Y") . '</h3>';
                }
                ?>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên Lớp </th>
                            <th scope="col">Tên Môn Học</th>
                            <th scope="col">Giảng Viên Đăng Ký</th>
                            <th scope="col">Số Câu Thi</th>
                            <th scope="col">Ngày Thi</th>
                            <th scope="col">Đã Thi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['napDuLieu']) && ($_SESSION["TENNHOM"] == 'TRUONG' || $_SESSION["TENNHOM"] == 'COSO')) {
                            $sqlRp3 = "EXEC SP_DanhSach_DK_Thi'" . $_REQUEST['startDay'] . "'" . ",'" . $_REQUEST['endDay'] . "'";
                            $dsRp3 = KetNoiCSDL::goiSP($sqlRp3);
                            $dem = 0;
                            while ($row = sqlsrv_fetch_array($dsRp3)) {
                                $dem += 1;
                                echo "<tr>";
                                echo '<td scope="col">' . $dem . '</th>';
                                echo '<td scope="col">' . $row['TENLOP'] . '</td>';
                                echo '<td scope="col">' . $row['TENMH'] . '</td>';
                                echo '<td scope="col">' . $row['TENGV'] . '</td>';
                                echo '<td scope="col">' . $row['SOCAUTHI'] . '</td>';
                                echo '<td scope="col">' . $row['NGAYTHI'] . '</td>';
                                echo '<td scope="col">' . $row['DATHI'] . '</td>';
                                echo "</tr>";
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>