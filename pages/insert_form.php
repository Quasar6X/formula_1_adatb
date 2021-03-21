<!DOCTYPE html>
<html lang="hu">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/form.css">
    <link rel="stylesheet" href="../style/head.css">
    <meta charset="UTF-8">
    <title>F1 Beszúrás</title>
</head>
<body>
    <?php
    include "head.html";
    ?>
    <div class="main">
        <?php
        include_once "../scripts/connection.inc";

        function display_csapat_insert_form() : void
        {
            echo "<div class='form_title'>Csapat</div><form action='../scripts/insert.php' method='post'>
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Konstruktőri címe(i): <input type='text' name='cimek' pattern='^[0-9]{1,3}$' spellcheck='false'>
                    </label>
                    <label>
                        Alapítási éve: <input type='text' name='alapitva' pattern='^[0-9]{4}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='csapat'>Beszúrás</button></div>
                </form>";
        }

        function display_nagydij_insert_form(mysqli $conn) : void
        {
            $result = $conn->query("SELECT nev FROM palya");
            $palyak = [];
            while (($row = $result->fetch_assoc()) != null)
                $palyak[] = $row["nev"];
            $result->free();
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
            $result = $conn->query("SELECT ev FROM soforbajnoksag");
            $result2 = $conn->query("SELECT nev, id FROM sofor");
            $evek = [];
            $soforok = [];
            while (($row = $result->fetch_assoc()) != null)
                $evek[] = $row["ev"];
            $result->free();
            while (($row = $result2->fetch_assoc()) != null)
                $soforok[] = $row["nev"]. "," .$row["id"];
            $result2->free();
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
                       Sofőr pontjai: <input type='text' name='ossz_pont' pattern='^[0-9]{1,3}$' spellcheck='false'>
                    </label>
                    <label>
                       Sofőr rajtszáma: <input type='text' name='szam' required pattern='^[0-9]{2}$' spellcheck='false'>
                    </label>
                    <div class='form_page_submit_btn'><button type='submit' name='key' value='resztvesz'>Beszúrás</button></div>
                </form>";
        }

        function display_sofor_insert_form(mysqli $conn) : void
        {
            $result = $conn->query("SELECT nev FROM csapat");
            $csapatok = [];
            while (($row = $result->fetch_assoc()) != null)
                $csapatok[] = $row["nev"];
            $result->free();
            echo "<div class='form_title'>Sofőr</div><form action='../scripts/insert.php' method='post'>                  
                    <label>
                        Neve: <input type='text' name='nev' required pattern='^(\w)(.|\s){1,150}$' spellcheck='false'>
                    </label>
                    <label>
                        Cimek: <input type='text' name='cimek' pattern='^[0-9]{1,2}$' spellcheck='false'>
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
            $result = $conn->query("SELECT datum FROM nagydij ORDER BY datum DESC");
            $result2 = $conn->query("SELECT nev, id FROM sofor");
            $datumok = [];
            $soforok = [];
            while (($row = $result->fetch_assoc()) != null)
                $datumok[] = $row["datum"];
            $result->free();
            while (($row = $result2->fetch_assoc()) != null)
                $soforok[] = $row["nev"]. "," .$row["id"];
            $result2->free();
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
            match ($_POST["add"])
            {
                "csapat" => display_csapat_insert_form(),
                "nagydij" => display_nagydij_insert_form($conn),
                "palya" => display_palya_insert_form(),
                "resztvesz" => display_resztvesz_insert_form($conn),
                "sofor" => display_sofor_insert_form($conn),
                "soforbajnoksag" => display_soforbajnoksag_insert_form(),
                "versenyez" => display_versenyez_insert_form($conn),
                default => die("Incorrect add button"),
            };
            $conn->close();
        }
        ?>
    </div>
</body>
</html>