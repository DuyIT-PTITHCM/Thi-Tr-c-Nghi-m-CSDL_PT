<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1" style="padding-top: 150px;">
                    <h2>Đăng nhập </h2>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Chọn Cơ Sở</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="chiNhanh">
                                <?php
                                include("KetNoiCSDL.php");
                                $ketNoi = new KetNoiCSDL();
                                $dataDs = $ketNoi->danhSachChiNhanh();
                                while ($row = sqlsrv_fetch_object($dataDs)) {
                                    echo '<option value=' . $row->TENSERVER . '>' . $row->TENCN . '</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <div class="divider d-flex align-items-center my-4">
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Tên Đăng Nhập</label>
                            <input type="text" name="tenDN" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Mật Khẩu </label>
                            <input type="password" name="matKhau" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />

                        </div>
                        <div style="display: flex; padding: 25px;">
                            <!-- Material inline 1 -->
                            <div class="form-check form-check-inline" style="width: 50%;">
                                <input type="radio" value="giaoVien" class="form-check-input" id="materialInline1" name="kieuLogin">
                                <label class="form-check-label" for="materialInline1">Giáo Viên</label>
                            </div>

                            <!-- Material inline 2 -->
                            <div class="form-check form-check-inline">
                                <input checked type="radio" value="sinhVien" class="form-check-input" id="materialInline2" name="kieuLogin">
                                <label class="form-check-label" for="materialInline2">Sinh Viên</label>
                            </div>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" name="submit">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>
    <?php

    if (isset($_POST['submit'])) {
        session_start();
        unset($_SESSION["USERNAME"]);
        unset($_SESSION["HOTEN"]);
        unset($_SESSION["TENNHOM"]);
        unset($_SESSION["UID"]);
        unset($_SESSION["PWD"]);
        unset($_SESSION["CHINHANH"]);
        session_destroy();
        $chiNhanh = $_REQUEST['chiNhanh'];
        $tenDN = $_REQUEST['tenDN'];
        $matKhau = $_REQUEST['matKhau'];
        $kieuLogin = $_REQUEST['kieuLogin'];
        session_start();
        if ($kieuLogin == "giaoVien") {
            $con = KetNoiCSDL::login($chiNhanh, $tenDN, $matKhau);
            if ($con) {
                $sql = "exec SP_LAY_TT_DANGNHAP '" . $tenDN . "'";

                $result = KetNoiCSDL::goiSP($sql);
                $row = sqlsrv_fetch_array($result);
                if ($row["USERNAME"]) {
                    
                    $_SESSION["USERNAME"] = $row["USERNAME"];
                    $_SESSION["HOTEN"] = $row["HOTEN"];
                    $_SESSION["TENNHOM"] = $row["TENNHOM"];
                    $_SESSION["UID"] = $tenDN;
                    $_SESSION["PWD"] = $matKhau;
                    $_SESSION["CHINHANH"] = $chiNhanh;
                    if ($row["TENNHOM"] == 'TRUONG') {
                        header('Location: http://localhost/CSDL_PT/taiKhoan.php');
                    } else {
                        header('Location: http://localhost/CSDL_PT/khoa.php');
                    }
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Đăng nhập Thất Bại!</strong>Vui lòng kiểm tra đăng nhập lại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
            }
        } else if ($kieuLogin == "sinhVien") {
            $con = KetNoiCSDL::login($chiNhanh, 'sv', '123456');
            if ($con) {
                $sql = "exec SP_LAY_TT_DANGNHAP_SV '" . $tenDN . "'" . ",'" . $matKhau . "'";
                $result = KetNoiCSDL::goiSP($sql);
                $row = sqlsrv_fetch_array($result);
                if (isset($row["MASV"])) {
                    $_SESSION["MASV"] = $row["MASV"];
                    $_SESSION["MALOP"] = $row["MALOP"];
                    $_SESSION["HOTEN"] = $row["TENSV"];
                    $_SESSION["TENNHOM"] = 'SINHVIEN';
                    $_SESSION["UID"] = 'sv';
                    $_SESSION["PWD"] = '123456';
                    $_SESSION["CHINHANH"] = $chiNhanh;
                     header('Location: http://localhost/CSDL_PT/svMain.php');
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Đăng nhập Thất Bại!</strong>Vui lòng kiểm tra đăng nhập lại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
            }
        }
    }
    ?>

</body>

</html>