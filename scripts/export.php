<?php
include_once "connection.inc";

$run = function ()
{
    $conn = connect_to_sql();
    if (!mysqli_select_db($conn, "csapat_sport"))
    {
        close($conn);
        die("Database cannot be reached");
    }
    $filenames = ["csapat.csv" => ["nev", "cimek", "alapitva"],
                "nagydij.csv" => ["datum", "korok", "nev", "palya.nev"],
                "palya.csv" => ["nev", "hossz", "kanyarok", "orszag"],
                "resztvesz.csv" => ["sofor.id", "soforbajnoksag.ev", "ossz_pont", "szam"],
                "sofor.csv" => ["id", "nev", "cimek", "csapat.nev"],
                "soforbajnoksag.csv" => ["ev", "nev"],
                "versenyez.csv" => ["nagydij.datum", "sofor.id", "helyezes", "szerzett_pontok", "start_pozicio"]];
    $zip = new ZipArchive();
    $zip_name = "exports.zip";
    if ($zip->open($zip_name, ZipArchive::CREATE))
    {
        foreach ($filenames as $filename => $attributes)
        {
            $temp = explode(".", $filename);
            $result = mysqli_query($conn, "SELECT * FROM $temp[0]");
            if ($result->num_rows > 0)
            {
                $f = fopen($filename, "w");
                fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($f, $attributes);
                while (($row = mysqli_fetch_assoc($result)) != null)
                {
                    switch ($temp[0])
                    {
                        case "csapat": fputcsv($f, array($row["nev"], $row["cimek"], $row["alapitva"])); break;
                        case "nagydij": fputcsv($f, array($row["datum"], $row["korok"], $row["nev"], $row["palya.nev"])); break;
                        case "palya": fputcsv($f, array($row["nev"], $row["hossz"], $row["kanyarok"], $row["orszag"])); break;
                        case "resztvesz": fputcsv($f, array($row["sofor.id"], $row["soforbajnoksag.ev"], $row["ossz_pont"], $row["szam"])); break;
                        case "sofor": fputcsv($f, array($row["id"], $row["nev"], $row["cimek"], $row["csapat.nev"])); break;
                        case "soforbajnoksag": fputcsv($f, array($row["ev"], $row["nev"])); break;
                        case "versenyez": fputcsv($f, array($row["nagydij.datum"], $row["sofor.id"], $row["helyezes"], $row["szerzett_pontok"], $row["start_pozicio"])); break;
                    }
                }
                fclose($f);
            }
            $zip->addFile($filename);
        }
    }
    $zip->close();
    close($conn);
    header("Content-disposition: attachment; filename=$zip_name");
    header("Content-type: application/zip");
    header("Content-length: ". filesize($zip_name));
    readfile($zip_name);
    foreach ($filenames as $filename => $attr)
        unlink($filename);
    unlink($zip_name);
};
$run();