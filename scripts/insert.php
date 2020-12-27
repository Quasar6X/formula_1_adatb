<?php
include_once "connection.inc";

function insert_record_csapat(mysqli $conn, string $nev, string $cimek, string $alapitva) : void
{
    $keys_res = $conn->query("SELECT nev FROM csapat");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["nev"] === $nev) {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $result = false;
    if (empty($cimek))
    {
        if (empty($alapitva))
        {
            if ($stmt = $conn->prepare("INSERT INTO csapat (nev, alapitva) VALUES (?, NULL)"))
            {
                $stmt->bind_param("s", $nev);
                $result = $stmt->execute();
                $stmt->close();
            }
        }
        else
        {
            if ($stmt = $conn->prepare("INSERT INTO csapat (nev, alapitva) VALUES (?, ?)"))
            {
                $stmt->bind_param("si", $nev, $alapitva);
                $result = $stmt->execute();
                $stmt->close();
            }
        }
    }
    else
    {
        if (empty($alapitva))
        {
            if ($stmt = $conn->prepare("INSERT INTO csapat (nev, cimek, alapitva) VALUES (?, ?, NULL)"))
            {
                $stmt->bind_param("si", $nev, $cimek);
                $result = $stmt->execute();
                $stmt->close();
            }
        }
        else
        {
            if ($stmt = $conn->prepare("INSERT INTO csapat (nev, cimek, alapitva) VALUES (?, ?, ?)"))
            {
                $stmt->bind_param("sii", $nev, $cimek, $alapitva);
                $result = $stmt->execute();
                $stmt->close();
            }
        }

    }
    check_result($result);
}

