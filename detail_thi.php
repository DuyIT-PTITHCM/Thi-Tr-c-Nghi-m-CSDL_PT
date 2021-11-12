<?php
session_start();
include_once 'KetNoiCSDL.php';
if (!isset($_SESSION['TENNHOM'])) {
    header('Location: http://localhost/CSDL_PT/index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan Ly Giao Vien Theo Khoa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <div class="col-12">
                <h2 style="text-align: center;"> Chi Tiết Thi </h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Câu Số</th>
                            <th scope="col">Nội Dung</th>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">Đã Chọn</th>
                            <th scope="col">Đáp Án</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'SINHVIEN') {
                            $sql = "EXEC TAI_KQ_THI_CT '" . $_REQUEST['ct_thi'] . "'";
                            $ctThi = KetNoiCSDL::goiSP($sql);
                            $dem= 0;
                            while ($row = sqlsrv_fetch_array($ctThi)) {
                                $dem+=1;
                                echo "<tr>";
                                echo '<td scope="col">' . $dem . '</th>';
                                echo '<td scope="col">' . $row['NOIDUNG'] . '</td>';
                                echo '<td scope="col">' . $row['A'] . '</td>';
                                echo '<td scope="col">' . $row['B'] . '</td>';
                                echo '<td scope="col">' . $row['C'] . '</td>';
                                echo '<td scope="col">' . $row['D'] . '</td>';
                                echo '<td scope="col">' . $row['DACHON'] . '</td>';
                                echo '<td scope="col">' . $row['DAPAN'] . '</td>';
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