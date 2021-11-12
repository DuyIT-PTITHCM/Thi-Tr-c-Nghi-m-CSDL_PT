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
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Môn Học</th>
                            <th scope="col">Lần Thi</th>
                            <th scope="col">Số Câu Thi</th>
                            <th scope="col">Thời Gian</th>
                            <th scope="col">Ngày Thi</th>
                            <th scope="col">Giáo Viên Đăng Kí Thi</th>
                            <th scope="col">Thi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'SINHVIEN') {
                            $sql = "EXEC SP_LAY_DS_THI '" . $_SESSION['MASV'] . "'" . ",'" . $_SESSION['MALOP'] . "'";
                            $dsThi = KetNoiCSDL::goiSP($sql);
                            $cc = sqlsrv_next_result($dsThi);
                            
                            while ($row = sqlsrv_fetch_array($dsThi)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['TENMH'] . '</th>';
                                echo '<td>' . $row['LAN'] . '</td>';
                                echo '<td>' . $row['SOCAUTHI'] . '</td>';
                                echo '<td>' . $row['THOIGIAN'] . '</td>';
                                echo '<td>' . $row['NGAYTHI']->format('d-m-Y') . '</td>';
                                echo '<td>' . $row['TENGV'] . '</td>';
                                echo '<td>' .
                                '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/sv_thi.php?LANT=' . $row['LAN'] . '&MAMHT=' . $row['MAMH'] . '&MALOPT=' . $_SESSION['MALOP'] . '"><i class="fas fa-pen"></i></a>' .
                                '</td>';
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