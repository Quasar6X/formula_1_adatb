<?php
include_once "connection.inc";

function insert_record_csapat(mysqli $conn, string $nev, string $cimek, string $alapitva) : void
{
    $keys_res = mysqli_query($conn, "SELECT nev FROM csapat");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["nev"] === $nev)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $result = mysqli_query($conn, "INSERT INTO csapat (nev, cimek, alapitva) VALUES ('$nev', '$cimek', '$alapitva')");
    check_result($result);
}

function insert_record_nagydij(mysqli $conn, string $datum, string $kork, string $nev, string $palya_nev) : void
{
    $keys_res = mysqli_query($conn, "SELECT datum FROM nagydij");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["datum"] === $datum)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $external_key_res = mysqli_query($conn, "SELECT nev FROM palya");
    $palyak = [];
    while (($row = mysqli_fetch_assoc($external_key_res)) != null)
        $palyak[] = $row["nev"];
    if (!in_array($palya_nev, $palyak))
    {
        mysqli_free_result($external_key_res);
        echo "<script>alert('A megadott pálya nem létezik az adatbázisban!'); window.location.replace('../pages/index.html')</script>";
    }
    mysqli_free_result($external_key_res);
    $result = mysqli_query($conn, "INSERT INTO nagydij (datum, korok, nev, `palya.nev`) VALUES ('$datum', '$kork', '$nev', '$palya_nev')");
    check_result($result);
}

function insert_record_palya(mysqli $conn, string $nev, string $hossz, string $kanyarok, string $orszag) : void
{
    $keys_res = mysqli_query($conn, "SELECT nev FROM palya");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["nev"] === $nev)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $result = mysqli_query($conn, "INSERT INTO palya (nev, hossz, kanyarok, orszag) VALUES ('$nev', '$hossz', '$kanyarok', '$orszag')");
    check_result($result);
}

function insert_record_resztvesz(mysqli $conn, string $sofor_id, string $soforbajnoksag_ev, string $ossz_pont, string $szam) : void
{
    $keys_res = mysqli_query($conn, "SELECT `sofor.id`, `soforbajnoksag.ev` FROM resztvesz");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["sofor.id"] === $sofor_id && $row["soforbajnoksag.ev"] === $soforbajnoksag_ev)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $result = mysqli_query($conn, "INSERT INTO resztvesz (`sofor.id`, `soforbajnoksag.ev`, ossz_pont, szam) VALUES ('$sofor_id', '$soforbajnoksag_ev', '$ossz_pont', '$szam')");
    check_result($result);
}

function insert_record_sofor(mysqli $conn, string $nev, string $cimek, string $csapat_nev) : void
{
    $external_key_res = mysqli_query($conn, "SELECT nev FROM csapat");
    $csapatok = [];
    while (($row = mysqli_fetch_assoc($external_key_res)) != null)
        $csapatok[] = $row["nev"];
    if (!in_array($csapat_nev, $csapatok))
    {
        mysqli_free_result($external_key_res);
        echo "<script>alert('A megadott csapat nem létezik az adatbázisban!'); window.location.replace('../pages/index.html');</script>";
    }
    mysqli_free_result($external_key_res);
    $result = mysqli_query($conn, "INSERT INTO sofor (nev, cimek, `csapat.nev`) VALUES ('$nev', '$cimek', '$csapat_nev')");
    check_result($result);
}

function insert_record_soforbajnoksag(mysqli $conn, string $ev, string $nev) : void
{
    $keys_res = mysqli_query($conn, "SELECT ev FROM soforbajnoksag");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["ev"] === $ev)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $result = mysqli_query($conn, "INSERT INTO soforbajnoksag (ev, nev) VALUES ('$ev', '$nev')");
    check_result($result);
}

function insert_record_versenyez(mysqli $conn, string $nagydij_datum, string $sofor_id, string $helyezes, string $szerzett_pontok, string $start_pozicio) : void
{
    $keys_res = mysqli_query($conn, "SELECT `nagydij.datum`, `sofor.id` FROM versenyez");
    while (($row = mysqli_fetch_assoc($keys_res)) != null)
        if ($row["nagydij.datum"] === $nagydij_datum && $row["sofor.id"] === $sofor_id)
        {
            mysqli_free_result($keys_res);
            error();
        }
    mysqli_free_result($keys_res);
    $result = mysqli_query($conn, "INSERT INTO versenyez (`nagydij.datum`, `sofor.id`, helyezes, szerzett_pontok, start_pozicio) VALUES ('$nagydij_datum', '$sofor_id', '$helyezes', '$szerzett_pontok', '$start_pozicio')");
    check_result($result);
}

function error() : void
{
    echo "<script>alert('Kulcs ütközés!'); window.location.replace('../pages/index.html');</script>";
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>
                alert('SIKERES beszúrás!');
                window.location.replace('../pages/index.html');
              </script>";
    else
        echo "<script>
                alert('SIKERTELEN beszúrás!');
                window.location.replace('../pages/index.html');
              </script>";
}

if (isset($_POST["key"]))
{
    $conn = connect_to_sql();
    if (!mysqli_select_db($conn, "csapat_sport"))
    {
        close($conn);
        die("Database cannot be reached");
    }
    switch ($_POST["key"])
    {
        case "csapat": insert_record_csapat($conn, $_POST["nev"], $_POST["cimek"], $_POST["alapitva"]); break;
        case "nagydij": insert_record_nagydij($conn, $_POST["datum"], $_POST["korok"], $_POST["nev"], $_POST["palya_nev"]); break;
        case "palya": insert_record_palya($conn, $_POST["nev"], $_POST["hossz"], $_POST["kanyarok"], $_POST["orszag"]); break;
        case "resztvesz": insert_record_resztvesz($conn, $_POST["sofor_id"], $_POST["soforbajnoksag_ev"], $_POST["ossz_pont"], $_POST["szam"]); break;
        case "sofor": insert_record_sofor($conn, $_POST["nev"], $_POST["cimek"], $_POST["csapat_nev"]); break;
        case "soforbajnoksag": insert_record_soforbajnoksag($conn, $_POST["ev"], $_POST["nev"]); break;
        case "versenyez": insert_record_versenyez($conn, $_POST["nagydij_datum"], $_POST["sofor_id"], $_POST["helyezes"], $_POST["szerzett_pontok"], $_POST["start_pozicio"]); break;
        default: die("Incorrect add button");
    }
    close($conn);
}