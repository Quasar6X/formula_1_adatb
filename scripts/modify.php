<?php
include_once "connection.inc";

function update_record_csapat(mysqli $conn, string $key, string $nev, string $cimek, string $alpitva) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE csapat SET nev = ?, cimek = ?, alapitva = ? WHERE nev = ?"))
    {
        $stmt->bind_param("siis", $nev, $cimek, $alpitva, $key);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_nagydij(mysqli $conn, string $key, string $datum, string $korok, string $nev, string $palya_nev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE nagydij SET datum = ?, korok = ?, nev = ?, `palya.nev` = ? WHERE datum = ?"))
    {
        $stmt->bind_param("sisss", $datum, $korok, $nev, $palya_nev, $key);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_palya(mysqli $conn, string $key, string $hossz, string $kanyarok, string $orszag) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE palya SET hossz = ?, kanyarok = ?, orszag = ? WHERE nev = ?"))
    {
        $stmt->bind_param("diss", $hossz, $kanyarok, $orszag, $key);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_reszt_vesz(mysqli $conn, string $key1, string $key2, string $osszpont, string $szam) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE resztvesz SET ossz_pont = ?, szam = ? WHERE `sofor.id` = ? and `soforbajnoksag.ev` = ?"))
    {
        $stmt->bind_param("iiis", $osszpont, $szam, $key1, $key2);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_sofor(mysqli $conn, string $key, string $nev, string $cimek, string $csapat_nev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE sofor SET nev = ?, cimek = ?, `csapat.nev` = ? WHERE id = ?"))
    {
        $stmt->bind_param("sisi", $nev, $cimek, $csapat_nev, $key);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_soforbajnoksag(mysqli $conn, string $key, string $nev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE soforbajnoksag SET nev = ? WHERE ev = ?"))
    {
        $stmt->bind_param("ss", $nev, $key);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function update_record_versenyez(mysqli $conn, string $key1, string $key2, string $helyezes, string $szerzett_pontok, string $start_pozicio) : void
{
    $result = false;
    if ($stmt = $conn->prepare("UPDATE versenyez SET helyezes = ?, szerzett_pontok = ?, start_pozicio = ? WHERE `nagydij.datum` = ? and `sofor.id` = ?"))
    {
        $stmt->bind_param("iiisi", $helyezes, $szerzett_pontok, $start_pozicio, $key1, $key2);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>
                alert('SIKERES módosítás!');
                window.location.replace('../pages/index.php');
              </script>";
    else
        echo "<script>
                alert('SIKERTELEN módosítás!');
                window.location.replace('../pages/index.php');
              </script>";
}

if (isset($_POST["key"]))
{
    $conn = connect_to_sql();
    $arr = explode(",", $_POST["key"]);
    match ($arr[0])
    {
        "csapat" => update_record_csapat($conn, $arr[1], $_POST["nev"], $_POST["cimek"], $_POST["alapitva"]),
        "nagydij" => update_record_nagydij($conn, $arr[1], $_POST["datum"], $_POST["korok"], $_POST["nev"], $_POST["palya_nev"]),
        "palya" => update_record_palya($conn, $arr[1], $_POST["hossz"], $_POST["kanyarok"], $_POST["orszag"]),
        "resztvesz" => update_record_reszt_vesz($conn, $arr[1], $arr[2], $_POST["ossz_pont"], $_POST["szam"]),
        "sofor" => update_record_sofor($conn, $arr[1], $_POST["nev"], $_POST["cimek"], $_POST["csapat_nev"]),
        "soforbajnoksag" => update_record_soforbajnoksag($conn, $arr[1], $_POST["nev"]),
        "versenyez" => update_record_versenyez($conn, $arr[1], $arr[2], $_POST["helyezes"], $_POST["szerzett_pontok"], $_POST["start_pozicio"]),
        default => die("Unknown error!"),
    };
    $conn->close();
}