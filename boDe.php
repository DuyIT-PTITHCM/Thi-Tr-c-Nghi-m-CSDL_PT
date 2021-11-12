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
            if (isset($_POST['ghiMoiCauHoi'])) {
                $cauSo = $_REQUEST['cauSo'];
                $monHocThem = $_REQUEST['monHocThem'];
                $noiDung = $_REQUEST['noiDung'];
                $a = $_REQUEST['a'];
                $b = $_REQUEST['b'];
                $c = $_REQUEST['c'];
                $d = $_REQUEST['d'];
                $trinhDo = $_REQUEST['trinhDo'];
                $dapAn = $_REQUEST['dapAn'];
                $maGV = $_SESSION['USERNAME'];
                $sql = "EXEC SP_THEM_CAUHOI '" . $cauSo . "'" . ",'" . $monHocThem . "'" . ",'" . $trinhDo . "'" . ",N'" . $noiDung . "'" . ",N'" . $a . "'" . ",N'" . $b . "'" . ",N'" . $c . "'" . ",N'" . $d . "'" . ",'" . $dapAn . "'" . ",'" . $maGV . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Thêm Thất Bại!</strong> Tên câu hỏi Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0;");
                }
            }

            if (isset($_POST['suaCauHoi'])) {
                $cauHoiCu = $_REQUEST['edit'];
                $cauSo = $_REQUEST['cauHoi'];
                $monHocSua = $_REQUEST['monHocSua'];
                $noiDung = $_REQUEST['noiDung'];
                $a = $_REQUEST['a'];
                $b = $_REQUEST['b'];
                $c = $_REQUEST['c'];
                $d = $_REQUEST['d'];
                $trinhDo = $_REQUEST['trinhDo'];
                $dapAn = $_REQUEST['dapAn'];
                $maGV = $_SESSION['USERNAME'];
                $sql = "EXEC SP_SUA_CAUHOI '" . $cauHoiCu . "'" . ",'" . $cauSo . "'" . ",'" . $monHocSua . "'" . ",'" . $trinhDo . "'" . ",N'" . $noiDung . "'" . ",N'" . $a . "'" . ",N'" . $b . "'" . ",N'" . $c . "'" . ",N'" . $d . "'" . ",'" . $dapAn . "'";
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>SỬA Thất Bại!</strong> Vui Lòng Kiểm Tra Lại Số Câu Hỏi
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0; url=http://localhost/CSDL_PT/boDe.php");
                }
            }
            if (isset($_REQUEST['delete'])) {
                $cauHoi = $_REQUEST['delete'];
                $sqlXoaGV = "EXEC SP_XOA_CAUHOI '" . $cauHoi . "'" . ",'" . $_SESSION['USERNAME'] . "'";
                $kqXoa = KetNoiCSDL::goiSPNotExec($sqlXoaGV);
                if (!$kqXoa) {
            ?>
                    <script type="text/javascript">
                        alert('xóa thất bại ! bạn ko có quyền xóa câu hỏi người khác hoặc câu hỏi này đã thi');
                    </script>
            <?php

                    header("Refresh:0; url=http://localhost/CSDL_PT/boDe.php");
                } else {
                    header("Refresh:0; url=http://localhost/CSDL_PT/boDe.php");
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
                            <div class="modal-footer border-top-0 d-flex">
                                <button type="submit" class="btn btn-success" name="napServer">Tải dữ liệu theo cơ sở</button>';
                        }
                        ?>
                    </div>
                </div>
            </form>

            <form action="" method="POST">

                <?php
                if (!isset($_POST['napServer']) && (($_SESSION["TENNHOM"] == 'COSO') || ($_SESSION["TENNHOM"] == 'GIANGVIEN'))) {
                    echo '<div class="modal-body" style="display: flex;">
                            <div class="form-group" style="display: flex;">';
                    echo '<select class="form-control" name="taiMonHoc">';
                    $sql = "EXEC SP_DSMON";
                    $dsMonHoc = KetNoiCSDL::goiSP($sql);
                    while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                        echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                    }
                    echo '</select>';
                    if ($_SESSION["TENNHOM"] == 'COSO') {
                        echo '<select class="form-control" name="taiGV">';
                        $sql = "EXEC SP_DS_GV";
                        $dsGiaoVien = KetNoiCSDL::goiSP($sql);
                        while ($row = sqlsrv_fetch_object($dsGiaoVien)) {
                            echo '<option value=' . $row->MAGV . '>' . $row->TEN . '</option>';
                        }
                        echo '</select>';
                    }
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
                    echo '<select class="form-control" name="taiMonHoc">';
                    $sql = "EXEC SP_DSMON";
                    $dsMonHoc = KetNoiCSDL::goiSP($sql);
                    while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                        echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                    }
                    echo '</select>';


                    echo '<select class="form-control" name="taiGV">';
                    $sqlNap = "EXEC SP_DS_GV";
                    $dsTheoCoSo = KetNoiCSDL::goiSPHTKN($_REQUEST['taiChiNhanh'], $sqlNap);
                    while ($row = sqlsrv_fetch_object($dsTheoCoSo)) {
                        echo '<option value=' . $row->MAGV . '>' . $row->TEN . '</option>';
                    }
                    echo '</select>';

                    echo '</div>
                    <div class="modal-footer border-top-0 d-flex " style="margin-top: -20px;">
                        <button type="submit" class="btn btn-success" name="napDuLieu">Tải dữ liệu</button>
                    </div>
                </div>';
                }
                ?>

            </form>
            <?php
            if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form_add" style="margin-left: 80%;margin-top: -80px;">
                    Thêm Câu Hỏi
                </button>';
            }
            ?>
            <!-- form model  -->
            <div class="modal fade" id="form_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm Câu Hỏi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Chọn Môn</label>
                                    <?php
                                    echo '<select class="form-control" name="monHocThem">';
                                    $sql = "EXEC SP_DSMON";
                                    $dsMonHoc = KetNoiCSDL::goiSP($sql);
                                    while ($row = sqlsrv_fetch_object($dsMonHoc)) {
                                        echo '<option value=' . $row->MAMH . '>' . $row->TENMH . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>

                                <div class="form-group">
                                    <label>Câu Số</label>
                                    <input type="number" class="form-control" placeholder="Nhập Câu Số" name="cauSo">
                                </div>
                                <div class="form-group">
                                    <label>Nội Dung</label>
                                    <textarea type="text" class="form-control" placeholder="Nhập Nội Dung" name="noiDung"></textarea>

                                </div>
                                <div class="form-group">
                                    <label>A</label>
                                    <textarea type="text" class="form-control" placeholder="Nhập A" name="a"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>B</label>
                                    <textarea type="text" class="form-control" placeholder="Nhập B" name="b"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>C</label>
                                    <textarea type="text" class="form-control" placeholder="Nhập A" name="c"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>D</label>
                                    <textarea type="text" class="form-control" placeholder="Nhập B" name="d"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Trình Độ</label>
                                    <select name="trinhDo" id="" class="form-control">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Đáp Án</label>
                                    <select name="dapAn" id="" class="form-control">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="ghiMoiCauHoi">Ghi</button>
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
                                <?php
                                if ($_REQUEST['edit']) {
                                    $sqlCheck = "EXEC SP_KT_CAUHOI_TONTAI '" . $_REQUEST['edit'] . "'" . ",'" . $_SESSION['USERNAME'] . "'";
                                    $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                                    if (!$kqCheck) {
                                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>CÂU HỎI NÀY KHÔNG PHẢI CỦA BẠN !</strong> Vui lòng lọc câu hỏi của bạn để thực hiện
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                                            <a type="submit" class="btn btn-success" href="http://localhost/CSDL_PT/boDe.php">Quay Lai</a>
                                        </div>
                                      </div>';
                                    } else {
                                        $sql = "EXEC TAI_BODE_THEO_CH '" . $_REQUEST['edit'] . "'" . ",'" . $_SESSION['USERNAME'] . "'";
                                        $kq = KetNoiCSDL::goiSP($sql);
                                        $row = sqlsrv_fetch_array($kq);

                                        echo '<select class="form-control" name="monHocSua">';
                                        $sql11 = "EXEC SP_DSMON";
                                        $dsMonHoc = KetNoiCSDL::goiSP($sql11);
                                        while ($row11 = sqlsrv_fetch_object($dsMonHoc)) {
                                            if ($row11->MAMH == $row['MAMH']) {
                                                echo '<option selected value=' . $row11->MAMH . '>' . $row11->TENMH . '</option>';
                                            } else {
                                                echo '<option value=' . $row11->MAMH . '>' . $row11->TENMH . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        echo '<div class="form-group">
                                        <label>Câu Hỏi</label>';
                                        echo ' <input type="number" class="form-control" name="cauHoi" value="' . $row['CAUHOI'] . '">';
                                        echo '</div>';

                                        echo '<div class="form-group">
                                        <label>Nội Dung</label>';
                                        echo ' <textarea type="text" class="form-control" name="noiDung">' . $row['NOIDUNG'] . '</textarea>';
                                        echo '</div>';

                                        echo '<div class="form-group">
                                    <label>A</label>';
                                        echo ' <textarea type="text" class="form-control" name="a">' . $row['A'] . '</textarea>';
                                        echo '</div>';

                                        echo '<div class="form-group">
                                        <label>B</label>';
                                        echo ' <textarea type="text" class="form-control" name="b">' . $row['B'] . '</textarea>';
                                        echo '</div>';

                                        echo '<div class="form-group">
                                        <label>C</label>';
                                        echo ' <textarea type="text" class="form-control" name="c">' . $row['C'] . '</textarea>';
                                        echo '</div>';

                                        echo '<div class="form-group">
                                        <label>D</label>';
                                        echo ' <textarea type="text" class="form-control" name="d">' . $row['D'] . '</textarea>';
                                        echo '</div>';

                                        echo '<div class="form-group">';
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
                                        echo '</select></div>';

                                        echo '<div class="form-group">';
                                        echo '<label>Đáp Án</label>
                                    <select name="dapAn" id="" class="form-control">';
                                        $arrDA = ['A', 'B', 'C', 'D'];
                                        foreach ($arrDA as $value1) {
                                            if ($row['DAP_AN'] == $value1) {
                                                echo '<option selected value="' . $value1 . '">' . $value1 . '</option>';
                                            } else {
                                                echo '<option value="' . $value1 . '">' . $value1 . '</option>';
                                            }
                                        }
                                        echo '</select></div>';
                                        echo '<div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaCauHoi">Ghi</button>
                                </div>';
                                    }
                                }
                                ?>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
            <!-- end form model  -->
            <div class="col-12">
                <h2 style="text-align: center;"><?php if (isset($_POST['napDuLieu'])) {
                                                    echo "Môn " . $_REQUEST['taiMonHoc'];
                                                    if ($_SESSION['TENNHOM'] == 'GIANGVIEN') {
                                                        echo "- Giáo Viên  " . $_SESSION['USERNAME'];
                                                    } else {
                                                        echo "- Giáo Viên  " . $_REQUEST['taiGV'];
                                                    }
                                                } ?></h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Câu Số</th>
                            <th scope="col">Nội Dung</th>
                            <th scope="col">A</th>
                            <th scope="col">B</th>
                            <th scope="col">C</th>
                            <th scope="col">D</th>
                            <th scope="col">Trình Độ</th>
                            <th scope="col">Đáp Án</th>
                            <?php
                            if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                                echo '<th class="col-1">Actions</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['napDuLieu'])) {
                            if ($_SESSION["TENNHOM"] == 'COSO' || $_SESSION["TENNHOM"] == 'GIANGVIEN') {
                                //$chiNhanh = $_REQUEST['taiChiNhanh'];
                                if ($_SESSION["TENNHOM"] == 'COSO') {
                                    $maGV = $_REQUEST["taiGV"];
                                } else {
                                    $maGV = $_SESSION["USERNAME"];
                                }
                                $monHoc = $_REQUEST['taiMonHoc'];
                                $sql = "EXEC SP_TAI_BODE_THEO_GV_MON '" . $maGV . "'" . ",'" . $monHoc . "'";
                                $dsDe = KetNoiCSDL::goiSP($sql);
                                while ($row = sqlsrv_fetch_array($dsDe)) {
                                    echo '<tr >';
                                    echo '<td scope="col">' . $row['CAUHOI'] . '</th>';
                                    echo '<td scope="col">' . $row['NOIDUNG'] . '</td>';
                                    echo '<td scope="col">' . $row['A'] . '</td>';
                                    echo '<td scope="col">' . $row['B'] . '</td>';
                                    echo '<td scope="col">' . $row['C'] . '</td>';
                                    echo '<td scope="col">' . $row['D'] . '</td>';
                                    echo '<td scope="col">' . $row['TRINHDO'] . '</td>';
                                    echo '<td scope="col">' . $row['DAP_AN'] . '</td>';

                                    echo '<td class="col-1">' .
                                        '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/boDe.php?edit=' . $row['CAUHOI'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                        '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/boDe.php?delete=' . $row['CAUHOI'] .  '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
                                        '</td>';
                                    echo "</tr>";
                                }
                            } else {
                                $maGV = $_REQUEST["taiGV"];
                                $monHoc = $_REQUEST['taiMonHoc'];
                                $sqlNap = "EXEC SP_TAI_BODE_THEO_GV_MON '" . $maGV . "'" . ",'" . $monHoc . "'";
                                $dsDe = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'],$sqlNap);
                                while ($row = sqlsrv_fetch_array($dsDe)) {
                                    echo '<tr >';
                                    echo '<td scope="col">' . $row['CAUHOI'] . '</th>';
                                    echo '<td scope="col">' . $row['NOIDUNG'] . '</td>';
                                    echo '<td scope="col">' . $row['A'] . '</td>';
                                    echo '<td scope="col">' . $row['B'] . '</td>';
                                    echo '<td scope="col">' . $row['C'] . '</td>';
                                    echo '<td scope="col">' . $row['D'] . '</td>';
                                    echo '<td scope="col">' . $row['TRINHDO'] . '</td>';
                                    echo '<td scope="col">' . $row['DAP_AN'] . '</td>';

                                    
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
    <style>
        body {
            font-size: 13px;
        }
    </style>

</body>

</html>