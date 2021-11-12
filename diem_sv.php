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
    ?>
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Môn Học</th>
                            <th scope="col">Lần Thi</th>
                            <th scope="col">Số Câu Thi</th>
                            <th scope="col">Điểm</th>
                            <th scope="col">Xem Chi Tiết Bài Làm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION["TENNHOM"] == 'SINHVIEN') {
                            $sql45 = "EXEC TAI_KQ_THI '" . $_SESSION['MASV'] . "'" ;
                            $dsMonDaThi = KetNoiCSDL::goiSP($sql45);
                            if($dsMonDaThi){
                                while ($row = sqlsrv_fetch_array($dsMonDaThi)) {
                                    echo "<tr>";
                                    echo '<th scope="row">' . $row['TENMH'] . '</th>';
                                    echo '<td>' . $row['TENMH'] . '</td>';
                                    echo '<td>' . $row['LAN'] . '</td>';
                                    echo '<td>' . $row['DIEM'] . '</td>';
                                    echo '<td>' .
                                    '<a type="button" class="btn btn-primary"' . 'href="http://localhost/CSDL_PT/detail_thi.php?ct_thi=' . $row['MABD'] . '"' . '>' . '<i class="far fa-eye"></i></a>' .
                                    '</td>';
                                    echo "</tr>";
                                }
                            }else{
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Sinh Viên Chưa Thi Môn Nàoi!</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
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