<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
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
                <li><a href="../index.php">Sök Test</a></li>
                <li><a href="">Om oss</a></li>
                <li><a href="">Hur sökmotorn funkar</a></li>
            </ul>
        </div>
    </nav>
    <!-- <div class="header-line"><div></div></div> -->

    <div class="main">
        <div class="header-text">
            <h1>Resultat</h1>
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
            $limit = 'LIMIT '.$currentlimit.",25";
            $result = mysqli_query($connection, $query.$limit);
            $reusltstotal = mysqli_query($connection, $query);

            print("<table>");
            $numberofresults = mysqli_num_rows($reusltstotal);
            $showingresults = $page*25;

            if($showingresults > $numberofresults){
                $showingresults = $numberofresults;
            }
            print("<p>Showing $showingresults out of $numberofresults results</p>");
            
            while (($row = mysqli_fetch_array($result))) {
                $setid = $row['SetID'];
                $setname = $row['Setname'];
                $gif = $row['has_gif'];

                $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
                $imagesearch = mysqli_query($connection, $imagequery);
                $imagevector = mysqli_fetch_array($imagesearch);

                if ($imagevector['has_jpg']) {
                    $endlink = "S/$setid.jpg";
                } else if ($imagevector['has_gif']) {
                    $endlink = "S/$setid.gif";
                }
                $image = "<img src='$link$endlink' alt='No Image Found'>";

                $buttontype = 'type="submit"';
                $buttonvalue = 'value="'.$setid.'"';
                $buttonname = 'name="clickedset" id="clickedset"';
                
                print("<tr>\n");
                print("<button $buttontype $buttonvalue $buttonname>\n");
                print("<p>$setname</p>\n");
                print("<p>$setid</p>\n");
                print("<p>$image</p>\n");
                print("</button>\n");
                print("</tr>\n");
            }
            print("</table>\n");
            print('</form>');

            print('<form method="GET">');

            $nextpage = $page += 1;
            $pagebtnvalue = 'value="'.$nextpage.'"';
            $pagebtnname = 'name="page" id="page"';
            print('<input type="hidden" value="'.$searchinput.'" id="search" name="search">');
            print("<button $buttontype $pagebtnvalue $pagebtnname>Next Page</button>");
            print('</form>');
        }
        ?>
    </div>
</body>

</html>