function insert_record_nagydij(mysqli $conn, string $datum, string $korok, string $nev, string $palya_nev) : void
{
    $keys_res = $conn->query("SELECT datum FROM nagydij");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["datum"] === $datum)
        {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $external_key_res = $conn->query("SELECT nev FROM palya");
    $palyak = [];
    while (($row = $external_key_res->fetch_assoc()) != null)
        $palyak[] = $row["nev"];
    if (!in_array($palya_nev, $palyak))
    {
        $external_key_res->free();
        echo "<script>alert('A megadott pálya nem létezik az adatbázisban!'); window.location.replace('../pages/index.php')</script>";
    }
    $external_key_res->free();
    $result = false;
    if ($stmt = $conn->prepare("INSERT INTO nagydij (datum, korok, nev, `palya.nev`) VALUES (?, ?, ?, ?)"))
    {
        $stmt->bind_param("siss", $datum, $korok, $nev, $palya_nev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function insert_record_palya(mysqli $conn, string $nev, string $hossz, string $kanyarok, string $orszag) : void
{
    $keys_res = $conn->query("SELECT nev FROM palya");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["nev"] === $nev)
        {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $result = false;
    if ($stmt = $conn->prepare("INSERT INTO palya (nev, hossz, kanyarok, orszag) VALUES (?, ?, ?, ?)"))
    {
        $stmt->bind_param("sdis", $nev, $hossz, $kanyarok, $orszag);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function insert_record_resztvesz(mysqli $conn, string $sofor_id, string $soforbajnoksag_ev, string $ossz_pont, string $szam) : void
{
    $keys_res = $conn->query("SELECT `sofor.id`, `soforbajnoksag.ev` FROM resztvesz");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["sofor.id"] === $sofor_id && $row["soforbajnoksag.ev"] === $soforbajnoksag_ev)
        {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $result = false;
    if (empty($ossz_pont))
        if ($stmt = $conn->prepare("INSERT INTO resztvesz (`sofor.id`, `soforbajnoksag.ev`, szam) VALUES (?, ?, ?)"))
        {
            $stmt->bind_param("isi", $sofor_id, $soforbajnoksag_ev, $szam);
            $result = $stmt->execute();
            $stmt->close();
        }
    else
        if ($stmt = $conn->prepare("INSERT INTO resztvesz (`sofor.id`, `soforbajnoksag.ev`, ossz_pont, szam) VALUES (?, ?, ?, ?)"))
        {
            $stmt->bind_param("isii", $sofor_id, $soforbajnoksag_ev, $ossz_pont, $szam);
            $result = $stmt->execute();
            $stmt->close();
        }
    check_result($result);
}

function insert_record_sofor(mysqli $conn, string $nev, string $cimek, string $csapat_nev) : void
{
    $external_key_res = $conn->query("SELECT nev FROM csapat");
    $csapatok = [];
    while (($row = $external_key_res->fetch_assoc()) != null)
        $csapatok[] = $row["nev"];
    if (!in_array($csapat_nev, $csapatok))
    {
        $external_key_res->free();
        echo "<script>alert('A megadott csapat nem létezik az adatbázisban!'); window.location.replace('../pages/index.php');</script>";
    }
    $external_key_res->free();
    $result = false;
    if (empty($cimek))
    {
        if ($stmt = $conn->prepare("INSERT INTO sofor (nev, `csapat.nev`) VALUES (?, ?)"))
        {
            $stmt->bind_param("ss", $nev, $csapat_nev);
            $result = $stmt->execute();
            $stmt->close();
        }
    }
    else
    {
        if ($stmt = $conn->prepare("INSERT INTO sofor (nev, cimek, `csapat.nev`) VALUES (?, ?, ?)"))
        {
            $stmt->bind_param("sis", $nev, $cimek, $csapat_nev);
            $result = $stmt->execute();
            $stmt->close();
        }
    }
    check_result($result);
}

function insert_record_soforbajnoksag(mysqli $conn, string $ev, string $nev) : void
{
    $keys_res = $conn->query("SELECT ev FROM soforbajnoksag");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["ev"] === $ev)
        {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $result = false;
    if ($stmt = $conn->prepare("INSERT INTO soforbajnoksag (ev, nev) VALUES (?, ?)"))
    {
        $stmt->bind_param("ss", $ev, $nev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function insert_record_versenyez(mysqli $conn, string $nagydij_datum, string $sofor_id, string $helyezes, string $szerzett_pontok, string $start_pozicio) : void
{
    $keys_res = $conn->query("SELECT `nagydij.datum`, `sofor.id` FROM versenyez");
    while (($row = $keys_res->fetch_assoc()) != null)
        if ($row["nagydij.datum"] === $nagydij_datum && $row["sofor.id"] === $sofor_id)
        {
            $keys_res->free();
            error();
        }
    $keys_res->free();
    $result = false;
    if ($stmt = $conn->prepare("INSERT INTO versenyez (`nagydij.datum`, `sofor.id`, helyezes, szerzett_pontok, start_pozicio) VALUES (?, ?, ?, ?, ?)"))
    {
        $stmt->bind_param("siiii", $nagydij_datum, $sofor_id, $helyezes, $szerzett_pontok, $start_pozicio);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function error() : void
{
    echo "<script>alert('Kulcs ütközés!'); window.location.replace('../pages/index.php');</script>";
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>alert('SIKERES beszúrás!'); window.location.replace('../pages/index.php');</script>";
    else
        echo "<script>alert('SIKERTELEN beszúrás!'); window.location.replace('../pages/index.php');</script>";
}

if (isset($_POST["key"]))
{
    $conn = connect_to_sql();
    match ($_POST["key"])
    {
        "csapat" => insert_record_csapat($conn, $_POST["nev"], $_POST["cimek"], $_POST["alapitva"]),
        "nagydij" => insert_record_nagydij($conn, $_POST["datum"], $_POST["korok"], $_POST["nev"], $_POST["palya_nev"]),
        "palya" => insert_record_palya($conn, $_POST["nev"], $_POST["hossz"], $_POST["kanyarok"], $_POST["orszag"]),
        "resztvesz" => insert_record_resztvesz($conn, $_POST["sofor_id"], $_POST["soforbajnoksag_ev"], $_POST["ossz_pont"], $_POST["szam"]),
        "sofor" => insert_record_sofor($conn, $_POST["nev"], $_POST["cimek"], $_POST["csapat_nev"]),
        "soforbajnoksag" => insert_record_soforbajnoksag($conn, $_POST["ev"], $_POST["nev"]),
        "versenyez" => insert_record_versenyez($conn, $_POST["nagydij_datum"], $_POST["sofor_id"], $_POST["helyezes"], $_POST["szerzett_pontok"], $_POST["start_pozicio"]),
        default => die("Incorrect add button"),
    };
    $conn->close();
}