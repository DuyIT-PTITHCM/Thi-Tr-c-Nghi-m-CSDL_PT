<?php
session_start();
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
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>

<body>
    <div class="container-fluid" style="margin-top: 30px;">
        <a href="lop.php" class="btn btn-primary">Quay Lại</a>

        <div class="row">
            <?php
            include_once 'KetNoiCSDL.php';
            if (isset($_POST['ghiMoiSinhVien'])) {
                $maSinhVien = $_REQUEST['maSinhVien'];
                $hoSinhVien = $_REQUEST['hoSinhVien'];
                $tenSinhVien = $_REQUEST['tenSinhVien'];
                $diaChiSinhVien = $_REQUEST['diaChiSinhVien'];
                $ngaySinhSV = $_REQUEST['ngaySinh'];
                $maLop = $_REQUEST['detailsv'];
                $password = '123456';
                $sql = "EXEC SP_KTSV_TONTAI '" . $maSinhVien . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Thêm Thất Bại!</strong> Mã Sinh Viên Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sqlThem = "EXEC SP_THEMSV '" . $maSinhVien . "'" . ",N'" . $hoSinhVien . "'" . ",N'" . $tenSinhVien . "'" . ",'" . $ngaySinhSV . "'" . ",N'" . $diaChiSinhVien . "'" . ",'" . $maLop . "'" . ",'" . $password . "'";
                    $kq = KetNoiCSDL::goiSPNotExec($sqlThem);
                    header("Refresh:0;");
                }
            }

            if (isset($_POST['suaSinhVien'])) {
                $maSinhVienCu = $_REQUEST['maSinhVienCu'];
                $maSinhVien = $_REQUEST['maSinhVien'];
                $hoSinhVien = $_REQUEST['hoSinhVien'];
                $tenSinhVien = $_REQUEST['tenSinhVien'];
                $diaChiSinhVien = $_REQUEST['diaChiSinhVien'];
                $ngaySinhSV = $_REQUEST['ngaySinh'];
                $maLop = $_REQUEST['maLop'];
                $password = $_REQUEST['password'];

                $sqlCheck = "EXEC SP_KT_MA_SV_TONTAI '" . $maSinhVienCu . "'" . ",'" . $maSinhVien . "'";

                $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                if (!$kqCheck) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>SỬA Thất Bại!</strong> Mã Sinh Viên Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql = "EXEC SP_SUASV '" . $maSinhVienCu . "'" . ",'" . $maSinhVien . "'" . ",N'" . $hoSinhVien . "'" . ",N'" . $tenSinhVien . "'" . ",'" . $ngaySinhSV . "'" . ",N'" . $diaChiSinhVien . "'" . ",'" . $maLop . "'" . ",'" . $password . "'";
                    $kq = KetNoiCSDL::goiSPNotExec($sql);
                    header("Refresh:0; url=http://localhost/CSDL_PT/sinhVien.php?detailsv=" . $_REQUEST['detailsv']);
                }
            }
            if (isset($_REQUEST['delete'])) {
                $maSV = $_REQUEST['delete'];
                $sqlXoaGV = "EXEC SP_XOASV '" . $maSV . "'";
                $kqXoa = KetNoiCSDL::goiSPNotExec($sqlXoaGV);
                if (!$kqXoa) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Xóa Thất Bại!</strong> Sinh Viên này đã được sử dụng
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0; url=http://localhost/CSDL_PT/sinhVien.php?detailsv=" . $_REQUEST['detailsv']);
                }
            }
            ?>
            <?php
            if ($_SESSION["TENNHOM"] == 'COSO') {
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form_add" style="margin-left: 80%; margin-bottom: 10px;">
                    Tạo Mới Giáo Viên
                </button>';
            }
            ?>

            <!-- form model  -->
            <div class="modal fade" id="form_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Tạo Mới Giáo Viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mã Sinh Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Mã Sinh Viên" name="maSinhVien">
                                </div>
                                <div class="form-group">
                                    <label>Họ Sinh Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Họ Sinh Viên" name="hoSinhVien">
                                </div>
                                <div class="form-group">
                                    <label>Tên Sinh Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Tên Sinh Viên" name="tenSinhVien">
                                </div>
                                <div class="form-group">
                                    <label>Địa Chỉ Sinh Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Địa Chỉ Sinh Viên" name="diaChiSinhVien">
                                </div>
                                <div class="form-group">
                                    <label>Ngày Sinh Sinh Viên</label>
                                    <input data-date-format="yyyy/mm/dd" id="datepicker" name="ngaySinh" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mã Lớp Sinh Viên</label>
                                    <?php echo '<input disabled type="text" class="form-control" name="maLop" value="' . $_REQUEST['detailsv'] . '">'; ?>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="ghiMoiSinhVien">Ghi</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Sửa Thông Tin Giáo Viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">

                                    <?php
                                    $sql = "EXEC TAI_SV_THEO_MASV '" . $_REQUEST['edit'] . "'";
                                    $kq = KetNoiCSDL::goiSP($sql);
                                    $row = sqlsrv_fetch_array($kq);
                                    try {
                                        $dateNotFormat = $row['NGAYSINH'];
                                        $date = date_format($dateNotFormat, "d-m-Y");
                                    } catch (Exception $err) {
                                        echo $err;
                                    }
                                    echo ' <input style="visibility: hidden;" type="text" class="form-control" name="maSinhVienCu" value="' . $row['MASV'] . '">';
                                    echo '<label>Mã Sinh Viên</label>';
                                    echo ' <input type="text" class="form-control" name="maSinhVien" value="' . $row['MASV'] . '">';
                                    echo '</div>';

                                    echo '<div class="form-group">
                                            <label>Họ Sinh Viên</label>';
                                    echo ' <input type="text" class="form-control" name="hoSinhVien" value="' . $row['HO'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Tên Sinh Viên</label>';
                                    echo ' <input type="text" class="form-control" name="tenSinhVien" value="' . $row['TEN'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Địa Chỉ Sinh Viên</label>';
                                    echo ' <input type="text" class="form-control" name="diaChiSinhVien" value="' . $row['DIACHI'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Ngày Sinh Sinh Viên</label>';
                                    echo '<input name="ngaySinh" class="form-control" value="' . $date . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Mã Lớp</label>';
                                    echo ' <input type="text" class="form-control" name="maLop" value="' . $row['MALOP'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Mật Khẩu</label>';
                                    echo ' <input type="text" class="form-control" name="password" value="' . $row['PASSWORD'] . '">';
                                    echo '</div>';

                                    ?>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaSinhVien">Ghi</button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <div class="col-12">
                <h2 style="text-align: center;"> Danh Sách Sinh Viên </h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã Sinh Viên</th>
                            <th scope="col">Tên Sinh Viên</th>
                            <th scope="col">Ngày Sinh</th>
                            <th scope="col">Mã Lớp</th>
                            <th scope="col">Địa Chỉ</th>
                            <?php
                            if ($_SESSION["TENNHOM"] == 'COSO') {
                                echo '<th scope="col">Actions</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                            $sql = "EXEC SP_TAI_SV_THEO_MALOP '" . $_REQUEST['detailsv'] . "'";
                            $dsGiaoVienTheoKhoa = KetNoiCSDL::goiSP($sql);

                            while ($row = sqlsrv_fetch_array($dsGiaoVienTheoKhoa)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MASV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                print '<td>' . $row['NGAYSINH']->format('d-m-Y') . '</td>';
                                echo '<td>' . $row['MALOP'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                                if ($_SESSION["TENNHOM"] == 'COSO') {
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/sinhVien.php?detailsv=' . $_REQUEST['detailsv'] . '&edit=' . $row['MASV'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                        '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/sinhVien.php?detailsv=' . $_REQUEST['detailsv'] . '&delete=' . $row['MASV'] .  '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
                                        '</td>';
                                    echo "</tr>";
                                }
                            }
                        } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            $sqlNap = "EXEC SP_TAI_SV_THEO_MALOP '" . $_REQUEST['detailsv'] . "'";
                            $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sqlNap);
                            while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MASV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                print '<td>' . $row['NGAYSINH']->format('d-m-Y') . '</td>';
                                echo '<td>' . $row['MALOP'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    if (isset($_REQUEST['edit'])) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#form_edit').modal('show');
            });
        </script>
    <?php
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker').datepicker("setDate", new Date());
        $('#datepicker1').datepicker({
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker1').datepicker("setDate", new Date());
    </script>
</body>

</html>