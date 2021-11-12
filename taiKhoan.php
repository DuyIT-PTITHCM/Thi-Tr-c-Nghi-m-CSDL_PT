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
    <?php
    include_once 'gvQuanLy.php';
    ?>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <?php
            include_once 'KetNoiCSDL.php';
            if (isset($_POST['taoTaiKhoan'])) {
                $tenDN = $_REQUEST['tenDN'];
                $matKhau = $_REQUEST['matKhau'];
                $maGv = $_REQUEST['addTK'];

                $sqlCheck = "EXEC SP_TENTK_TONTAI '" . $tenDN . "'";

                if ($_SESSION["TENNHOM"] == 'COSO') {
                    $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                    if (!$kqCheck) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Tạo thất bại!</strong> Tên đăng nhập Đã Tồn Tại
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                    } else {
                        $loaiQuyenCS = $_REQUEST['loaiQuyen'];
                        //dung connection coso bth thoi
                        $sqkTaoTKCoSo = "EXEC sp_TaoTaiKhoan '" . $tenDN . "'" . ",'" . $matKhau . "'" . ",'" . $maGv . "'" . ",'" . $loaiQuyenCS . "'";
                        $kq = KetNoiCSDL::goiSPNotExec($sqkTaoTKCoSo);
                        if (!$kq) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Tạo thất bại!</strong> Mã giáo viên Đã Tồn Tại
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                        } else {
                            if (isset($_REQUEST['addTK'])) { ?>
                                <script type="text/javascript">
                                    alert("Tạo thành công");
                                </script>
                            <?php
                            }
                            header("Refresh:0; url=http://localhost/CSDL_PT/taiKhoan.php");
                        }
                    }
                } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                    $kqCheckTr = KetNoiCSDL::goiSPNotExecHTKN($_SESSION['serverTaoTK'], $sqlCheck);
                    if (!$kqCheckTr) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Tạo thất bại!</strong> Tên đăng nhập Đã Tồn Tại
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                    } else {
                        KetNoiCSDL::$SERVER_HTKN = $_SESSION['serverTaoTK'];
                        $loaiQuyenTr = 'TRUONG';
                        $sqlTKTr = "EXEC sp_TaoTaiKhoan '" . $tenDN . "'" . ",'" . $matKhau . "'" . ",'" . $maGv . "'" . ",'" . $loaiQuyenTr . "'";
                        $kq1 = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sqlTKTr);
                        echo $sqlTKTr;
                        if (!$kq1) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Tạo thất bại!</strong> MÃ giáo viên Đã Tồn Tại
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                          
                          header("Refresh:0; url=http://localhost/CSDL_PT/taiKhoan.php");
                        }else{
                            if (isset($_REQUEST['addTK'])) { ?>
                                <script type="text/javascript">
                                    alert("Tạo thành công");
                                </script>
                            <?php
                            }
                            header("Refresh:0; url=http://localhost/CSDL_PT/taiKhoan.php");
                        }
                    }
                }
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
            <div class="modal fade" id="form_add_taikhoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    if ($_SESSION["TENNHOM"] == 'COSO') {
                                        echo '<select class="form-control" id="exampleFormControlSelect1" name="loaiQuyen">';
                                        echo '<option value="COSO">Quyền Cơ Sở</option>';
                                        echo '<option value="GIANGVIEN">Quyền Giảng Viên</option>';
                                        echo '</select>';
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Tên Đăng Nhập</label>
                                    <input type="text" class="form-control" placeholder="Nhập Tên Đăng Nhập" name="tenDN">
                                </div>
                                <div class="form-group">
                                    <label>Mật Khẩu</label>
                                    <input type="text" class="form-control" placeholder="Nhập Mật Khẩu" name="matKhau">
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="taoTaiKhoan">Ghi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <div class="col-12">
                <h2 style="text-align: center;"> Danh Sách Giáo Viên Chưa Có Tài Khoản </h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã Giáo Viên</th>
                            <th scope="col">Tên Giáo Viên</th>
                            <th scope="col">Mã Khoa</th>
                            <th scope="col">Địa Chỉ</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'COSO') {
                            $sql = "EXEC SP_MA_GV_CHUA_TAO_TK";
                            $dsGiaoVienTheoKhoa = KetNoiCSDL::goiSP($sql);
                            while ($row = sqlsrv_fetch_array($dsGiaoVienTheoKhoa)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                echo '<td>' . $row['MAKH'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                                echo '<td>' .
                                    '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/taiKhoan.php?addTK=' . $row['MAGV'] . '"' . '>' . '<i class="fa fa-user-plus" aria-hidden="true"></i></a>' .
                                    '</td>';
                                echo "</tr>";
                            }
                        } else if ($_SESSION["TENNHOM"] == 'TRUONG') {
                            if (isset($_POST['napDuLieu'])){
                                $sqlNap = "EXEC SP_MA_GV_CHUA_TAO_TK";
                                unset($_SESSION['serverTaoTK']);
                                $_SESSION['serverTaoTK'] = $_REQUEST['taiChiNhanh'];
                            $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_REQUEST['taiChiNhanh'],$sqlNap);
                            //var_dump($dsTheoCoSo);
                            while ($row = sqlsrv_fetch_array($dsTheoCoSo)) {
                                echo "<tr>";
                                echo '<th scope="row">' . $row['MAGV'] . '</th>';
                                echo '<td>' . $row['TEN'] . '</td>';
                                echo '<td>' . $row['MAKH'] . '</td>';
                                echo '<td>' . $row['DIACHI'] . '</td>';
                                echo '<td>' .
                                    '<a type="button" class="btn btn-info"' . 'href="http://localhost/CSDL_PT/taiKhoan.php?addTK=' . $row['MAGV'] . '"' . '>' . '<i class="fa fa-user-plus" aria-hidden="true"></i></a>' .
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
    if (isset($_REQUEST['addTK'])) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#form_add_taikhoan').modal('show');
            });
        </script>
    <?php
    }
    ?>
</body>

</html>