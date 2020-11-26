<?php
include_once "connection.inc";

function update_record_csapat(mysqli $conn, string $key, string $nev, string $cimek, string $alpitva) : void
{
    $result = mysqli_query($conn, "UPDATE csapat SET nev = '$nev', cimek = '$cimek', alapitva = '$alpitva' WHERE nev = '$key'");
    check_result($result);
}

function update_record_nagydij(mysqli $conn, string $key, string $datum, string $korok, string $nev, string $palya_nev) : void
{
    $result = mysqli_query($conn, "UPDATE nagydij SET datum = '$datum', korok = '$korok', nev = '$nev', `palya.nev` = '$palya_nev' WHERE datum = '$key'");
    check_result($result);
}

function update_record_palya(mysqli $conn, string $key, string $hossz, string $kanyarok, string $orszag) : void
{
    $result = mysqli_query($conn, "UPDATE palya SET hossz = '$hossz', kanyarok = '$kanyarok', orszag = '$orszag' WHERE nev = '$key'");
    check_result($result);
}

function update_record_reszt_vesz(mysqli $conn, string $key1, string $key2, string $osszpont, string $szam) : void
{
    $result = mysqli_query($conn, "UPDATE resztvesz SET ossz_pont = '$osszpont', szam = '$szam' WHERE `sofor.id` = '$key1' and `soforbajnoksag.ev` = '$key2'");
    check_result($result);
}

function update_record_sofor(mysqli $conn, string $key, string $nev, string $cimek, string $csapat_nev) : void
{
    $result = mysqli_query($conn, "UPDATE sofor SET nev = '$nev', cimek = '$cimek', `csapat.nev` = '$csapat_nev' WHERE id = '$key'");
    check_result($result);
}

function update_record_soforbajnoksag(mysqli $conn, string $key, string $nev) : void
{
    $result = mysqli_query($conn, "UPDATE soforbajnoksag SET nev = '$nev' WHERE ev = '$key'");
    check_result($result);
}

function update_record_versenyez(mysqli $conn, string $key1, string $key2, string $helyezes, string $szerzett_pontok, string $start_pozicio) : void
{
    $result = mysqli_query($conn, "UPDATE versenyez SET helyezes = '$helyezes', szerzett_pontok = '$szerzett_pontok', start_pozicio = '$start_pozicio' WHERE `nagydij.datum` = '$key1' and `sofor.id` = '$key2'");
    check_result($result);
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>
                alert('SIKERES módosítás!');
                window.location.replace('../pages/index.html');
              </script>";
    else
        echo "<script>
                alert('SIKERTELEN módosítás!');
                window.location.replace('../pages/index.html');
              </script>";
}

if (isset($_POST["key"]))
{
    $conn = connect_to_sql();
    $arr = explode(",", $_POST["key"]);
    if (!mysqli_select_db($conn, "csapat_sport"))
    {
        close($conn);
        die("Database cannot be reached");
    }
    switch ($arr[0])
    {
        case "csapat": update_record_csapat($conn, $arr[1], $_POST["nev"], $_POST["cimek"], $_POST["alapitva"]); break;
        case "nagydij": update_record_nagydij($conn, $arr[1], $_POST["datum"], $_POST["korok"], $_POST["nev"], $_POST["palya_nev"]); break;
        case "palya": update_record_palya($conn, $arr[1], $_POST["hossz"], $_POST["kanyarok"], $_POST["orszag"]); break;
        case "resztvesz": update_record_reszt_vesz($conn, $arr[1], $arr[2], $_POST["ossz_pont"], $_POST["szam"]); break;
        case "sofor": update_record_sofor($conn, $arr[1], $_POST["nev"], $_POST["cimek"], $_POST["csapat_nev"]); break;
        case "soforbajnoksag": update_record_soforbajnoksag($conn, $arr[1], $_POST["nev"]); break;
        case "versenyez": update_record_versenyez($conn, $arr[1], $arr[2], $_POST["helyezes"], $_POST["szerzett_pontok"], $_POST["start_pozicio"]); break;
        default: die("Unknown error!");
    }
    close($conn);
}