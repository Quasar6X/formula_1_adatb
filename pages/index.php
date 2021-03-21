<!DOCTYPE html>
<html lang="hu">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/form.css">
    <link rel="stylesheet" href="../style/head.css">
    <meta charset="UTF-8">
    <title>F1</title>
    <style>
        table{
            margin: auto;
            text-align: center;
            line-height: 2.0;
            border-collapse: collapse;
            width: 35%;
        }

        table tr {
            transition: all .2s ease-in-out;
            border-bottom: 2px solid #FF1801;
            cursor: pointer;
        }

        table tr:hover {
            background-color: lightgray;
        }

        table tr td {
            padding: 6px;
        }

        .td_text {
            transition: all .4s ease-in-out;
            width: 190px;
        }

        label {
            font-size: 115%;
        }

        .form_page_submit_btn {
            padding-top: 20px;
        }
    </style>
    <script>
        function onLoad()
        {
            let td = document.getElementsByClassName("td_text")[0];
            let tr = document.getElementsByTagName("tr")[0];
            let radio_btn = document.getElementsByClassName("radio_btn")[0];
            td.style.fontSize = "120%";
            td.style.fontWeight = "bold";
            tr.style.borderBottomWidth = "3px";
            radio_btn.click();
        }

        function onClick(num)
        {
            let radio_btns = document.getElementsByClassName("radio_btn");
            let tds = document.getElementsByClassName("td_text");
            let trs = document.getElementsByTagName("tr");
            radio_btns[num].click();
            tds[num].style.fontSize = "120%";
            tds[num].style.fontWeight = "bold";
            for (let i = 0; i < 7; ++i)
            {
                if (i !== num)
                {
                    tds[i].style.fontSize = "100%";
                    tds[i].style.fontWeight = "normal";
                    trs[i].style.borderBottomWidth = "2px";
                }
                else trs[i].style.borderBottomWidth = "3px";
            }
        }
    </script>
</head>
<body onload="onLoad();">
    <?php
    include "head.html";
    ?>
    <div class="main">
        <div class="form_title">Táblák</div>
        <form method="post" action="query.php">
            <table>
                <tbody>
                    <tr onclick="onClick(0);"><td class="td_text">Csapat</td><td><label><input type="radio" name="table" value="csapat" checked class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(1);"><td class="td_text">Nagydíj</td><td><label><input type="radio" name="table" value="nagydij" class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(2);"><td class="td_text">Pálya</td><td><label><input type="radio" name="table" value="palya" class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(3);"><td class="td_text">Részt vesz</td><td><label><input type="radio" name="table" value="resztvesz" class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(4);"><td class="td_text">Sofőr</td><td><label><input type="radio" name="table" value="sofor" class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(5);"><td class="td_text">Sofőr Bajnokság</td><td><label><input type="radio" name="table" value="soforbajnoksag" class="radio_btn"></label></td></tr>
                    <tr onclick="onClick(6);"><td class="td_text">Versenyez</td><td><label><input type="radio" name="table" value="versenyez" class="radio_btn"></label></td></tr>
                </tbody>
            </table>
            <div class="form_page_submit_btn"><button type="submit">Lekérdez</button></div>
        </form>
    </div>
</body>
</html>