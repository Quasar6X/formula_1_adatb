<!DOCTYPE html>
<html lang="hu">
<head>
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/form.css">
    <meta charset="UTF-8">
    <title>F1 Beszúrás</title>
</head>
<body>
    <div class="main">
        <?php
        include_once "../scripts/connection.php";

        function display_csapat_insert_form() : void
        {
            echo "<div class='form_title'>Csapat</div><form action='../scripts/insert.php' method='post'>
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Konstruktőri címe(i): <input type='text' name='cimek' required pattern='^[0-9]{1,3}$' spellcheck='false'>
                    </label>
                    <label>
                        Alapítási éve: <input type='text' name='alapitva' required pattern='^[0-9]{4}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='csapat'>Beszúrás</button></div>
                </form>";
        }

        function display_nagydij_insert_form(mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT nev FROM palya");
            $palyak = [];
            while (($row = mysqli_fetch_assoc($result)))
                $palyak[] = $row["nev"];
            mysqli_free_result($result);
            echo "<div class='form_title'>Nagydíj</div><form action='../scripts/insert.php' method='post'>
                    <label>
                        Dátum: <input type='date' name='datum' required>
                    </label>
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Körök száma: <input type='text' name='korok' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    Pálya: <select name='palya_nev' required>";
                        foreach ($palyak as $item)
                            echo "<option value='$item'>$item</option>";
            echo   "</select>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='nagydij'>Beszúrás</button></div>
                </form>";
        }

        function display_palya_insert_form() : void
        {
            echo "<div class='form_title'>Pálya</div><form action='../scripts/insert.php' method='post'>
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Hossza: <input type='text' name='hossz' required pattern='^[0-9]{1,2}(\.[0-9]{1,3})?$' spellcheck='false'>
                    </label>
                    <label>
                        Kanyarok: <input type='text' name='kanyarok' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    <label>
                        Ország: <input type='text' name='orszag' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='palya'>Beszúrás</button></div>
                </form>";
        }

        function display_resztvesz_insert_form(mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT ev FROM soforbajnoksag");
            $result2 = mysqli_query($conn, "SELECT nev, id FROM sofor");
            $evek = [];
            $soforok = [];
            while (($row = mysqli_fetch_assoc($result)))
                $evek[] = $row["ev"];
            mysqli_free_result($result);
            while (($row = mysqli_fetch_assoc($result2)))
                $soforok[] = $row["nev"]. "," .$row["id"];
            mysqli_free_result($result2);
            echo "<div class='form_title'>Részt vesz</div><form action='../scripts/insert.php' method='post'>
                    Sofőr: <select name='sofor_id' required>";
                        foreach ($soforok as $item)
                        {
                            $temp = explode(",", $item);
                            echo "<option value='$temp[1]'>$temp[0]</option>";
                        }
            echo   "</select>
                    Bajnokság: <select name='soforbajnoksag_ev' required>";
                        foreach ($evek as $item)
                            echo "<option value='$item'>$item</option>";
            echo   "</select>
                    <label>
                       Sofőr pontjai: <input type='text' name='ossz_pont' required pattern='^[0-9]{1,3}$' spellcheck='false'>
                    </label>
                    <label>
                       Sofőr rajtszáma: <input type='text' name='szam' required pattern='^[0-9]{2}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='resztvesz'>Beszúrás</button></div>
                </form>";
        }

        function display_sofor_insert_form(mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT nev FROM csapat");
            $csapatok = [];
            while (($row = mysqli_fetch_assoc($result)) != null)
                $csapatok[] = $row["nev"];
            mysqli_free_result($result);
            echo "<div class='form_title'>Sofőr</div><form action='../scripts/insert.php' method='post'>                  
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Cimek: <input type='text' name='cimek' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    Csapat: <select name='csapat_nev' required>";
            foreach ($csapatok as $item)
                echo "<option value='$item'>$item</option>";
            echo   "</select>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='sofor'>Beszúrás</button></div>
                </form>";
        }

        function display_soforbajnoksag_insert_form() : void
        {
            echo "<div class='form_title'>Bajnokság</div><form action='../scripts/insert.php' method='post'>
                    <label>
                        Év: <input type='text' name='ev' required pattern='^[0-9]{4}$' spellcheck='false'>
                    </label>
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>                
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='soforbajnoksag'>Beszúrás</button></div>
                </form>";
        }

        function display_versenyez_insert_form(mysqli $conn) : void
        {
            $result = mysqli_query($conn, "SELECT datum FROM nagydij ORDER BY datum DESC");
            $result2 = mysqli_query($conn, "SELECT nev, id FROM sofor");
            $datumok = [];
            $soforok = [];
            while (($row = mysqli_fetch_assoc($result)))
                $datumok[] = $row["datum"];
            mysqli_free_result($result);
            while (($row = mysqli_fetch_assoc($result2)))
                $soforok[] = $row["nev"]. "," .$row["id"];
            mysqli_free_result($result2);
            echo "<div class='form_title'>Versenyez</div><form action='../scripts/insert.php' method='post'>
                    Nagydíj dátuma: <select name='nagydij_datum' required>";
                        foreach ($datumok as $item)
                            echo "<option value='$item'>$item</option>";
            echo   "</select>
                    Sofőr: <select name='sofor_id' required>";
                        foreach ($soforok as $item)
                        {
                            $temp = explode(",", $item);
                            echo "<option value='$temp[1]'>$temp[0]</option>";
                        }
            echo   "</select>
                    <label>
                       Helyezés: <input type='text' name='helyezes' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    <label>
                       Szerzett pont(ok): <input type='text' name='szerzett_pontok' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    <label>
                       Pozíció griden: <input type='text' name='start_pozicio' required pattern='^[0-9]{1,2}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='versenyez'>Beszúrás</button></div>
                </form>";
        }

        if (isset($_POST["add"]))
        {
            $conn = connect_to_sql();
            if (!mysqli_select_db($conn, "csapat_sport"))
            {
                close($conn);
                die("Database cannot be reached");
            }
            switch ($_POST["add"])
            {
                case "csapat": display_csapat_insert_form(); break;
                case "nagydij": display_nagydij_insert_form($conn); break;
                case "palya": display_palya_insert_form(); break;
                case "resztvesz": display_resztvesz_insert_form($conn); break;
                case "sofor": display_sofor_insert_form($conn); break;
                case "soforbajnoksag": display_soforbajnoksag_insert_form(); break;
                case "versenyez": display_versenyez_insert_form($conn); break;
                default: die("Incorrect add button");
            }
            close($conn);
        }
        ?>
    </div>
</body>
</html>