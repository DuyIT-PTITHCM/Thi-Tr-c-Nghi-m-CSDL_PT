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
        <a href="khoa.php" class="btn btn-primary">Quay Lại</a>
        <div class="row">
            <?php
            include_once 'KetNoiCSDL.php';
            if (isset($_POST['ghiMoiGiaoVien'])) {
                $maGiaoVien = $_REQUEST['maGiaoVien'];
                $hoGiaoVien = $_REQUEST['hoGiaoVien'];
                $tenGiaoVien = $_REQUEST['tenGiaoVien'];
                $diaChiGiaoVien = $_REQUEST['diaChiGiaoVien'];
                $maKhoa = $_REQUEST['detailgv'];


                $sql = "EXEC SP_THEMGV '" . $maGiaoVien . "'" . ",N'" . $hoGiaoVien . "'" . ",N'" . $tenGiaoVien . "'" . ",'" . $maKhoa . "'" . ",N'" . $diaChiGiaoVien . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Thêm Thất Bại!</strong> Mã Khoa Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0;");
                }
            }

            if (isset($_POST['suaGiaoVien'])) {
                $maGiaoVienCu = $_REQUEST['maGVCu'];
                $maGiaoVien = $_REQUEST['maGiaoVien'];
                $hoGiaoVien = $_REQUEST['hoGiaoVien'];
                $tenGiaoVien = $_REQUEST['tenGiaoVien'];
                $diaChiGiaoVien = $_REQUEST['diaChiGiaoVien'];
                $maKhoaSelect = $_REQUEST['maKhoaSelect'];

                $sqlCheck = "EXEC SP_KT_MAGV_TONTAI '" . $maGiaoVienCu . "'" . ",'" . $maGiaoVien . "'";
                $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                if (!$kqCheck) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>SỬA Thất Bại!</strong> Mã Giáo Viên Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql = "EXEC SP_SUAGV '" . $maGiaoVienCu . "'" . ",'" . $maGiaoVien . "'" . ",N'" . $hoGiaoVien . "'" . ",N'" . $tenGiaoVien . "'" . ",N'" . $diaChiGiaoVien . "'" . ",'" . $maKhoaSelect . "'";
                    $kq = KetNoiCSDL::goiSPNotExec($sql);
                    header("Refresh:0; url=http://localhost/CSDL_PT/giaoVien.php?detailgv=" . $_REQUEST['detailgv']);
                }
            }
            if (isset($_REQUEST['delete'])) {
                $maGV = $_REQUEST['delete'];
                $sqlXoaGV = "EXEC SP_XOAGV '" . $maGV . "'";
                $kqXoa = KetNoiCSDL::goiSPNotExec($sqlXoaGV);
                if (!$kqXoa) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Xóa Thất Bại!</strong> Giáo này đã được sử dụng
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0; url=http://localhost/CSDL_PT/giaoVien.php?detailgv=" . $_REQUEST['detailgv']);
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
                                    <label>Mã Giáo Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Mã Giáo Viên" name="maGiaoVien">
                                </div>
                                <div class="form-group">
                                    <label>Họ Giáo Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Họ Giáo Viên" name="hoGiaoVien">
                                </div>
                                <div class="form-group">
                                    <label>Tên Giáo Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Tên Giáo Viên" name="tenGiaoVien">
                                </div>
                                <div class="form-group">
                                    <label>Địa Chỉ Giáo Viên</label>
                                    <input type="text" class="form-control" placeholder="Nhập Địa Chỉ Giáo Viên" name="diaChiGiaoVien">
                                </div>
                                <div class="form-group">
                                    <label>Mã Khoa Giáo Viên</label>
                                    <?php echo '<input disabled type="text" class="form-control" name="maKhoa" value="' . $_REQUEST['detailgv'] . '">'; ?>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="ghiMoiGiaoVien">Ghi</button>
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
                            <button disabled type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">

                                    <?php
                                    $sql = "EXEC TAI_GV_THEO_MAGV '" . $_REQUEST['edit'] . "'";
                                    $kq = KetNoiCSDL::goiSP($sql);
                                    $row = sqlsrv_fetch_array($kq);
                                    echo ' <input style="visibility: hidden;" type="text" class="form-control" name="maGVCu" value="' . $row['MAGV'] . '">';
                                    echo '<label>Mã Giáo Viên</label>';
                                    echo ' <input type="text" disabled class="form-control" name="maGiaoVien" value="' . $row['MAGV'] . '">';
                                    echo '</div>';

                                    echo '<div class="form-group">
                                            <label>Họ Giáo Viên</label>';
                                    echo ' <input type="text" class="form-control" name="hoGiaoVien" value="' . $row['HO'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Tên Giáo Viên</label>';
                                    echo ' <input type="text" class="form-control" name="tenGiaoVien" value="' . $row['TEN'] . '">';
                                    echo '</div>';
                                    echo '<div class="form-group">
                                            <label>Địa Chỉ Giáo Viên</label>';
                                    echo ' <input type="text" class="form-control" name="diaChiGiaoVien" value="' . $row['DIACHI'] . '">';
                                    echo '</div>';

                                    echo '<div class="form-group">
                                            <label>Chọn Khoa</label>';
                                    echo '<select class="form-control" name="maKhoaSelect">';
                                    $sqlDSKhoa = "EXEC SP_DSKHOA";
                                    $dsKhoa = KetNoiCSDL::goiSP($sqlDSKhoa);
                                    while ($row = sqlsrv_fetch_array($dsKhoa)) {
                                        if ($row['MAKH'] == $_REQUEST['detailgv']) {
                                            echo '<option selected value=' . $row['MAKH'] . '>' . $row['TENKH'] . '</option>';
                                        } else {
                                            echo '<option value=' . $row['MAKH'] . '>' . $row['TENKH'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    echo '</div>';
                                    ?>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaGiaoVien">Ghi</button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <div class="col-12">
                <h2 style="text-align: center;"> Danh Sách Giáo Viên </h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã Giáo Viên</th>
                            <th scope="col">Tên Giáo Viên</th>
                            <th scope="col">Mã Khoa</th>
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
                            $sql = "EXEC SP_TAI_GIAOVIEN_THEO_MAKH '" . $_REQUEST['detailgv'] . "'";
                            $dsGiaoVienTheoKhoa = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_array($dsGiaoVienTheoKhoa)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                echo '<td>' . $row['MAKH'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                                if ($_SESSION["TENNHOM"] == 'COSO') {
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $_REQUEST['detailgv'] . '&edit=' . $row['MAGV'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                        '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/khoa.php?edit=' . $_REQUEST['detailgv'] . '"' . '>' . '<i class="fa fa-user-plus" aria-hidden="true"></i></a>' .
                                        '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $_REQUEST['detailgv'] . '&delete=' . $row['MAGV'] .  '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
                                        '</td>';
                                    echo "</tr>";
                                }
                            }
                        } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            $sqlNap = "EXEC SP_TAI_GIAOVIEN_THEO_MAKH '" . $_REQUEST['detailgv'] . "'";
                            $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sqlNap);
                            while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                echo '<td>' . $row['MAKH'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                                if ($_SESSION["TENNHOM"] == 'COSO') {
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $_REQUEST['detailgv'] . '&edit=' . $row['MAGV'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                        '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/khoa.php?edit=' . $_REQUEST['detailgv'] . '"' . '>' . '<i class="fa fa-user-plus" aria-hidden="true"></i></a>' .
                                        '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $_REQUEST['detailgv'] . '&delete=' . $row['MAGV'] .  '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
                                        '</td>';
                                    echo "</tr>";
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
    if (isset($_REQUEST['edit'])) { ?>
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