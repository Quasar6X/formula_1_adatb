<?php

use JetBrains\PhpStorm\Pure;

include_once "connection.inc";

$run = function ()
{
    $conn = connect_to_sql();
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
            $result = $conn->query("SELECT * FROM $temp[0]");
            if ($result->num_rows > 0)
            {
                $f = fopen($filename, "w");
                fputcsv($f, $attributes);
                while (($row = $result->fetch_assoc()) != null)
                {
                    match ($temp[0])
                    {
                        "csapat" => fputcsv($f, array(convert($row["nev"]), convert($row["cimek"]), convert($row["alapitva"]))),
                        "nagydij" => fputcsv($f, array(convert($row["datum"]), convert($row["korok"]), convert($row["nev"]), convert($row["palya.nev"]))),
                        "palya" => fputcsv($f, array(convert($row["nev"]), convert($row["hossz"]), convert($row["kanyarok"]), convert($row["orszag"]))),
                        "resztvesz" => fputcsv($f, array(convert($row["sofor.id"]), convert($row["soforbajnoksag.ev"]), convert($row["ossz_pont"]), convert($row["szam"]))),
                        "sofor" => fputcsv($f, array(convert($row["id"]), convert($row["nev"]), convert($row["cimek"]), convert($row["csapat.nev"]))),
                        "soforbajnoksag" => fputcsv($f, array(convert($row["ev"]), convert($row["nev"]))),
                        "versenyez" => fputcsv($f, array(convert($row["nagydij.datum"]), convert($row["sofor.id"]), convert($row["helyezes"]), convert($row["szerzett_pontok"]), convert($row["start_pozicio"]))),
                    };
                }
                fclose($f);
            }
            $zip->addFile($filename);
        }
    }
    $zip->close();
    $conn->close();
    header("Content-disposition: attachment; filename=$zip_name");
    header("Content-type: application/zip");
    header("Content-length: ". filesize($zip_name));
    readfile($zip_name);
    foreach ($filenames as $filename => $attr)
        unlink($filename);
    unlink($zip_name);
};

#[Pure] function convert($string) : string
{
    return mb_convert_encoding($string, "UTF-8");
}

$run();