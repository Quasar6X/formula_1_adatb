<!DOCTYPE html>
<html lang="hu">
<head>
    <link rel="stylesheet" href="../style/form.css">
    <link rel="stylesheet" href="../style/global.css">
    <meta charset="UTF-8">
    <title>F1 Módosítás</title>
</head>
<body>
    <div class="main">
        <?php
        include_once "../scripts/connection.php";

        function display_csapat_form(array $arr) : void
        {
            echo "<div class='form_title'>Csapat</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
                <label>
                    Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' value='". $arr[1] ."' spellcheck='false'>
                </label>
                <label>
                    Konstrktőri címe(i): <input type='text' name='cimek' required pattern='^[0-9]{1,3}$' value='". $arr[2] ."' spellcheck='false'>
                </label>
                <label>
                    Alapítási éve: <input type='text' name='alapitva' required pattern='^[0-9]{4}$' value='". $arr[3] ."' spellcheck='false'>
                </label>
                <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
              </form>";
        }

        function display_nagydij_form(array $arr, mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT nev FROM palya");
            $circuits = [];
            while (($row = mysqli_fetch_assoc($result)) != null)
                $circuits[] = $row["nev"];
            mysqli_free_result($result);
            echo "<div class='form_title'>Nagydíj</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
                <label>
                    Dátuma: <input type='date' name='datum' required value='". $arr[1] ."'>
                </label>
                <label>
                    Körök száma: <input type='text' name='korok' required pattern='^[0-9]{1,2}$' value='". $arr[2] ."' spellcheck='false'>
                </label>
                <label>
                    Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' value='". $arr[3] ."' spellcheck='false'>
                </label>
                Pálya: <select name='palya_nev' required>";
            foreach ($circuits as $item)
            {
                if ($item === $arr[4])
                    echo "<option selected value='". $item ."'>$item</option>";
                else
                    echo "<option value='". $item ."'>$item</option>";
            }
            echo   "</select>
                <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
              </form>";
        }

        function display_palya_form(array $arr, mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT orszag FROM palya GROUP BY orszag");
            $countries = [];
            while (($row = mysqli_fetch_assoc($result)) != null)
                $countries[] = $row["orszag"];
            mysqli_free_result($result);
            echo "<div class='form_title'>". $arr[1] ."</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
            <label>
                Pálya hossz (km): <input type='text' name='hossz' required pattern='^[0-9]{1,2}(\.[0-9]{1,3})?$' value='". $arr[2] ."' spellcheck='false'>
            </label>
            <label>
                Kanyarok száma: <input type='text' name='kanyarok' required pattern='^[0-9]{1,2}$' value='". $arr[3] ."' spellcheck='false'>
            </label>
            Ország: <select name='orszag' required>";
            foreach ($countries as $item)
            {
                if ($item === $arr[4])
                    echo "<option selected value='". $item ."'>$item</option>";
                else
                    echo "<option value='". $item ."'>$item</option>";
            }
            echo "</select>
            <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
        </form>";
        }

        function display_reszt_vesz_form(array $arr) : void
        {
            echo "<div class='form_title'>". $arr[3]. "<br>Bajnokság éve: ". $arr[2] ."</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
            <label>
                Sofőr pontjai: <input type='text' name='ossz_pont' required pattern='^[0-9]{1,3}$' value='". $arr[4] ."' spellcheck='false'>
            </label>
            <label>
                Sofőr rajtszáma: <input type='text' name='szam' required pattern='^[0-9]{1,2}$' value='". $arr[5] ."' spellcheck='false'>
            </label>
            <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
        </form>";
        }

        function display_sofor_form(array $arr, mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT nev FROM csapat");
            $csapatok = [];
            while (($row = mysqli_fetch_assoc($result)) != null)
                $csapatok[] = $row["nev"];
            mysqli_free_result($result);
            echo "<div class='form_title'>Sofőrazonosító: ". $arr[1] ."</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
            <label>
                Név: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' value='". $arr[2] ."' spellcheck='false'>
            </label>
            <label>
                Bajnoki címek: <input type='text' name='cimek' required pattern='^[0-9]{1,2}$' value='". $arr[3] ."' spellcheck='false'>
            </label>
            Csapat: <select name='csapat_nev' required>";
            foreach ($csapatok as $item)
            {
                if ($item === $arr[4])
                    echo "<option selected value='". $item ."'>$item</option>";
                else
                    echo "<option value='". $item ."'>$item</option>";
            }
            echo"</select>
            <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
        </form>";
        }

        function display_soforbajnoksag_form(array $arr) : void
        {
            echo "<div class='form_title'>Bajnokság éve: ". $arr[1]. "</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
            <label>
                Név: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' value='". $arr[2] ."' spellcheck='false'>
            </label>
            <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
        </form>";
        }

        function display_versenyez_form(array $arr) : void
        {
            echo "<div class='form_title'>Sofőr: ". $arr[6] ."<br>Nagydíj: ". $arr[7] ."<br>Dátum: ". $arr[1] . "</div><form action='../scripts/modify.php' method='post' onsubmit='return confirm(`Biztos módosítani kívánja az értékeket?`)'>
            Helyezés: <select name='helyezes' required>";
            for ($i = 1; $i <= 20; ++$i)
            {
                if ($i === $arr[3])
                    echo "<option selected value='". $i ."'>$i.</option>";
                else
                    echo "<option value='". $i ."'>$i.</option>";
            }
            echo "</select>
            <label>
                Szerzett pont(ok): <input type='text' name='szerzett_pontok' required pattern='^[0-9]{1,2}$' value='". $arr[4] ."' spellcheck='false'>
            </label>
            Grid pozíció: <select name='start_pozicio' required>";
            for ($i = 1; $i <= 20; ++$i)
            {
                if ($i === $arr[5])
                    echo "<option selected value='". $i ."'>$i.</option>";
                else
                    echo "<option value='". $i ."'>$i.</option>";
            }
            echo "</select>
            <div class='form_page_submit_btn'><button type='submit' value='" . $_POST["key"] ."' name='key'>Módosítás</button></div>
        </form>";
        }

        if (isset($_POST["key"]))
        {
            $arr = explode(",", $_POST["key"]);
            $conn = connect_to_sql();
            if (!mysqli_select_db($conn, "csapat_sport"))
            {
                close($conn);
                die("Database cannot be reached");
            }
            switch ($arr[0])
            {
                case "csapat": display_csapat_form($arr); break;
                case "nagydij": display_nagydij_form($arr, $conn); break;
                case "palya": display_palya_form($arr, $conn); break;
                case "resztvesz": display_reszt_vesz_form($arr); break;
                case "sofor": display_sofor_form($arr, $conn); break;
                case "soforbajnoksag": display_soforbajnoksag_form($arr); break;
                case "versenyez": display_versenyez_form($arr); break;
                default: die("Incorrect modify button");
            }
            close($conn);
        }
        ?>
    </div>
</body>
</html>
