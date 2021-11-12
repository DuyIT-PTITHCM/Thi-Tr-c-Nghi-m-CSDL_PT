<?php
session_start();
if (!isset($_SESSION['TENNHOM'])) {
    header('Location: http://localhost/CSDL_PT/index.php');
}
if($_SESSION['TENNHOM']=="COSO"){
    include_once 'header_coso.php';
}else if($_SESSION['TENNHOM']=="GIANGVIEN"){
    include_once 'header_giangvien.php';
}else if($_SESSION['TENNHOM']=="TRUONG"){
    include_once 'header_truong.php';
}else if($_SESSION['TENNHOM']=="SINHVIEN"){
    include_once 'header_sv.php';
}
?>
 