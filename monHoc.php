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
            if (isset($_POST['ghiMoiMonHoc'])) {
                $maMonHoc = $_REQUEST['maMonHoc'];
                $tenMonHoc = $_REQUEST['tenMonHoc'];

                $sql = "EXEC SP_KT_MONHOC_TONTAI '" . $maMonHoc . "'" . ",N'" . $tenMonHoc . "'";
                echo $sql;
                $kq = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kq) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Thêm Thất Bại!</strong> Mã môn học Hoặc Tên môn học Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql1 = "EXEC SP_THEM_MH '" . $maMonHoc . "'" . ",N'" . $tenMonHoc . "'";
                    $kq1 = KetNoiCSDL::goiSP($sql1);
                    header("Refresh:0; url=monHoc.php");
                }
            }

            if (isset($_POST['suaMonHoc'])) {
                $maMonHocSua = $_REQUEST['maMonHoc'];
                $tenMonHocSua = $_REQUEST['tenMonHoc'];
                $maMonHocCu = $_REQUEST['maMonHocCu'];

                $sqlCheck = "EXEC SP_KT_TENMA_MH_TONTAI '" . $maMonHocCu . "'" . ",'" . $maMonHocSua . "'" . ",N'" . $tenMonHocSua . "'";
                $kqCheck = KetNoiCSDL::goiSPNotExec($sqlCheck);
                if (!$kqCheck) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>SỬA Thất Bại!</strong> Mã môn học Hoặc Tên môn học Đã Tồn Tại
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    $sql = "EXEC SP_SUAMH '" . $maMonHocCu . "'" . ",'" . $maMonHocSua . "'" . ",N'" . $tenMonHocSua . "'";
                    $kq = KetNoiCSDL::goiSPNotExec($sql);
                    header("Refresh:0; url=monHoc.php");
                }
            }
            if (isset($_REQUEST['delete'])) {
                $maMH = $_REQUEST['delete'];
                $sql = "EXEC SP_XOAMH '" . $maMH . "'";
                $kqXoa = KetNoiCSDL::goiSPNotExec($sql);
                if (!$kqXoa) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Xóa Thất Bại!</strong> Môn học này đã được sử dụng
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                } else {
                    header("Refresh:0; url=monHoc.php");
                }
            }
            ?>
            <?php
            if ($_SESSION["TENNHOM"] == 'COSO') {
                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form_add" style="margin-left: 80%; margin-bottom: 10px;">
                TẠO MÔN HỌC
            </button>';
            }
            ?>
            
            <!-- form model  -->
            <div class="modal fade" id="form_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">TẠO MÔN HỌC</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mã Môn Học</label>
                                    <input type="text" class="form-control" placeholder="Nhập Mã Môn Học" name="maMonHoc">
                                </div>
                                <div class="form-group">
                                    <label>Tên Môn Học</label>
                                    <input type="text" class="form-control" placeholder="Nhập Tên Môn Học" name="tenMonHoc">
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success" name="ghiMoiMonHoc">Ghi</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Sửa Môn Học</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Mã Môn Học</label>
                                    <?php
                                    $sql = "EXEC TAI_MH_THEO_MAMH '" . $_REQUEST['edit'] . "'";
                                    $kq = KetNoiCSDL::goiSP($sql);
                                    $row = sqlsrv_fetch_array($kq);
                                    echo ' <input style="visibility: hidden;" type="text" class="form-control"  name="maMonHocCu" value="' . $row['MAMH'] . '">';
                                    echo ' <input type="text" class="form-control" placeholder="Nhập Mã Môn Học" name="maMonHoc" value="' . $row['MAMH'] . '">';
                                    echo '</div>
                                        <div class="form-group">
                                            <label>Tên Môn Học</label>';
                                    echo ' <input type="text" class="form-control" placeholder="Nhập Tên Môn Học" name="tenMonHoc" value="' . $row['TENMH'] . '">';
                                    echo '</div>';
                                    ?>
                                </div>
                                <div class="modal-footer border-top-0 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" name="suaMonHoc">Ghi</button>
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
                            <th scope="col">Mã Môn Học</th>
                            <th scope="col">Tên Môn Học</th>
                            <?php
                            if ($_SESSION["TENNHOM"] == 'COSO') {
                                echo '<th scope="col">Actions</th>';
                            }
                            ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sql = "EXEC SP_DSMON";
                        $dsMonHoc = KetNoiCSDL::goiSP($sql);
                        while ($row = sqlsrv_fetch_array($dsMonHoc)) {
                            echo "<tr>";
                            echo '<th scope="row">' . $row['MAMH'] . '</th>';
                            echo '<td>' . $row['TENMH'] . '</td>';
                            if ($_SESSION["TENNHOM"] == 'COSO') {
                                echo '<td>' .
                                    '<a type="button" class="btn btn-success"' . 'href="http://localhost/CSDL_PT/monHoc.php?edit=' . $row['MAMH'] . '"' . '>' . '<i class="fas fa-edit"></i></a>' .
                                    '<a type="button" class="btn btn-danger"' . 'href="http://localhost/CSDL_PT/monHoc.php?delete=' . $row['MAMH'] . '"' . '>' . '<i class="far fa-trash-alt"></i></a>' .
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