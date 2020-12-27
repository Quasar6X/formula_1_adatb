<?php
include_once "connection.inc";

function delete_from_csapat(mysqli $conn, string $nev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM csapat WHERE nev = ?"))
    {
        $stmt->bind_param("s", $nev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_nagydij(mysqli $conn, string $datum) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM nagydij WHERE datum = ?"))
    {
        $stmt->bind_param("s", $datum);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_palya(mysqli $conn, string $nev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM palya WHERE nev = ?"))
    {
        $stmt->bind_param("s", $nev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_resztvesz(mysqli $conn, string $sofor_id, string $soforbajnoksag_ev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM resztvesz WHERE `sofor.id` = ? AND `soforbajnoksag.ev` = ?"))
    {
        $stmt->bind_param("is", $sofor_id, $soforbajnoksag_ev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_sofor(mysqli $conn, string $id) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM sofor WHERE id = ?"))
    {
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_soforbajnoksag(mysqli $conn, string $ev) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM soforbajnoksag WHERE ev = ?"))
    {
        $stmt->bind_param("s", $ev);
        $result = $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function delete_from_versenyez(mysqli $conn, string $nagydij_datum, string $sofor_id) : void
{
    $result = false;
    if ($stmt = $conn->prepare("DELETE FROM versenyez WHERE `nagydij.datum` = ? AND `sofor.id` = ?"))
    {
        $stmt->bind_param("si", $nagydij_datum, $sofor_id);
        $stmt->execute();
        $stmt->close();
    }
    check_result($result);
}

function check_result(bool $result) : void
{
    if ($result)
        echo "<script>alert('SIKERES törlés!'); window.location.replace('../pages/index.php');</script>";
    else
        echo "<script>alert('SIKERTELEN törlés!'); window.location.replace('../pages/index.php');</script>";
}

if (isset($_POST["key"]))
{
    $conn = connect_to_sql();
    $arr = explode(",", $_POST["key"]);
    match ($arr[0])
    {
        "csapat" => delete_from_csapat($conn, $arr[1]),
        "nagydij" => delete_from_nagydij($conn, $arr[1]),
        "palya" => delete_from_palya($conn, $arr[1]),
        "resztvesz" => delete_from_resztvesz($conn, $arr[1], $arr[2]),
        "sofor" => delete_from_sofor($conn, $arr[1]),
        "soforbajnoksag" => delete_from_soforbajnoksag($conn, $arr[1]),
        "versenyez" => delete_from_versenyez($conn, $arr[1], $arr[2]),
        default => die("Incorrect add button"),
    };
    $conn->close();
}