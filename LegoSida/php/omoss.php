<!doctype html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <?php
    include("../txt/TopMenu.txt");
    ?>
    <div class="main">
        <h1 class="omossheader">Om oss</h1>
        <p class="omosstop">Välkommen till Om oss. Här förklarar vi vilka vi är och varför vi gjort denna sida. </p>
        <p class="omossbody">Vi som skapat den här webb sidan är fyra killar som heter Emil, Jonas, Axel och Ayham. Vi är
        studenter som
        studerar till civilingenjörer inom medieteknik vid Linköpings Universitet på
        Campus Norrköping. Vi gör allihop vårat första år av fem utav utbildningen.
        Detta är ett projektarbete i kursen Elektronisk Publicering där vi skapat en webbsida med en
        sökmotor för legoset och bitar. Sidan är gjord med hjälp av grundläggande kunskaper inom html-, css-,
        javascript-, php-, och sql-programmering
        </p>
        <div class="legomanspeech">
            <div id="speechbubble" class="hide">
                <p class="speechbubble">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, ipsa.</p>
            </div>
            <div class="lego-character">
                <img id="legomandiv" src="../img/Legoman.png" alt="">
            </div>
        </div>
    </div>
</body>
<script src="showspeechbubble.js"></script>
</html>