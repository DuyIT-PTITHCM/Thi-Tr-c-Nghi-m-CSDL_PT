
<?php

class KetNoiCSDL
{
    public static $serverName = "DUY";
    public static $serverLogin = "";
    public static $userName = "";
    public static $password = "";
    public static $SERVER_HTKN = "";
    public static $HTKN = "HTKN";
    public static $MKHTKN = "123456";

    public static $connectionInfo = array(
        "Database" => "THITN",
        "CharacterSet" => "UTF-8"
    );
    public static $connectionRoot = null;
    public static $connectionMain = null;
    // Constructor
    public function __construct()
    {
        echo 'The class "' . __CLASS__ . '" was initiated!<br>';
    }
    public function KetNoiRoot()
    {

        $con = sqlsrv_connect(KetNoiCSDL::$serverName, KetNoiCSDL::$connectionInfo);
        KetNoiCSDL::$connectionRoot = $con;
        return $con;
    }
    public static function login($serverLogin, $UID, $PWD)
    {
        $infoLogin = array(
            "Database" => "THITN",
            "UID" => $UID,
            "PWD" => $PWD,
            "CharacterSet" => "UTF-8"
        );
        $con = sqlsrv_connect($serverLogin, $infoLogin);
        if ($con) {
            $_SESSION["connection"] = $con;
            $_SESSION["UID"] = $UID;
            $_SESSION["PWD"] = $PWD;
            $_SESSION["CHINHANH"] = $serverLogin;
            return true;
        }
        return false;
    }
    public static function loginHTKN($serverLogin, $UID, $PWD)
    {
        $infoLogin = array(
            "Database" => "THITN",
            "UID" => $UID,
            "PWD" => $PWD,
            "CharacterSet" => "UTF-8"
        );
        $con = sqlsrv_connect($serverLogin, $infoLogin);
        if ($con) {
            $_SESSION["connectionHTKN"] = $con;
            return true;
        }
        return false;
    }

    public static function goiSPNotExecHTKN($serverLogin,$sql)
    {
        KetNoiCSDL::loginHTKN($serverLogin, KetNoiCSDL::$HTKN, KetNoiCSDL::$MKHTKN);
        try {
            $kq = sqlsrv_prepare($_SESSION["connectionHTKN"], $sql);
            return sqlsrv_execute($kq);
        } catch (Exception $err) {
            return $err;
        }
    }
    public static function goiSPHTKN($serverLogin ,$sql)
    {
        KetNoiCSDL::loginHTKN($serverLogin, KetNoiCSDL::$HTKN, KetNoiCSDL::$MKHTKN);
        try {
            return sqlsrv_query($_SESSION["connectionHTKN"], $sql);
        } catch (Exception $err) {
            return $err;
        }
    }

    public function danhSachChiNhanh()
    {
        if (KetNoiCSDL::$connectionRoot != null) {
            $sql = "select * from View_DS_COSO";
            $stmt = sqlsrv_query(KetNoiCSDL::$connectionRoot, $sql, array());
            return  $stmt;
        } else {
            $this->KetNoiRoot();
            $sql = "select * from View_DS_COSO";
            $stmt = sqlsrv_query(KetNoiCSDL::$connectionRoot, $sql, array());
            return  $stmt;
        }
    }
    public static function goiSP($sql)
    {
        KetNoiCSDL::login($_SESSION['CHINHANH'], $_SESSION['UID'], $_SESSION['PWD']);
        try {
            return sqlsrv_query($_SESSION["connection"], $sql);
        } catch (Exception $err) {
            return $err;
        }
    }
    public static function goiSPNotExec($sql)
    {
        KetNoiCSDL::login($_SESSION['CHINHANH'], $_SESSION['UID'], $_SESSION['PWD']);
        try {
            $kq = sqlsrv_prepare($_SESSION["connection"], $sql);
            return sqlsrv_execute($kq);
        } catch (Exception $err) {
            return $err;
        }
    }
}

?>