<?php require "../logic.php"; require "../provider.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/img/ikona.ico" />
    <link rel=“apple-touch-icon“ href=“/img/zapisy-512px.png“/>
    <link rel="icon" type="image/png" href="/img/zapisy-512px.png"/>
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="author" content="github.com/jelinekp/zapisy" />
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic,100italic,100&subset=latin-ext' type='text/css' />
    <link rel="stylesheet" type="text/css" href="jquery/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/<?= V::file("common.css") ?>"/>
    <link rel="stylesheet" media="(min-width: 731px)" type="text/css" href="/<?= V::file("style.css") ?>"/>
    <link rel="stylesheet" media="(max-width: 730px)" type="text/css" href="/<?= V::file("mobile.css") ?>"/>
    <title>Tutoriál - zapisy</title>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-75034559-2', 'auto');
      ga('send', 'pageview');
    </script>
  </head>
  <body>
    <div id="container">
      <h1>Užitečný návod</h1>
      <div id="page">
     <p>Pro ty co chtějí ze Zápisů vytěžit maximum. Doporučujeme mobilní aplikaci pro správné zobrazení a možnost
       editace na mobilu:
       Dokumenty Google (<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.docs.editors.docs">Google Play</a>,
  <a href="https://itunes.apple.com/cz/app/google-docs/id842842640?mt=8">App Store</a>)<br>
          Potřebujeme, aby se Zápisy zdokonalily. Pomožte opravováním chyb, vkládáním návrhů, ...
      <hr />  <a href="https://play.google.com/store/apps/details?id=cz.wz.markaos.workbooks">
        <img src="/img/tutorial/app.png" width="12%" title="Aplikace na Google Play" class="right top"/></a>
        <ul>
          <li><span class="bolder">Mobilní aplikace Zápisy™ pro Android</span>
            <br />Nejjednodušší cesta k zápisům i písemkám. Podporuje také notifikace.</li>
            <a href="https://play.google.com/store/apps/details?id=cz.wz.markaos.workbooks">
              Odkaz na Zápisy™ na Google Play<br />
<br />
          </a>
        </ul>
      <hr />
        <ul>
          <li><span class="bolder">Systém komentářů </span>
            <br /> Neváhejte a komentujte, potřebujeme zpětnou vazbu.</li>
            <img src="/img/tutorial/comment.png" width="55%" title="Komentování" class="border" />
            <img src="/img/tutorial/orthis-comment.png" width="7%" title="Vložení jednořádkového komentáře" class="border top right" />&nbsp;
            <img src="/img/tutorial/comment2.png" width="33%" title="Ukázka komentářů" class="border" />
              Podobným systémem lze komentovat i na mobilu.
        </ul>
      <hr />
        <ul>
          <li><span class="bolder">Navrhování úprav </span>
            <br /> Pokud chcete něco hned opravit, tak to bez obav přepište.</li>
            <br />
            <img src="/img/tutorial/suggesting.png" width="95%" class="border" />
            <br />
              Po napsání návrhu přijde správcům oznámení a situaci vyřeší.
              Bylo by super, kdybyste byli přihlášeni  Google účtem (aby návrhy nebyly anonymní).
        </ul>
      <hr />
        <ul>
          <li><span class="bolder">Osnova</span>
            <br />Pro snadnější orientaci ve velkých souborech (př archivy) na počítači a na mobilu:</li>
            <br />
            <img src="/img/tutorial/outline-desktop.png" width="21%" title="Osnova na počítači" class="border" />
            <img src="/img/tutorial/outline-mobile.png" width="30%" title="Osnova v mobilní aplikaci Dokumenty" class="border right" />
            <br />
        </ul>
        <hr />
        <ul>
          <li>
            <span class="bolder">Dokumenty lze zpřístupnit
            offline</span>
            (pak se budou samy aktualizovat - při připojení na internet):
          </li>
          <br />
           <img src="/img/tutorial/offline.png" width="35%" title="Zpřístupnění offline v mobilní aplikaci" class="border" />
           <img src="/img/tutorial/offline-desktop2.png" width="55%" title="Zpřístupnění offline na portálu docs.google.com" class="border right" />
           <br />
        </ul>
        <hr />
          <ul>
            <li><span class="bolder">Další tipy a triky</span></li>
            <br />
              <ul>
                <li>
                  Ikonu zápisů si můžete dát na "plochu" (stačí otevřít menu v prohlížeči), ale doporučujeme stáhnout naši aplikaci.
                </li>
                <!--<img src="/img/tutorial/add-to-homescreen.png" width="30%" title="Dát na domovskou obrazovku" class="border" />
                <br />-->
                <li>
                  Slova nebo části textu můžete "prozkoumat" (opět funguje i v nabídce na mobilu)
                   a případně můžete vložit související obrázky:
                </li>
                <br>
                <img src="/img/tutorial/prozkoumat.png" width="50%" title="Prozkoumat na počítači" class="border" />
                <img src="/img/tutorial/explore-mobile.png" width="45%" title="Prozkoumat nebuněčné organismy" class="border right" />
                <br />
                <br />
                <li>
                  Pokud se vám na mobilu nevejde tabulka nebo obrázek (také nemám rád posouvání ze strany na stranu), zkuste režim na šířku.
                </li>
                <li>
                  Upravovat může více lidí naráz.
                </li>
                <li>
                  Pomocí text-to-speech modulu lze dokumenty poslouchat (nutné zapnout režim usnadnění - už mi to nefunguje - nejlepší řešení Google Translate).
                </li>
                <li>
                  <span class="bolder">Hledáme další správce</span>, jestli chcete, ozvěte se, přidáme vám potřebná oprávnění.
                </li>
              </ul>
          </ul>
          <div id="center">
          <a href="/" class="back" >Zpět na hlavní stránku</a>
        </div>
      </p>
     </div>
    </div>
  </body>
</html>
