<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->

<!DOCTYPE html>
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
    <nav>
        <div class="header-links">
            <ul>
                <li><a href="searchtest.php">Sök Test</a></li>
                <li><a href="">Om oss</a></li>
                <li><a href="">Hur sökmotorn funkar</a></li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <div class="search-div">
            <form action="searchresult.php" method="GET">
                <div class="search-bar">
                    <input type="text" value="" placeholder="Sök efter lego set" id="search" name="search">
                </div>
                <div class="search">
                    <button type="submit" value="submit"><img src="../img/search_icon.png" alt=""></button>
                </div>
            </form>
            <div id="legoman" class="lego-character">
                <img src="../img/character_normal.png" alt="">
            </div>
            <div class="imageContainer">Text</div>
        </div>
    </div>
</body>

</html>