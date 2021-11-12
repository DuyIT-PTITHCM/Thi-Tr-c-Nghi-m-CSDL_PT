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
            if (isset($_POST['ghiMoiKhoa'])) {
                $maKhoa = $_REQUEST['maKhoa'];
                $tenKhoa = $_REQUEST['tenKhoa'];

                $sql = "EXEC SP_KTKhoa_TONTAI '" . $maKhoa . "'" . ",'" . $tenKhoa . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Thêm Thất Bại!</strong> Mã Khoa Hoặc Tên Khoa Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql1 = "EXEC SP_THEMKHOA '" . $maKhoa . "'" . ",N'" . $tenKhoa . "'";
                    $kq1 = KetNoiCSDL::goiSP($sql1);
                    header("Refresh:0; url=khoa.php");
                }
            }

            if (isset($_POST['suaKhoa'])) {
                $maKhoaSua = $_REQUEST['maKhoa'];
                $tenKhoaSua = $_REQUEST['tenKhoa'];
                $maKhoaCu = $_REQUEST['maKhoaCu'];

                $sqlCheck = "EXEC SP_KT_TENMA_Khoa_TONTAI '" . $maKhoaCu . "'" . ",'" . $maKhoaSua . "'" . ",N'" . $tenKhoaSua . "'";
                $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                if (!$kqCheck) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>SỬA Thất Bại!</strong> Mã Khoa Hoặc Tên Khoa Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql = "EXEC SP_SUAKH '" . $maKhoaCu . "'" . ",'" . $maKhoaSua . "'" . ",N'" . $tenKhoaSua . "'";
                    $kq = KetNoiCSDL::goiSPNotExec($sql);
                    header("Refresh:0; url=khoa.php");
                }
            }
            if (isset($_REQUEST['delete'])) {
                $maKH = $_REQUEST['delete'];
                $sql = "EXEC SP_XOAKH '" . $maKH . "'";
                $kqXoa = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kqXoa) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Xóa Thất Bại!</strong> Khoa này đã được sử dụng
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0; url=khoa.php");
                }
            }
            ?>
            <?php
            if ($_SESSION["TENNHOM"] == 'COSO') {
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form_add" style="margin-left: 80%; margin-bottom: 10px;">
                    Tạo Khoa
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
                            <h5 class="modal-title" id="exampleModalLabel">Tạo Khoa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mã Khoa</label>
                                    <input type="text" class="form-control" placeholder="Nhập Mã Khoa" name="maKhoa">
                                </div>
                                <div class="form-group">
                                    <label>Tên Khoa</label>
                                    <input type="text" class="form-control" placeholder="Nhập Tên Khoa" name="tenKhoa">
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="ghiMoiKhoa">Ghi</button>
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
                                    $sql = "EXEC TAI_KHOA_THEO_MA '" . $_REQUEST['edit'] . "'";
                                    $kq = KetNoiCSDL::goiSP($sql);
                                    $row = sqlsrv_fetch_array($kq);
                                    echo ' <input style="visibility: hidden;" type="text" class="form-control" placeholder="Mã Khoa Cũ" name="maKhoaCu" value="' . $row['MAKH'] . '">';
                                    echo ' <input type="text" class="form-control" placeholder="Nhập Mã Khoa" name="maKhoa" value="' . $row['MAKH'] . '">';
                                    echo '</div>
                                        <div class="form-group">
                                            <label>Tên Khoa</label>';
                                    echo ' <input type="text" class="form-control" placeholder="Nhập Tên Khoa" name="tenKhoa" value="' . $row['TENKH'] . '">';
                                    echo '</div>';
                                    ?>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaKhoa">Ghi</button>
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
                            <th scope="col">Mã Khoa</th>
                            <th scope="col">Tên Khoa</th>
                            <th scope="col">Cơ Sở</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                            $sql = "EXEC SP_DSKHOA";
                            $dsKhoa = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_array($dsKhoa)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAKH'] . '</th>';
                                echo '<td>' . $row['TENKH'] . '</td>';
                                echo '<td>' . $row['MACS'] . '</td>';
                                if ($_SESSION["TENNHOM"] == 'COSO') {
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-primary"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $row['MAKH'] . '"' . '>' . '<i class="far fa-eye"></i></a>' .
                                        '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/khoa.php?edit=' . $row['MAKH'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                        '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/khoa.php?delete=' . $row['MAKH'] . '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
                                        '</td>';
                                    echo "</tr>";
                                } else {
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-primary"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $row['MAKH'] . '"' . '>' . '<i class="far fa-eye"></i></a>';
                                }
                            }
                        } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            if (isset($_POST['napDuLieu'])) {
                                $sqlNap = "EXEC SP_DSKHOA";
                                unset($_SESSION['serverTaoTK']);
                                $_SESSION['serverTaoTK'] = $_REQUEST['taiChiNhanh'];
                                $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_REQUEST['taiChiNhanh'], $sqlNap);
                                //var_dump($dsTheoCoSo);
                                while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                    echo "<tr>";
                                    echo '<th scope="row">' . $row['MAKH'] . '</th>';
                                    echo '<td>' . $row['TENKH'] . '</td>';
                                    echo '<td>' . $row['MACS'] . '</td>';
                                    echo '<td>' .
                                        '<a type="button" class="btn btn-primary"' . 'href="http://localhost/CSDL_PT/giaoVien.php?detailgv=' . $row['MAKH'] . '"' . '>' . '<i class="far fa-eye"></i></a>';
                                    echo '</td>';
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