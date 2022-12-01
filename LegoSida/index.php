<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/body.css">
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
                <li><a href="php/searchtest.php">Sök</a></li>
                <li><a href="">Om oss</a></li>
                <li><a href="">Hur sökmotorn funkar</a></li>
            </ul>
        </div>
    </nav>
    <!-- <div class="header-line"><div></div></div> -->

    <div class="main">
        <div class="header-text">
            <h1>SÖK EFTER LEGO SET</h1>
        </div>
        <div class="search-div">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="search-bar">
                    <input type="text" placeholder="Sök efter lego set" id="searchbar">
                </div>
                <div class="search">
                    <button type="submit"><img src="img/search_icon.png" alt=""></button>
                </div>
            </form>
            <div id="legoman" class="lego-character">
                <img src="img/character_normal.png" alt="">
            </div>
            <div class="image">

                <img src="img/speechbubble.png" alt="not found">

                <p class="imgtext">Text</p>

            </div>
        </div>
    </div>
</body>

</html>