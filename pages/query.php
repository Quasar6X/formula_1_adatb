<!DOCTYPE html>
<html lang="hu">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="stylesheet" href="../style/tables.css">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/head.css">
    <meta charset="UTF-8">
    <title>F1 Táblák</title>
</head>
<body>
    <?php
    include "head.html";
    ?>
    <div class="table_title">
        <p>
        <?php
        if (isset($_POST["table"]))
            switch ($_POST["table"])
            {
                case "csapat": echo "Csapatok"; break;
                case "nagydij": echo "Nagydíjak"; break;
                case "palya": echo "Pályák"; break;
                case "resztvesz": echo "Sofőr rangsor"; break;
                case "sofor": echo "Sofőrök"; break;
                case "soforbajnoksag": echo "Sofőrbajnokságok"; break;
                case "versenyez": echo "Verseny eredmények"; break;
                default: die("Incorrect radio button!");
            }
        ?>
        </p>
    </div>
    <div class="table_parent_div">
        <?php
        include_once "../scripts/connection.inc";

        function display_csapat(mysqli $conn) : void
        {
            $custom_result = $conn->query("SELECT * FROM csapat ORDER BY cimek DESC");
            echo "<table><tr><th>Név</th><th>Címek</th><th>Alapítva</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $custom_result->fetch_assoc()) != null)
                echo "<tr><td>". $row["nev"] ."</td><td>". $row["cimek"] ."</td><td>". $row["alapitva"] . "</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='" . "csapat,". $row["nev"] .",". $row["cimek"] .",". $row["alapitva"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "csapat," . $row["nev"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='csapat' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='csapat' class='icon_btn' id='add'></button></form>";
            $custom_result->free();
        }

        function display_nagydij(mysqli_result $result) : void
        {
            echo "<table><tr><th>Dátum</th><th>Nagydíj neve</th><th>Körök száma</th><th>Pálya</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $result->fetch_assoc()) != null)
                echo "<tr><td>". $row["datum"] ."</td><td>". $row["nev"] ."</td><td>". $row["korok"] ."</td><td>". $row["palya.nev"] . "</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='". "nagydij,". $row["datum"] .",". $row["korok"] .",". $row["nev"] .",". $row["palya.nev"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "nagydij," . $row["datum"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='nagydij' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='nagydij' class='icon_btn' id='add'></button></form>";
        }

        function display_palya(mysqli_result $result) : void
        {
            echo "<table><tr><th>Név</th><th>Pálya hossza (km)</th><th>Kanyarok száma</th><th>Ország</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $result->fetch_assoc()) != null)
                echo "<tr><td>". $row["nev"] ."</td><td>". $row["hossz"] ."</td><td>". $row["kanyarok"] ."</td><td>". $row["orszag"] . "</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='". "palya,". $row["nev"] .",". $row["hossz"] .",". $row["kanyarok"] .",". $row["orszag"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "palya," . $row["nev"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='palya' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='palya' class='icon_btn' id='add'></button></form>";
        }

        function display_reszt_vesz(mysqli $conn) : void
        {
            $custom_result = $conn->query("SELECT `soforbajnoksag.ev`, `sofor.id`, ossz_pont, szam, nev FROM resztvesz, sofor WHERE `sofor.id` = id ORDER BY ossz_pont DESC");
            echo "<table><tr><th>Sofőr Azonosító</th><th>Sofőr</th><th>Bajnokság éve</th><th>Sofőr pontjai</th><th>Sofőr rajtszáma</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $custom_result->fetch_assoc()) != null)
                echo "<tr><td>". $row["sofor.id"] ."</td><td>". $row["nev"] ."</td><td>". $row["soforbajnoksag.ev"] ."</td><td>". $row["ossz_pont"] ."</td><td>". $row["szam"] . "</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='"."resztvesz,". $row["sofor.id"] .",". $row["soforbajnoksag.ev"] .",". $row["nev"] .",". $row["ossz_pont"] .",". $row["szam"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "resztvesz," . $row["sofor.id"] .",". $row["soforbajnoksag.ev"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='resztvesz' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='resztvesz' class='icon_btn' id='add'></button></form>";
            $custom_result->free();
        }

        function display_sofor(mysqli_result $result) : void
        {
            echo "<table><tr><th>Sofőr azonosító</th><th>Név</th><th>Bajnoki cím(ek)</th><th>Csapat</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $result->fetch_assoc()) != null)
                echo "<tr><td>". $row["id"] ."</td><td>". $row["nev"] ."</td><td>". $row["cimek"] ."</td><td>". $row["csapat.nev"] . "</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='". "sofor,". $row["id"] .",". $row["nev"] .",". $row["cimek"] .",". $row["csapat.nev"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "sofor," . $row["id"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='sofor' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='sofor' class='icon_btn' id='add'></button></form>";
        }

        function display_soforbajnoksag(mysqli_result $result) : void
        {
            echo "<table><tr><th>Bajnokság éve</th><th>Bajnokság neve</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $result->fetch_assoc()) != null)
                echo "<tr><td>". $row["ev"] ."</td><td>". $row["nev"] ."</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='". "soforbajnoksag,". $row["ev"] .",". $row["nev"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "soforbajnoksag," . $row["ev"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='soforbajnoksag' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='soforbajnoksag' class='icon_btn' id='add'></button></form>";
        }

        function display_versenyez(mysqli $conn): void
        {
            $custom_result = $conn->query("SELECT `nagydij.datum`, helyezes, szerzett_pontok, start_pozicio, `sofor.id`, sofor.nev AS sofornev, nagydij.nev FROM versenyez, sofor, nagydij WHERE `sofor.id` = id and `nagydij.datum` = datum ORDER BY `nagydij.datum`, helyezes");
            echo "<table><tr><th>Sofőr Azonosító</th><th>Sofőr</th><th>Helyezés</th><th>Szerzett pont(ok)</th><th>Pozíció griden</th><th>Nagydíj</th><th>Nagydíj dátuma</th><th>Módosítás</th><th>Törlés</th></tr>";
            while (($row = $custom_result->fetch_assoc()) != null)
                echo "<tr><td>". $row["sofor.id"] ."</td><td>". $row["sofornev"] ."</td><td>". $row["helyezes"] .".</td><td>". $row["szerzett_pontok"] ."</td><td>". $row["start_pozicio"] .".</td><td>". $row["nev"] ."</td><td>". $row["nagydij.datum"] ."</td><td><form method='post' action='modify_form.php'><button type='submit' class='modify_btn' name='key' value='". "versenyez,". $row["nagydij.datum"] .",". $row["sofor.id"] .",". $row["helyezes"] .",". $row["szerzett_pontok"] .",". $row["start_pozicio"] .",". $row["sofornev"] .",". $row["nev"] ."'></button></form></td><td><form method='post' action='../scripts/delete.php' onsubmit='return confirm(`Biztosan törli?`)'><button type='submit' class='delete_btn' name='key' value='". "versenyez," . $row["nagydij.datum"] .",". $row["sofor.id"] ."'></button></form></td></tr>";
            echo "</table><form method='post' action='query.php'><button title='Frissít' type='submit' name='table' value='versenyez' class='icon_btn' id='refresh'></button></form><div><button title='Vissza a főoldalra' type='button' class='icon_btn' id='back' onclick='window.location.href = `index.php`'></button></div><form method='post' action='insert_form.php'><button title='Új rekord' type='submit' name='add' value='versenyez' class='icon_btn' id='add'></button></form>";
            $custom_result->free();
        }

        if (isset($_POST["table"]))
        {
            $conn = connect_to_sql();
            $result = $conn->query("SELECT * FROM ". $_POST["table"]);
            match ($_POST["table"])
            {
                "csapat" => display_csapat($conn),
                "nagydij" => display_nagydij($result),
                "palya" => display_palya($result),
                "resztvesz" => display_reszt_vesz($conn),
                "sofor" => display_sofor($result),
                "soforbajnoksag" => display_soforbajnoksag($result),
                "versenyez" => display_versenyez($conn),
                default => die("Incorrect radio button!"),
            };
            $result->free();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>