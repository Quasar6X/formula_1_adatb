<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/head.css">
    <link rel="stylesheet" href="../style/tables.css">
    <meta charset="UTF-8">
    <title>F1 Leghosszabb Futam 2020</title>
</head>
<body>
<?php
include "head.html";
?>
<div class="table_title">
    <p>
        Leghosszab futam
    </p>
</div>
<div class="table_parent_div">
    <table>
        <tr><th>Nagydíj napja</th><th>Nagydíj neve</th><th>Pálya</th><th>Hossza (km)</th></tr>
        <?php
        include_once "../scripts/connection.inc";
        $conn = connect_to_sql();
        $result = $conn->query("SELECT datum_final, nev_final, palyanev_final, FORMAT(max_len, 3) FROM (SELECT first.datum as datum_final, first.nev as nev_final, first.palyanev as palyanev_final, MAX(len) as max_len FROM (SELECT nagydij.nev, datum, nagydij.korok * palya.hossz as len, palya.nev as palyanev FROM nagydij, palya, soforbajnoksag WHERE EXTRACT(YEAR FROM datum) = ev AND `palya.nev` = palya.nev GROUP BY len) as first) as second");
        $arr = $result->fetch_row();
        echo "<tr><td>". $arr[0] ."</td><td>". $arr[1] ."</td><td>". $arr[2] ."</td><td>". $arr[3] ."</td></tr>";
        $result->free();
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>