<!DOCTYPE html>
<html lang="en">
<?php
include_once 'KetNoiCSDL.php';
session_start();
?>

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
    <link rel="stylesheet" href="css/thi_thu.css">
</head>

<body>
    <div class="container">

        <?php
        if (isset($_POST['nopBai'])) {
            $dem = 0;
            foreach ($_SESSION['list'] as $key => $value) {
                if (isset($_REQUEST[$key])) {
                    if ($_REQUEST[$key] == $value) {
                        $dem += 1;
                    }
                }
            }
            $soCau = sizeof($_SESSION['list']);
            $diem = (10 / $soCau) * $dem;
            echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Điểm của bạn :' . $diem . '</h4>
                <p>Có thắc mắc về câu hỏi vui lòng liên hệ giáo viên bộ môn để được giải đáp , xin chân thành cảm ơn</p>
                <hr>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <a href="gv_dk.php" class="btn btn-info" >Quay Về </a>
                        </div>
              </div>';
            unset($_SESSION['list']);
        } else if ($_SESSION['TENNHOM'] == 'COSO' || $_SESSION['TENNHOM'] == 'GIANGVIEN') {
            $sql1 = "EXEC SP_TAI_GV_DK '" . $_REQUEST['LANTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['MALOPTT'] . "'";
            $kq = KetNoiCSDL::goiSP($sql1);
            $row = sqlsrv_fetch_array($kq);
            echo '<div class="timer dh" style=" width: 100px;font-size: 2.5em; text-align: center;">';
            echo '<time id="countdown">' . $row['THOIGIAN'] . '</time>';
            echo '</div>';
        } else if ($_SESSION['TENNHOM'] == 'TRUONG') {
            $sql11 = "EXEC SP_TAI_GV_DK '" . $_REQUEST['LANTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['MALOPTT'] . "'";
            $kq11 = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sql11);
            $row11 = sqlsrv_fetch_array($kq11);
            echo '<div class="timer dh" style=" width: 100px;font-size: 2.5em; text-align: center;">';
            echo '<time id="countdown">' . $row11['THOIGIAN'] . '</time>';
            echo '</div>';
        }



        ?>


        <form action="" name="form_thi_thu" id="form_thi_thu" method="POST">
            <div class="modal-body">
                <input type="hidden" name="go" value="" />
                <ul>
                    <?php
                    $arrList = [];
                    if ($_SESSION['TENNHOM'] == 'COSO' || $_SESSION['TENNHOM'] == 'GIANGVIEN') {
                        if (isset($_REQUEST['MAMHTT']) && isset($_REQUEST['MALOPTT']) && isset($_REQUEST['LANTT']) && !isset($_POST['nopBai'])) {
                            if ($_SESSION['TENNHOM'] != 'SINHVIEN') {

                                $sql = "EXEC SP_ThiThu '" . $_REQUEST['MALOPTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['LANTT'] . "'";
                                $dsTracNghiem = KetNoiCSDL::goiSP($sql);
                                $index = 0;
                                while ($row = sqlsrv_fetch_array($dsTracNghiem)) {
                                    $arrList[$row['CAUHOI']] = $row['DAP_AN'];
                                    $index += 1;
                                    echo '<li>';
                                    echo '<h3>Câu ' . $index . ' : ' . $row['NOIDUNG'] . '</h3>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="A"/>';
                                    echo '<label ">A)' . $row['A'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="B"/>';
                                    echo '<label ">B)' . $row['B'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="C"/>';
                                    echo '<label ">C)' . $row['C'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="D"/>';
                                    echo '<label ">D)' . $row['D'] . '</label>';

                                    echo '</div>';
                                    echo '</li>';
                                }
                                echo '<div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" id="nopBai" class="btn btn-success" name="nopBai">Nộp Bài</button>
                        </div>';
                            }
                            $_SESSION['list'] = $arrList;
                        }
                    } else if ($_SESSION['TENNHOM'] == 'TRUONG') {
                        if (isset($_REQUEST['MAMHTT']) && isset($_REQUEST['MALOPTT']) && isset($_REQUEST['LANTT']) && !isset($_POST['nopBai'])) {
                            if ($_SESSION['TENNHOM'] != 'SINHVIEN') {

                                $sql = "EXEC SP_ThiThu '" . $_REQUEST['MALOPTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['LANTT'] . "'";
                                $dsTracNghiem = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sql);
                                $index = 0;
                                while ($row = sqlsrv_fetch_array($dsTracNghiem)) {
                                    $arrList[$row['CAUHOI']] = $row['DAP_AN'];
                                    $index += 1;
                                    echo '<li>';
                                    echo '<h3>Câu ' . $index . ' : ' . $row['NOIDUNG'] . '</h3>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="A"/>';
                                    echo '<label ">A)' . $row['A'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="B"/>';
                                    echo '<label ">B)' . $row['B'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="C"/>';
                                    echo '<label ">C)' . $row['C'] . '</label>';
                                    echo '</div>';
                                    echo '<div>';
                                    echo ' <input type="radio" name="' . $row['CAUHOI'] . '"value="D"/>';
                                    echo '<label ">D)' . $row['D'] . '</label>';

                                    echo '</div>';
                                    echo '</li>';
                                }
                                echo '<div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" id="nopBai" class="btn btn-success" name="nopBai">Nộp Bài</button>
                        </div>';
                            }
                            $_SESSION['list'] = $arrList;
                        }
                    }

                    ?>
                </ul>

            </div>
        </form>
    </div>
</body>
<script>
    var seconds = <?php
                    if ($_SESSION['TENNHOM'] == 'COSO' || $_SESSION['TENNHOM'] == 'GIANGVIEN') {
                        $sql1 = "EXEC SP_TAI_GV_DK '" . $_REQUEST['LANTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['MALOPTT'] . "'";
                        $kq = KetNoiCSDL::goiSP($sql1);
                        $row = sqlsrv_fetch_array($kq);
                        echo $row['THOIGIAN'] * 60;
                    }else if ($_SESSION['TENNHOM'] == 'TRUONG') {
                        $sql11 = "EXEC SP_TAI_GV_DK '" . $_REQUEST['LANTT'] . "'" . ",'" . $_REQUEST['MAMHTT'] . "'" . ",'" . $_REQUEST['MALOPTT'] . "'";
                        $kq11 = KetNoiCSDL::goiSPHTKN($_SESSION['serverTaoTK'], $sql11);
                        $row11 = sqlsrv_fetch_array($kq11);
                        echo $row11['THOIGIAN'] * 60;
                    }

                    ?>;

    function secondPassed() {
        var minutes = Math.round((seconds - 30) / 60),
            remainingSeconds = seconds % 60;

        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }

        document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
        if (seconds == 0) {
            clearInterval(countdownTimer);
            //form_thi_thu is your form name
            document.getElementById("nopBai").click();
        } else {
            seconds--;
        }
    }
    var countdownTimer = setInterval('secondPassed()', 1000);
</script>
<style>
    .dh {
    text-align: center;
    display: block;
    width: 100%;
    border: 1px gray solid;
    background: yellow;
    border-radius: 20px;
    box-shadow: 1px 1px 2px 4px cadetblue;
    height: 70px;
    position: fixed;
    margin: 10px;
    left: 20px;
}
</style>

</html>