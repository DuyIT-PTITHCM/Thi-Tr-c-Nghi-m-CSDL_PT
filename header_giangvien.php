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
                <a class="nav-link" href="khoa.php">KHOA</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="lop.php">
                    LỚP
                </a>  
            </li>
            <li class="nav-item">
                <a class="nav-link" href="monHoc.php"><i class="far fa-clone"></i>MÔN HỌC</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="boDe.php"><i class="far fa-chart-bar"></i>ĐỀ THI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gv_dk.php"><i class="far fa-calendar-alt"></i>Thi Thu</a>
            </li>

        </ul>
    </div>
</nav>