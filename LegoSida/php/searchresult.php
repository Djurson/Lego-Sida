<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/legosearch.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,500,1,0" />
    <script src="../js/errorspeech.js" defer></script>
</head>
<?php
// Skriver ut topp menyn
include("../txt/TopMenu.txt");
?>
<h1 class="title">BRICKSTON</h1>
<div class="main">
    <div class="header-text">
        <h2>Resultat</h2>
    </div>
    <!-- Skriver ut sökrutan igen ifall användaren vill söka igen -->
    <div class="search-div">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <div class="search-bar">
                <input type="text" value="" placeholder="Sök efter lego set" id="search" name="search">
                <input type="hidden" value="1" name="page" id="page">
            </div>
            <div class="search">
                <button type="submit" value="submit"><img src="../img/search_icon.png" alt=""></button>
            </div>
        </form>
    </div>

    <?php
    // Får information om vad personen har sökt på samt vilken sida som ska visas
    $searchinput = $_GET['search'];
    $page = $_GET['page'];

    // Länk till bild hemsidan
    $link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/";
    $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

    // Kollar ifall vi är kopplade till databasen, om inte ska vi inte göra något arbete
    if (!$connection) {
        die('MySQL connection error');
    } else {
        // Börjar med att söka efter set samt limitera till 25 per sida
        $query = "SELECT sets.Setname, sets.SetID FROM sets WHERE (sets.Setname LIKE '%$searchinput%' OR sets.SetID LIKE '%$searchinput%') ORDER BY LENGTH(sets.setName)";
        $currentlimit = ($page - 1) * 25;
        $limit = 'LIMIT ' . $currentlimit . ",25";
        $result = mysqli_query($connection, $query . $limit);
        $resultstotal = mysqli_query($connection, $query);

        // Beräknar antalet resultat samt hur många sidor som ska användas
        $numberofresults = mysqli_num_rows($resultstotal);
        $pagelimit = ceil(floatval($numberofresults) / floatval(25));
        if ($numberofresults > $page * 25) {
            $showingresults = $page * 25;
        } else {
            $showingresults = $numberofresults;
        }

        print('<form action="' . htmlspecialchars('product.php') . '" method="GET">');
        // Ifall antalet resultat är större eller lika med ett skrivs alla sets ut, ifall antalet resultat är 0. Skrivs inget ut förutom ett fel medelande
        if ($numberofresults >= 1) {
            // Skriver ut antalet sidor samt hur många resultat
            print("<div class='infotextdiv'>");
            print("<p class='SearchResultInfotext'>Page $page / $pagelimit</p>\n");
            print("<p class='SearchResultInfotext'>Showing $showingresults out of $numberofresults results</p>\n");
            print("</div>");

            // Skriver ut varje lego set resultaten
            print("<div class='LegoResults'>");
            print('<input type="hidden" value="' . $searchinput . '" name="search" id="search">' . "\n");
            while (($row = mysqli_fetch_array($result))) {
                print("<div class='LegoResultsItem'>");
                $setid = $row['SetID'];
                $setname = $row['Setname'];
                $gif = $row['has_gif'];

                $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
                $imagesearch = mysqli_query($connection, $imagequery);
                $imagevector = mysqli_fetch_array($imagesearch);


                if ($imagevector['has_jpg']) {
                    $endlink = $link . "SL/$setid.jpg";
                } else if ($imagevector['has_gif']) {
                    $endlink = $link . "SL/$setid.jpg";
                }
                $image = "<img class='LegoSetImage' src='$endlink' alt=''>";

                // Gör varje resultat till en knapp
                print("<button class='LegoSetButton' type='submit' value='$setid&$setname'name='clickedset' id='clickedset'\n");
                print("<p class='Setname'>$setname</p>\n");
                print("$image\n");
                print("<p class='SetID'>$setid</p>\n");
                print("</button>\n");
                print("</div>");
            }
            print("</div>");
            print("</form>\n");

            // Ifall det är mer än en sida ges alternativet att gå till nästa eller förgående sida
            if ($pagelimit > 1) {
                print('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="GET" class="pageform">');

                $page = $_GET['page'];
                $prevpagecheck = $page - 1;
                $nextpagecheck = $page + 1;

                if ($prevpagecheck >= 1) {
                    $prevpage = $page - 1;
                } else {
                    $prevpage = $page;
                }

                if ($nextpagecheck <= $pagelimit) {
                    $nextpage = $page += 1;
                } else {
                    $nextpage = $page;
                }
                print("<button class='PrevPageButton' type='submit' value='$prevpage' name='page' id='page'><span class='prevarrow'>
                <span class='material-symbols-outlined'>arrow_back_ios</span></span></button>\n");
                print("<input type='hidden' value='$searchinput' id='search' name='search'>\n");
                print("<button class='NextPageButton' type='submit' value='$nextpage' name='page' id='page'><span class='nextarrow'>
                <span class='material-symbols-outlined'>arrow_forward_ios</span></span></button>\n");
                print("</form>");
            }
        } else {
            // Ifall användaren skulle få 0 resultat så skrivs ett fel medelande ut
            print("<div class='legomanspeech'>
                <div id='speechbubble' class='hide'><p class='speechbubble' id='speechbubbletext'>Woops... Såg ut som om någonting gick fel. Vi fick inga resultat på din sökning...</p></div>
                <div class='lego-character'><img id='legomandiv' src='../img/Legoman.png' alt='Legoman'></div></div>");
        }
    }
    ?>
</div>
</body>

</html>