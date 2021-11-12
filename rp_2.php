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
    if (isset($_POST['napServer']) && $_SESSION["TENNHOM"] == 'TRUONG') {
        unset($_SESSION['serverTaoTK']);
        $_SESSION['serverTaoTK'] = $_REQUEST['taiChiNhanh'];
    }

    ?>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            echo '<select class="form-control" name="taiChiNhanh">';
                            $ketNoi = new KetNoiCSDL();
                            $dataDs = $ketNoi->danhSachChiNhanh();
                            while ($row = sqlsrv_fetch_object($dataDs)) {
                                echo '<option value=' . $row->TENSERVER . '>' . $row->TENCN . '</option>';
                            }
                            echo '</select>';
                            echo '</div>
                            <div class="modal-footer border-top-0 d-flex">
                                <button type="submit" class="btn btn-success" name="napServer">Tải dữ liệu theo cơ sở</button>';
                        }
                        ?>
                    </div>
                </div>
            </form>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <?php
                        if (!isset($_POST['napServer']) && ($_SESSION["TENNHOM"] == 'COSO')) {
                            echo '<div class="modal-body" style="display: flex;">
                                    <div class="form-group" style="display: flex;">';
                            echo '<select class="form-control" name="MAMH" style="width: 250px;">';
                            $sql = "EXEC SP_DSMON";
                            $dsMonHoc = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                                echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                            }
                            echo '</select>';
                            echo '<select class="form-control" name="MALOP" style="width: 250px;">';
                            $sql = "EXEC SP_DSLOP";
                            echo $sql;
                            $dsLop = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_object($dsLop)) {
                                echo '<option value=' . $row->MALOP . '>' . $row->TENLOP . '</option>';
                            }
                            echo '</select>';


                            echo '<select class="form-control" name="LAN" style="width: 250px;">';
                            $arrLan = ['1', '2'];
                            foreach ($arrLan as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            echo '</select>';
                            echo '</div>
                            <div class="modal-footer border-top-0 d-flex " style="margin-top: -20px;">
                                <button type="submit" class="btn btn-success" name="napDuLieu">Tải dữ liệu</button>
                            </div>
                        </div>';
                        } else if (isset($_POST['napServer']) && $_SESSION["TENNHOM"] == 'TRUONG') {
                            unset($_SESSION['serverTaoTK']);
                            $_SESSION['serverTaoTK'] = $_REQUEST['taiChiNhanh'];
                            echo '<div class="modal-body" style="display: flex;">
                                    <div class="form-group" style="display: flex;">';
                            echo '<select class="form-control" name="MAMH" style="width: 250px;">';
                            $sql = "EXEC SP_DSMON";
                            $dsMonHoc = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sql);
                            while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                                echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                            }
                            echo '</select>';
                            echo '<select class="form-control" name="MALOP" style="width: 250px;">';
                            $sql = "EXEC SP_DSLOP";
                            echo $sql;
                            $dsLop = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sql);
                            while ($row = sqlsrv_fetch_object($dsLop)) {
                                echo '<option value=' . $row->MALOP . '>' . $row->TENLOP . '</option>';
                            }
                            echo '</select>';


                            echo '<select class="form-control" name="LAN" style="width: 250px;">';
                            $arrLan = ['1', '2'];
                            foreach ($arrLan as $value) {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                            echo '</select>';
                            echo '</div>
                            <div class="modal-footer border-top-0 d-flex " style="margin-top: -20px;">
                                <button type="submit" class="btn btn-success" name="napDuLieu">Tải dữ liệu</button>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                </div>
            </form>
            <div class="col-12">
                <?php
                    if(isset($_POST['napDuLieu']) && $_SESSION["TENNHOM"] == 'COSO'){
                        $sqlRp1 = "EXEC SP_CT_SV_THEO_LOP_MON'" . $_REQUEST['MALOP'] . "'" . ",'" . $_REQUEST['MAMH'] . "'" . ",'" . $_REQUEST['LAN'] . "'";
                        $dsRp1 = KetNoiCSDL::goiSP($sqlRp1);
                        $row = sqlsrv_fetch_array($dsRp1);
                        echo '<div style="margin-left :150px;">';
                        echo '<p style="font-size: 20px;  text-transform: uppercase;">tên môn: '.$row['TENMH'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">tên LỚP: '.$row['TENLOP'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">LẦN: '.$row['LAN'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">NGÀY THI: '.$row['NGAYTHI']->format('d-m-Y').'</p>';
                        echo '</div>';

                    }else if(isset($_POST['napDuLieu']) && $_SESSION["TENNHOM"] == 'TRUONG'){
                        $sqlRp1 = "EXEC SP_CT_SV_THEO_LOP_MON'" . $_REQUEST['MALOP'] . "'" . ",'" . $_REQUEST['MAMH'] . "'" . ",'" . $_REQUEST['LAN'] . "'";
                        $dsRp1 = KetNoiCSDL::goiSPhtkn($_SESSION['serverTaoTK'],$sqlRp1);
                        $row = sqlsrv_fetch_array($dsRp1);
                        echo '<div style="margin-left :150px;">';
                        echo '<p style="font-size: 20px;  text-transform: uppercase;">tên môn: '.$row['TENMH'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">tên LỚP: '.$row['TENLOP'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">LẦN: '.$row['LAN'].'</p>';
                        echo '<p style="font-size: 20px;  text-transform: uppercase; ">NGÀY THI: '.$row['NGAYTHI']->format('d-m-Y').'</p>';
                        echo '</div>';
                    }
                ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">MASV</th>
                            <th scope="col">HỌ</th>
                            <th scope="col">TÊN</th>
                            <th scope="col">ĐIỂM</th>
                            <th scope="col">ĐIỂM CHỮ</th>>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (isset($_POST['napDuLieu']) && $_SESSION["TENNHOM"] == 'COSO') {
                            $sqlRp1 = "EXEC SP_DIEM_SV_THEO_LOP_MON'" . $_REQUEST['MALOP'] . "'" . ",'" . $_REQUEST['MAMH'] . "'" . ",'" . $_REQUEST['LAN'] . "'";
                            $dsRp1 = KetNoiCSDL::goiSP($sqlRp1);
                            while ($row = sqlsrv_fetch_array($dsRp1)) {
                                echo "<tr>";
                                echo '<td scope="col">' . $row['MASV'] . '</th>';
                                echo '<td scope="col">' . $row['HO'] . '</td>';
                                echo '<td scope="col">' . $row['TEN'] . '</td>';
                                echo '<td scope="col">' . $row['DIEM'] . '</td>';
                                echo '<td scope="col">' . $row['DIEMCHU'] . '</td>';
                                echo "</tr>";
                            }
                        } else if (isset($_POST['napDuLieu']) && $_SESSION["TENNHOM"] == 'TRUONG') {
                            $sqlNap = "EXEC SP_DIEM_SV_THEO_LOP_MON'" . $_REQUEST['MALOP'] . "'" . ",'" . $_REQUEST['MAMH'] . "'" . ",'" . $_REQUEST['LAN'] . "'";
                            $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sqlNap);
                            while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                echo "<tr>";
                                echo '<td scope="col">' . $row['MASV'] . '</th>';
                                echo '<td scope="col">' . $row['HO'] . '</td>';
                                echo '<td scope="col">' . $row['TEN'] . '</td>';
                                echo '<td scope="col">' . $row['DIEM'] . '</td>';
                                echo '<td scope="col">' . $row['DIEMCHU'] . '</td>';
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