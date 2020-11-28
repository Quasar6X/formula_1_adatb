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
        Leghosszab futam 2020
    </p>
</div>
<div class="table_parent_div">
    <table>
        <tr><th>Nagydíj napja</th><th>Nagydíj neve</th><th>Pálya</th><th>Hossza (km)</th></tr>
        <?php
        include_once "../scripts/connection.inc";
        $conn = connect_to_sql();
        if (!mysqli_select_db($conn, "csapat_sport"))
        {
            close($conn);
            die("Database cannot be reached");
        }
        $result = mysqli_query($conn, "SELECT datum_final, nev_final, palyanev_final, FORMAT(max_len, 3) FROM (SELECT first.datum as datum_final, first.nev as nev_final, first.palyanev as palyanev_final, MAX(len) as max_len FROM (SELECT nagydij.nev, datum, nagydij.korok * palya.hossz as len, palya.nev as palyanev FROM nagydij, palya, soforbajnoksag WHERE EXTRACT(YEAR FROM datum) = ev AND `palya.nev` = palya.nev GROUP BY len) as first) as second");
        while (($row = $result->fetch_row()) != null)
            echo "<tr><td>". $row[0] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td><td>". $row[3] ."</td></tr>";
        mysqli_free_result($result);
        close($conn);
        ?>
    </table>
</div>
</body>
</html>