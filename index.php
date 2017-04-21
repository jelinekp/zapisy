<?php require "logic.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="img/ikona.ico" />
    <link rel=“apple-touch-icon“ href="img/zapisy-512px.png"/>
    <link rel="icon" type="image/png" href="img/zapisy-512px.png"/>
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="author" content="github.com/jelinekp/zapisy" />
    <meta name="description" content="Zápisy 3.E z GFPVM" />
    <link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="jquery/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= V::file("common.css") ?>"/>
    <link rel="stylesheet" media="(min-width: 731px)" type="text/css" href="<?= V::file("style.css") ?>"/>
    <link rel="stylesheet" media="(max-width: 730px)" type="text/css" href="<?= V::file("mobile.css") ?>"/>
    <title>Zápisy</title>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-75034559-1', 'auto');
      ga('send', 'pageview');
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="jquery/jquery.leanModal.min.js"></script>
    <script src="jquery/jquery-ui.min.js"></script>
    <script src="<?= V::file("script.js") ?>"></script>
  </head>
  <body onLoad="load()">
    <div id="lean_overlay"></div>
    <div id="add-exam" class="lean_modal">
      <div style="position: absolute; top: 16px; left: 50%;">
        <div style="position: relative; left: -50%;">
          <span class="modal-title">Nová písemka</span>
        </div>
      </div>
      <div class="modal-close"></div>
      <form method="POST" action="add.php">
        <select class="input-select" name="subject" placeholder="Předmět">
          <?php
            $subjects = json_decode(file_get_contents("subjects.json"), true);
            foreach($subjects as $subject) {
              echo "<option value=\"" . $subject["name"] . "\">" . $subject["name"] . "</option>\n";
            }
          ?>
        </select><br>
        <input class="input-text" type="text" name="range" placeholder="Rozsah"><br>
        <input class="input-date" type="text" name="date" placeholder="Datum"><br>
        <input type="hidden" name="author" value="-1">
        <input type="hidden" name="notes" value="">
        <input class="button-send" type="submit" name="sent" value="PŘIDAT">
      </form>
    </div>
    <div id="delete-exam" class="lean_modal">
      <div style="position: absolute; top: 16px; left: 50%;">
        <div style="position: relative; left: -50%;">
          <span class="modal-title">Odstranit písemku</span>
        </div>
      </div>
      <div class="modal-close"></div>
      <span class="delete-exam-text">Opravdu chcete tuto písemku odstranit?</span>
      <form method="POST" action="delete.php">
        <input type="hidden" name="id" id="delete-exam-id" />
        <input class="button-send" type="submit" name="sent" value="ODSTRANIT">
      </form>
    </div>
    <div id="containerHack"><div id="container">
      <h1>Zápisy 3.E</h1>
      <p>Archiv obsahuje starší zápisy, <a href="tutorial">užitečné tipy a triky najdete zde.</a></p>
      <div id="stupidCountdownContainer">
        <span class="stupidElement" id="stupidHolidayCountdownRequestedByRadekDesignedByPavelAndModifiedByMarek"></span>
      </div>
      <table>
        <?php make_subjects(); ?>
      </table>
      <p>Pokud byste našli chybu v učivu, tak ji ihned opravte - případně můžete komentovat učivo. Jakákoli pomoc je velmi důležitá.
        Můžete přidávat obrázky, náčrty, vzorce, ... <br /> Zápisy z fyziky již nebudou dostupné.<br />Za chyby v učivu v žádném případě nezodpovídáme. <br />
        Hlavní přispěvatelé: <a href="https://plus.google.com/117073341275292426772">baxit</a>, <a href="http://jelinekp.wz.cz/">jelinekp</a>
        a <a href="https://markaos.cz/">Markaos</a><br />
        Mobilní aplikace (i pro offline zápisy):
        Dokumenty Google (<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.docs.editors.docs">Google Play</a>,
        <a href="https://itunes.apple.com/cz/app/google-docs/id842842640?mt=8">App Store</a>)<br>
        <a href="https://github.com/jelinekp/zapisy">Projekt na GitHubu (jelinekp/zapisy)</a>
        <span style="text-align: center; width: 100%; display: block;">© 2016</span>
      </p>
    </div></div>
    <div id="examsContainer">
      <h2>Písemky</h2>
      <table>
        <?php make_exams(); ?>
        <tr>
          <td class="exams-button-container">
            <a href="#add-exam" class="exams-button trigger">Přidat písemku</a>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
