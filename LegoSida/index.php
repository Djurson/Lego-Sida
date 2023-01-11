<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->
<!DOCTYPE html>
<html lang="sv">

<head>
    <title>
        Lego Sök
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/body.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.cdnfonts.com/css/clicky-bricks" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="header-links">
            <ul>
                <li><a href="index.php">
                        Sök
                    </a></li>
                <li><a href="php/omoss.php">
                        Om oss
                    </a></li>
                <li><a href="">
                        Hur du söker
                    </a></li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <div class="header-text">
            <h1>SÖK EFTER LEGO SET<h1>
        </div>
        <div class="search-div">
            <form action="php/searchresult.php" method="GET">
                <div class="search-bar">
                    <input type="text" value="" placeholder="Sök efter set id eller set namn" id="search" name="search">
                    <input type="hidden" value="1" name="page" id="page">
                </div>
                <div class="search">
                    <button type="submit" value="submit"><img src="img/search_icon.png" alt=""></button>
                </div>
            </form>
            <div class="legomanspeech">
                <div id="speechbubble" class="hide">
                    <p class="speechbubble">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, ipsa.</p>
                </div>
                <div class="lego-character">
                    <img id="legomandiv" src="img/Legoman.png" alt="">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="showspeechbubble.js"></script>

</html>