<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/head.css">
    <link rel="stylesheet" href="../style/tables.css">
    <meta charset="UTF-8">
    <title>F1 Legtöbb győzelem 2020</title>
</head>
<body>
    <?php
    include "head.html";
    ?>
    <div class="table_title">
        <p>
            Legtöbb futamgyőzelmet elért sofőr 2020
        </p>
    </div>
    <div class="table_parent_div">
        <table>
            <tr><th>Sofőr neve</th><th>Győzelmek száma</th></tr>
            <?php
            include_once "../scripts/connection.inc";
            $conn = connect_to_sql();
            if (!mysqli_select_db($conn, "csapat_sport"))
            {
                close($conn);
                die("Database cannot be reached");
            }
            $result = mysqli_query($conn, "SELECT first.nev ,MAX(victories) FROM (SELECT sofor.nev, COUNT(helyezes) victories FROM versenyez, sofor, resztvesz, soforbajnoksag WHERE ev = `soforbajnoksag.ev` AND helyezes = 1 AND id = versenyez.`sofor.id` AND id = resztvesz.`sofor.id` GROUP BY versenyez.`sofor.id`, ev) as first;");
            $arr = $result->fetch_row();
            echo "<tr><td>". $arr[0] ."</td><td>". $arr[1] ." Győzelem</td></tr>";
            mysqli_free_result($result);
            close($conn);
            ?>
        </table>
    </div>
</body>
</html>