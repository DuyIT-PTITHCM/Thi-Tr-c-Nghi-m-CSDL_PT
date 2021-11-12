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
    ?>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <?php
            include_once 'KetNoiCSDL.php';
            if (isset($_POST['dangKiThi'])) {
                $maGV = $_REQUEST['maGV'];
                $maLOP = $_REQUEST['maLOP'];
                $maMH = $_REQUEST['maMH'];
                $trinhDo = $_REQUEST['trinhDo'];
                $ngayThi = $_REQUEST['ngayThi'];
                $lan = $_REQUEST['lan'];
                $soCauThi = $_REQUEST['soCauThi'];
                $thoiGian = $_REQUEST['thoiGian'];
                $sql = "EXEC SP_KT_GVDK '" . $maMH . "'" . ",'" . $trinhDo . "'" . ",'" . $soCauThi . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                $today = date("Y-m-d H:i:s");
                $dateTimestamp1 = strtotime($ngayThi);
                $dateTimestamp2 = strtotime($today);
                if ($dateTimestamp1 < $dateTimestamp2) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Ngày thi phải sau ngày hiện tại!</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Đăng Kí Thất Bại!</strong> Môn này không đủ câu thi
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql1 = "EXEC SP_GV_DK '" . $maGV . "'" . ",'" . $maMH . "'" . ",'" . $maLOP . "'" . ",'" . $trinhDo . "'" . ",'" . $ngayThi . "'" . ",'" . $lan . "'" . ",'" . $soCauThi . "'" . ",'" . $thoiGian . "'";
                    $kq1 = KetNoiCSDL::goiSP($sql1);
                   header("Refresh:0; url=gv_dk.php");
                }
            }

            if (isset($_POST['suaGVDK'])) {
                
                $maGV = $_REQUEST['maGV'];
                $maLOP = $_REQUEST['maLOP'];
                $maMH = $_REQUEST['maMH'];
                $trinhDo = $_REQUEST['trinhDo'];
                $ngayThi = $_REQUEST['ngayThi'];
                $lan = $_REQUEST['lan'];
                $soCauThi = $_REQUEST['soCauThi'];
                $thoiGian = $_REQUEST['thoiGian'];
                $sql = "EXEC SP_KT_GVDK '" . $maMH . "'" . ",'" . $trinhDo . "'" . ",'" . $soCauThi . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                $today = date("Y-m-d H:i:s");
                $dateTimestamp1 = strtotime($ngayThi);
                $dateTimestamp2 = strtotime($today);
                if ($dateTimestamp1 < $dateTimestamp2) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Ngày thi phải sau ngày hiện tại!</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Sửa Đăng Kí Thất Bại!</strong> Môn này không đủ câu thi
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql1 = "EXEC SP_SUA_GV_DK '" . $_REQUEST['LANEDIT'] . "'" . ",'" . $_REQUEST['MAMHEDIT'] . "'" . ",'" . $_REQUEST['MALOPEDIT'] . "'" . ",'" . $maGV . "'" . ",'" . $maMH . "'" . ",'" . $maLOP . "'" . ",'" . $trinhDo . "'" . ",'" . $ngayThi . "'" . ",'" . $lan . "'" . ",'" . $soCauThi . "'" . ",'" . $thoiGian . "'";
                    $kq1 = KetNoiCSDL::goiSP($sql1);
                    if (!$kq1) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Sửa Đăng Kí Thất Bại!</strong> Môn học này lớp này lần thi này bị trùng vui lòng kiểm tra lại thông tin
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                    }else{
                        header("Refresh:0; url=gv_dk.php");
                    }
                    
                }
            }
            if (isset($_REQUEST['MAMHDELETE'])) {
                $MAMH = $_REQUEST['MAMHDELETE'];
                $LAN = $_REQUEST['LANDELETE'];
                $MALOP = $_REQUEST['MALOPDELETE'];
                $sql = "EXEC SP_KT_XOA_GVDK '" . $MAMH . "'" . ",'" . $MALOP . "'" . ",'" . $LAN . "'";
                $ktXoa = KetNoiCSDL::goiSPNotExec($sql);
                if (!$ktXoa) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Xóa Thất Bại!</strong> Thông tin này đã nằm trong bảng điểm
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql = "EXEC SP_XOA_GV_DK '" . $LAN . "'" . ",'" . $MAMH . "'" . ",'" . $MALOP . "'";
                    $kqXoa = KetNoiCSDL::goiSPNotExec($sql);
                    if (!$kqXoa) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Xóa Thất Bại!</strong> vui lòng kiểm tra lại
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                    } else{
                        header("Refresh:0; url=gv_dk.php");
                    }
                    
                }
            }
            ?>
            <?php
            if ($_SESSION["TENNHOM"] == 'COSO') {
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form_add" style="margin-left: 80%; margin-bottom: 10px;">
                    Đăng Kí Thi 
                </button>';
            }
            ?>
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
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="napDuLieu">Tải dữ liệu theo cơ sở</button>';
                        }
                        ?>
                    </div>
                </div>
            </form>
            <!-- form model  -->
            <div class="modal fade" id="form_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Đăng Ký Thi </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <?php
                                echo '<label>Chọn Môn</label>';
                                echo '<select class="form-control" name="maMH">';
                                $sql = "EXEC SP_DSMON";
                                $dsMonHoc = KetNoiCSDL::goiSP($sql);
                                while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                                    echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                                }
                                echo '</select>';
                                echo '<label>Chọn Giáo Viên</label>';
                                echo '<select class="form-control" name="maGV">';
                                $sql1 = "EXEC SP_DS_GV";
                                $dsGiaoVien = KetNoiCSDL::goiSP($sql1);
                                while ($row = sqlsrv_fetch_object($dsGiaoVien)) {
                                    echo '<option value=' . $row->MAGV . '>' . $row->TEN . '</option>';
                                }
                                echo '</select>';
                                echo '<label>Chọn Lớp</label>';
                                echo '<select class="form-control" name="maLOP">';
                                $sql1 = "EXEC SP_DSLOP";
                                $dsLop = KetNoiCSDL::goiSP($sql1);
                                while ($row = sqlsrv_fetch_object($dsLop)) {
                                    echo '<option value=' . $row->MALOP . '>' . $row->TENLOP . '</option>';
                                }
                                echo '</select>';
                                ?>
                                <div class="form-group">
                                    <label>Trình Độ</label>
                                    <select name="trinhDo" id="" class="form-control">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ngày Thi</label>
                                    <input id="datepicker" name="ngayThi" class="form-control" type="date">
                                </div>
                                <div class="form-group">
                                    <label>Lần thi</label>
                                    <select name="lan" id="" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Số Câu Thi</label>
                                    <input type="number" max="100" min="10" class="form-control" placeholder="Nhập Số Câu Thi" name="soCauThi">
                                </div>
                                <div class="form-group">
                                    <label>Thời Gian</label>
                                    <input type="number" class="form-control" placeholder="Nhập Số Câu Thi" name="thoiGian">
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="dangKiThi">Ghi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <!-- form model  -->
            <div class="modal fade" id="form_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Sửa Khoa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mã Khoa</label>
                                    <?php
                                    $sql = "EXEC SP_TAI_GV_DK '" . $_REQUEST['LANEDIT'] . "'" . ",'" . $_REQUEST['MAMHEDIT'] . "'" . ",'" . $_REQUEST['MALOPEDIT'] . "'";
                                    $kq = KetNoiCSDL::goiSP($sql);
                                    $row = sqlsrv_fetch_array($kq);
                                    echo '<label>Chọn Môn</label>';
                                    echo '<select class="form-control" name="maMH">';
                                    $sql1 = "EXEC SP_DSMON";
                                    $dsMonHoc = KetNoiCSDL::goiSP($sql1);
                                    while ($row1 = sqlsrv_fetch_object($dsMonHoc)) {
                                        if ($row1->MAMH == $row['MAMH']) {
                                            echo '<option selected  value=' . $row1->MAMH . '>' . $row1->TENMH . '</option>';
                                        } else {
                                            echo '<option value=' . $row1->MAMH . '>' . $row1->TENMH . '</option>';
                                        }
                                    }
                                    echo '</select>';

                                    echo '<label>Chọn Giáo Viên</label>';
                                    echo '<select class="form-control" name="maGV">';
                                    $sql1 = "EXEC SP_DS_GV";
                                    $dsGiaoVien = KetNoiCSDL::goiSP($sql1);
                                    while ($row1 = sqlsrv_fetch_object($dsGiaoVien)) {
                                        if ($row1->MAGV == $row['MAGV']) {
                                            echo '<option selected value=' . $row1->MAGV . '>' . $row1->TEN . '</option>';
                                        } else {
                                            echo '<option value=' . $row1->MAGV . '>' . $row1->TEN . '</option>';
                                        }
                                    }
                                    echo '</select>';

                                    echo '<label>Chọn Lớp</label>';
                                    echo '<select class="form-control" name="maLOP">';
                                    $sql2 = "EXEC SP_DSLOP";
                                    $dsLop = KetNoiCSDL::goiSP($sql2);
                                    while ($row1 = sqlsrv_fetch_object($dsLop)) {
                                        if ($row1->MALOP == $row['MALOP']) {
                                            echo '<option selected value=' . $row1->MALOP . '>' . $row1->TENLOP . '</option>';
                                        } else {
                                            echo '<option value=' . $row1->MALOP . '>' . $row1->TENLOP . '</option>';
                                        }
                                    }
                                    echo '</select>';

                                    echo '<label>Trình Độ</label>
                                    <select name="trinhDo" id="" class="form-control">';
                                    $arrTD = ['A', 'B', 'C'];
                                    foreach ($arrTD as $value) {
                                        if ($row['TRINHDO'] == $value) {
                                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                                        } else {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    try {
                                        $dateNotFormat = $row['NGAYTHI'];
                                        $date = date_format($dateNotFormat, "Y-m-d");
                                    } catch (Exception $err) {
                                        echo $err;
                                    }
                                    echo '<label>Ngày Thi</label>
                                    <input  name="ngayThi" class="form-control"  value="' . $date . '">';

                                    echo '<label>Lần Thi</label>
                                    <select name="lan" id="" class="form-control">';
                                    $arrLan = ['1', '2'];
                                    foreach ($arrLan as $value) {
                                        if ($row['LAN'] == $value) {
                                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                                        } else {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    echo '<label>Số Câu Thi </label>
                                    <input type="number" name="soCauThi" class="form-control"  value="' . $row['SOCAUTHI'] . '">';
                                    echo '<label>Thời Gian</label>
                                    <input type="number" name="thoiGian" class="form-control"  value="' . $row['THOIGIAN'] . '">';

                                    ?>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaGVDK">Ghi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <div class="col-12">
                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">Mã Giáo Viên</th>
                            <th scope="col">Mã Môn Học</th>

                            <th scope="col">Mã Lớp</th>
                            <th scope="col">Trình Độ</th>
                            <th scope="col">Ngày Thi</th>
                            <th scope="col">Lần </th>
                            <th scope="col">Số Câu Thi</th>
                            <th scope="col">Thời Gian (phút)</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                            $sql = "EXEC SP_DS_GV_DK";
                            $dsGiaoVienDangKy = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_array($dsGiaoVienDangKy)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                echo '<td>' . $row['MAMH'] . '</td>';
                                echo '<td>' . $row['MALOP'] . '</td>';
                                echo '<td>' . $row['TRINHDO'] . '</td>';
                                print '<td>' . $row['NGAYTHI']->format('d-m-Y') . '</td>';
                                echo '<td>' . $row['LAN'] . '</td>';
                                echo '<td>' . $row['SOCAUTHI'] . '</td>';
                                echo '<td>' . $row['THOIGIAN'] . '</td>';
                                if($_SESSION["TENNHOM"] == 'COSO'){
                                    echo '<td>' .
                                    '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/thiThu.php?LANTT=' . $row['LAN'] . '&MAMHTT=' . $row['MAMH'] . '&MALOPTT=' . $row['MALOP'] . '"><i class="fas fa-pen"></i></a>' .
                                    '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/gv_dk.php?LANEDIT=' . $row['LAN'] . '&MAMHEDIT=' . $row['MAMH'] . '&MALOPEDIT=' . $row['MALOP'] . '"><i class="fas fa-edit"></i></a>' .
                                    '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/gv_dk.php?LANDELETE=' . $row['LAN'] . '&MAMHDELETE=' . $row['MAMH'] . '&MALOPDELETE=' . $row['MALOP'] . '"><i class="far fa-trash-alt"></i></a>';
                                    '</td>';
                                }else{
                                    echo '<td>' .
                                    '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/thiThu.php?LANTT=' . $row['LAN'] . '&MAMHTT=' . $row['MAMH'] . '&MALOPTT=' . $row['MALOP'] . '"><i class="fas fa-pen"></i></a>' .
                                    '</td>';
                                }
                                
                                echo "</tr>";
                            }
                        } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            if (isset($_POST['napDuLieu'])) {
                                $sqlNap = "EXEC SP_DS_GV_DK";
                                unset($_SESSION['serverTaoTK']);
                                $_SESSION['serverTaoTK'] = $_REQUEST['taiChiNhanh'];
                                $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_REQUEST['taiChiNhanh'], $sqlNap);
                                //var_dump($dsTheoCoSo);
                                while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                    echo "<tr>";
                                    echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                    echo '<td>' . $row['MAMH'] . '</td>';
                                    echo '<td>' . $row['MALOP'] . '</td>';
                                    echo '<td>' . $row['TRINHDO'] . '</td>';
                                    print '<td>' . $row['NGAYTHI']->format('d-m-Y') . '</td>';
                                    echo '<td>' . $row['LAN'] . '</td>';
                                    echo '<td>' . $row['SOCAUTHI'] . '</td>';
                                    echo '<td>' . $row['THOIGIAN'] . '</td>';
                                    echo '<td>' .
                                    '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/thiThu.php?LANTT=' . $row['LAN'] . '&MAMHTT=' . $row['MAMH'] . '&MALOPTT=' . $row['MALOP'] . '"><i class="fas fa-pen"></i></a>' .
                                    '</td>';
                                }
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    if (isset($_REQUEST['MAMHEDIT'])) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#form_edit').modal('show');
            });
        </script>
    <?php
    }
    ?>
</body>

</html>