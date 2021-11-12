<?php

if (!isset($_SESSION['TENNHOM'])) {
    header('Location: http://localhost/CSDL_PT/index.php');
}
?>
<nav class="navbar navbar-expand-custom navbar-mainbg">
    <a class="navbar-brand navbar-logo" href="#"><?php echo $_SESSION['HOTEN']; ?></a>
    <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <li class="nav-item">
                <a class="nav-link" href="svMain.php">Danh Sách Môn Học Hôm Nay Thi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="lich_thi.php">Lịch Thi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="diem_sv.php">Xem Điểm</a>
            </li>
        </ul>
    </div>
</nav>