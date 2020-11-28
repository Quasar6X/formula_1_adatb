<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/head.css">
    <link rel="stylesheet" href="../style/tables.css">
    <meta charset="UTF-8">
    <title>F1 Helyszínek 2020</title>
</head>
<body>
<?php
include "head.html";
?>
<div class="table_title">
    <p>
        Pályák a 2020-as szezonban
    </p>
</div>
<div class="table_parent_div">
    <table>
        <tr><th>Nagydíj napja</th><th>Nagydíj neve</th><th>Pálya</th></tr>
        <?php
        include_once "../scripts/connection.inc";
        $conn = connect_to_sql();
        if (!mysqli_select_db($conn, "csapat_sport"))
        {
            close($conn);
            die("Database cannot be reached");
        }
        $result = mysqli_query($conn, "SELECT datum, nagydij.nev, palya.nev FROM palya, nagydij, soforbajnoksag WHERE EXTRACT(YEAR FROM datum) = ev AND `palya.nev` = palya.nev GROUP BY palya.nev, datum ORDER BY datum");
        while (($row = $result->fetch_row()) != null)
            echo "<tr><td>". $row[0] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td></tr>";
        mysqli_free_result($result);
        close($conn);
        ?>
    </table>
</div>
</body>
</html>