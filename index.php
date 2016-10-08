<?php require "logic.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="img/ikona.ico" />
    <link rel=“apple-touch-icon“ href=“img/zapisy-512px.png“/>
    <link rel="icon" type="image/png" href="img/zapisy-512px.png"/>
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="author" content="github.com/jelinekp/zapisy"
    <link href="https://fonts.googleapis.com/icon?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="common.css"/>
    <link rel="stylesheet" media="(min-width: 731px)" type="text/css" href="style.css"/>
    <link rel="stylesheet" media="(max-width: 730px)" type="text/css" href="mobile.css"/>
    <title>Zápisy</title>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-75034559-1', 'auto');
      ga('send', 'pageview');
    </script>
  </head>
  <body>
    <div id="container">
      <h1>Zápisy 3.E</h1>
      <p>Archiv obsahuje starší zápisy</p>
      <table>
        <?php make_subjects(); ?>
      </table>
      <p>Pokud byste našli chybu v učivu, tak ji ihned opravte - případně můžete komentovat učivo. Jakákoli pomoc je velmi důležitá.
        Můžete přidávat obrázky, náčrty, vzorce, ... <br /> Zápisy z chemie a fyziky již nebudou dostupné.<br />Za chyby v učivu v žádném případě nezodpovídáme. <br />
        Hlavní contributoři: <a href="https://plus.google.com/117073341275292426772">baxit</a>, <a href="http://jelinekp.wz.cz/">jelinekp</a>
        a <a href="https://markaos.cz/">Markaos</a><br />
        Mobilní aplikace (i pro offline zápisy):
        <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.docs.editors.docs">
             Dokumenty (Google Play)</a><br>
               <a href="https://github.com/jelinekp/zapisy">Projekt na GitHubu (jelinekp/zapisy)</a>
               <br />© 2016
      </p>
    </div>
    <div id="examsContainer">
      <h2>Písemky</h2>
      <table>
        <?php make_exams(); ?>
      </table>
    </div>
  </body>
</html>
