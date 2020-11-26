<?php
include_once "connection.inc";

function delete_from_csapat(mysqli $conn, string $nev) : void
{
    $result = mysqli_query($conn, "DELETE FROM csapat WHERE nev = '$nev'");
    check_result($result);
}

function delete_from_nagydij(mysqli $conn, string $datum) : void
{
    $result = mysqli_query($conn, "DELETE FROM nagydij WHERE datum = '$datum'");
    check_result($result);
}

function delete_from_palya(mysqli $conn, string $nev) : void
{
    $result = mysqli_query($conn, "DELETE FROM palya WHERE nev = '$nev'");
    check_result($result);
}

function delete_from_resztvesz(mysqli $conn, string $sofor_id, string $soforbajnoksag_ev) : void
{
    $result = mysqli_query($conn, "DELETE FROM resztvesz WHERE `sofor.id` = '$sofor_id' AND `soforbajnoksag.ev` = '$soforbajnoksag_ev'");
    check_result($result);
}

function delete_from_sofor(mysqli $conn, string $id) : void
{
    $result = mysqli_query($conn, "DELETE FROM sofor WHERE id = '$id'");
    check_result($result);
}

function delete_from_soforbajnoksag(mysqli $conn, string $ev) : void
{
    $result = mysqli_query($conn, "DELETE FROM soforbajnoksag WHERE ev = '$ev'");
    check_result($result);
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>
                alert('SIKERES törlés!');
                window.location.replace('../pages/index.html');
              </script>";
    else
        echo "<script>
                alert('SIKERTELEN törlés!');
                window.location.replace('../pages/index.html');
              </script>";
}

function delete_from_versenyez(mysqli $conn, string $nagydij_datum, string $sofor_id) : void
{
    $result = mysqli_query($conn, "DELETE FROM versenyez WHERE `nagydij.datum` = '$nagydij_datum' AND `sofor.id` = '$sofor_id'");
    check_result($result);
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
        case "csapat": delete_from_csapat($conn, $arr[1]); break;
        case "nagydij": delete_from_nagydij($conn, $arr[1]); break;
        case "palya": delete_from_palya($conn, $arr[1]); break;
        case "resztvesz": delete_from_resztvesz($conn, $arr[1], $arr[2]); break;
        case "sofor": delete_from_sofor($conn, $arr[1]); break;
        case "soforbajnoksag": delete_from_soforbajnoksag($conn, $arr[1]); break;
        case "versenyez": delete_from_versenyez($conn, $arr[1], $arr[2]); break;
        default: die("Incorrect add button");
    }
    close($conn);
}