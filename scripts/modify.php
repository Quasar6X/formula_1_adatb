<?php
include_once "connection.php";

function update_record_csapat(mysqli $conn, string $table, string $key) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET nev = '". $_POST["nev"] ."', cimek = '". $_POST["cimek"] ."', alapitva = '". $_POST["alapitva"] . "' WHERE nev = '". $key ."'");
    check_result($result);
}

function update_record_nagydij(mysqli $conn, string $table, string $key) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET datum = '". $_POST["datum"] ."', korok = '". $_POST["korok"] ."', nev = '". $_POST["nev"] ."', `palya.nev` = '". $_POST["palya_nev"] ."' WHERE datum = '". $key ."'");
    check_result($result);
}

function update_record_palya(mysqli $conn, string $table, string $key) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET hossz = '". $_POST["hossz"] ."', kanyarok = '". $_POST["kanyarok"] ."', orszag = '". $_POST["orszag"] ."' WHERE nev = '". $key ."'");
    check_result($result);
}

function update_record_reszt_vesz(mysqli $conn, string $table, string $key1, string $key2) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET ossz_pont = '". $_POST["ossz_pont"] ."', szam = '". $_POST["szam"] ."' WHERE `sofor.id` = '". $key1 . "' and `soforbajnoksag.ev` = '". $key2 ."'");
    check_result($result);
}

function update_record_sofor(mysqli $conn, string $table, string $key) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET nev = '". $_POST["nev"] ."', cimek = '". $_POST["cimek"] ."', `csapat.nev` = '". $_POST["csapat_nev"] . "' WHERE id = '". $key ."'");
    check_result($result);
}

function update_record_soforbajnoksag(mysqli $conn, string $table, string $key) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET nev = '". $_POST["nev"] ."' WHERE ev = '". $key ."'");
    check_result($result);
}

function update_record_versenyez(mysqli $conn, string $table, string $key1, string $key2) : void
{
    $result = mysqli_query($conn, "UPDATE ". $table ." SET helyezes = '". $_POST["helyezes"] ."', szerzett_pontok = '". $_POST["szerzett_pontok"] ."', start_pozicio = '" . $_POST["start_pozicio"] ."' WHERE `nagydij.datum` = '". $key1 . "' and `sofor.id` = '". $key2. "'");
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
        case "csapat": update_record_csapat($conn, $arr[0], $arr[1]); break;
        case "nagydij": update_record_nagydij($conn, $arr[0], $arr[1]); break;
        case "palya": update_record_palya($conn, $arr[0], $arr[1]); break;
        case "resztvesz": update_record_reszt_vesz($conn, $arr[0], $arr[1], $arr[2]); break;
        case "sofor": update_record_sofor($conn, $arr[0], $arr[1]); break;
        case "soforbajnoksag": update_record_soforbajnoksag($conn, $arr[0], $arr[1]); break;
        case "versenyez": update_record_versenyez($conn, $arr[0], $arr[1], $arr[2]); break;
        default: die("Unknown error!");
    }
    close($conn);
}