<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->
<?php include("../txt/lang.txt");?>
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
<?php
include("../txt/TopMenu.txt");
?>

<div class="main">
    <div class="header-text">
        <h1>Resultat</h1>
    </div>
    <div class="search-div">
        <form action="searchresult.php" method="GET">
            <div class="search-bar">
                <input type="text" value="" placeholder="Sök efter lego set" id="search" name="search">
                <input type="hidden" value="1" name="page" id="page">
            </div>
            <div class="search">
                <button type="submit" value="submit"><img src="../img/search_icon.png" alt=""></button>
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

    <?php
    $link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/";
    $searchinput = $_GET['search'];
    $page = $_GET['page'];

    $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
    if (!$connection) {
        die('MySQL connection error');
    } else {
        print('<form action="../legoset/product.php" method="GET">');
        $query = "SELECT sets.Setname, sets.SetID FROM sets WHERE (sets.Setname LIKE '%$searchinput%' OR sets.SetID LIKE '%$searchinput%') ORDER BY LENGTH(sets.setName)";
        $currentlimit = ($page - 1) * 25;
        $limit = 'LIMIT ' . $currentlimit . ",25";
        $result = mysqli_query($connection, $query . $limit);
        $resultstotal = mysqli_query($connection, $query);

        print("<table>");
        $numberofresults = mysqli_num_rows($resultstotal);
        $pagelimit = ceil(floatval($numberofresults) / floatval(25));
        $showingresults = $page * 25;

        print("<p class='SearchResultInfotext'>Showing $showingresults out of $numberofresults results</p>\n");
        print("<p class='SearchResultInfotext'>Page $page / $pagelimit</p>\n");

        while (($row = mysqli_fetch_array($result))) {
            $setid = $row['SetID'];
            $setname = $row['Setname'];
            $gif = $row['has_gif'];

            $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
            $imagesearch = mysqli_query($connection, $imagequery);
            $imagevector = mysqli_fetch_array($imagesearch);

            if ($imagevector['has_jpg']) {
                $endlink = "SL/$setid.jpg";
            } else if ($imagevector['has_gif']) {
                $endlink = "SL/$setid.jpg";
            }
            $image = "<img class='LegoSetImage' src='$link$endlink' alt='No Image Found'>";

            print("<tr>\n");    
            print("<button class='LegoSetButton' type='submit' value='$setid&$setname'name='clickedset' id='clickedset'\n");
            print("<p>$setname</p>\n");
            print("<p>$setid</p>\n");
            print("<p>$image</p>\n");
            print("</button>\n");
            print("</tr>\n");
        }
        print("</table>\n");
        print("</form>");

        print("<form method='GET'>");

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
        print("<button class='PrevPageButton' type='submit' value='$prevpage' name='page' id='page'>Prev Page</button>\n");
        print("<input type='hidden' value='$searchinput' id='search' name='search'>\n");
        print("<button class='NextPageButton' type='submit' value='$nextpage' name='page' id='page'>Next Page</button>\n");
        print("</form>");
    }
    ?>
</div>
</body>

</html>