<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/legoset.css">
    <link rel="stylesheet" href="../css/legosearch.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>

<body>
    <?php
    // Skriver ut topp menyn
    include("../txt/TopMenu.txt");
    ?>
    <h1 class="title">BRICKSTON</h1>
    <div class="main">
        <?php
        // Kollar ifall vi är kopplade till databasen, om inte ska vi inte göra något arbete
        $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
        if (!$connection) {
            die('MySQL connection error');
        } else {

            // Får information om vilket set personen har klickat på samt vad personen tidigare sökt på (Ifall personen vill gå tillbaka)
            $searchinput = $_GET['search'];
            $clickedsetnameid = $_GET['clickedset'];
            $sortby = $_GET['sortby'];
            $srtbystruc = $_GET['srtbystruc'];

            // Separerar setname och setid
            $splitnameid = explode("&", strval($clickedsetnameid));
            $setid = $splitnameid[0];
            $setname = $splitnameid[1];

            // Länk till bild hemsidan
            $link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/";

            // Räknar hur många bitar det är i settet
            $partsquantityquery = "SELECT SUM(inventory.Quantity) AS totalparts FROM inventory WHERE SetID = '$setid'";
            $partquantityresult = mysqli_query($connection, $partsquantityquery);
            $totalpartsarr = mysqli_fetch_array($partquantityresult);
            $totalparts = $totalpartsarr['totalparts'];

            // Bild val till själva setet
            $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
            $imagesearch = mysqli_query($connection, $imagequery);
            $imagevector = mysqli_fetch_array($imagesearch);

            if ($imagevector['has_jpg']) {
                $endlink = "SL/$setid.jpg";
            } else if ($imagevector['has_gif']) {
                $endlink = "SL/$setid.jpg";
            }
            $image = "<img class='LegoSetImage' src='$link$endlink' alt='No Image Found'>";

            // Kollar ifall sorteringen ska ske ASC eller DESC
            if ($srtbystruc == "" || $srtbystruc == "ASC") {
                $srtbystruc = "DESC";
                $arrow = "<span class='sortarrow'><span class='material-symbols-outlined'>expand_more</span></span>";
            } else if ($srtbystruc == "DESC") {
                $srtbystruc = "ASC";
                $arrow = "<span class='sortarrow'><span class='material-symbols-outlined'>expand_less</span></span>";
            }

            // Samma som den ovan bara för varje knapp
            if ($sortby == "Quantity" || $sortby == "") {
                $sortby = "inventory.Quantity";
                $minifigsort = "inventory.Quantity";
                $quantityarrow = $arrow;
            } else if ($sortby == "ColorID") {
                $sortby = "inventory.ColorID";
                $minifigsort = "inventory.Quantity";
                $colorarrow = $arrow;
            } else if ($sortby == "Partname") {
                $sortby = "LENGTH(parts.Partname)";
                $minifigsort = "LENGTH(minifigs.Minifigname)";
                $partarrow = $arrow;
            }

            // Parts query/hämtning
            $queryparts = "SELECT images.has_gif, images.has_jpg, inventory.ItemID, inventory.ColorID, 
        inventory.Quantity, colors.Colorname, parts.Partname 
        FROM inventory, colors, parts, images
        WHERE inventory.SetID='$setid' AND inventory.ItemtypeID='P' AND colors.ColorID=inventory.ColorID AND parts.PartID=inventory.ItemID 
        AND images.ItemID=inventory.ItemID AND images.ColorID=inventory.ColorID
        ORDER BY $sortby $srtbystruc";

            $resultparts = mysqli_query($connection, $queryparts);

            // Minfigs query/hämtning
            $queryminifig = "SELECT inventory.Quantity, minifigs.Minifigname, minifigs.MinifigID FROM inventory, minifigs WHERE inventory.SetID='$setid' 
        AND inventory.ItemtypeID='M' AND minifigs.MinifigID=inventory.ItemID ORDER BY $minifigsort $srtbystruc";
            $resultsminifig = mysqli_query($connection, $queryminifig);

            // Tillbaka knappen
            print('<form action="' . htmlspecialchars('../php/searchresult.php') . '" method="GET">');
            print('<input type="hidden" value="' . $searchinput . '" name="search" id="search">');
            print("<input type='hidden' value='1' name='page' id='page'>");
            print("<button type='submit' class='backbutton'>Gå Tillbaka</button>");
            print("</form>");

            // Skriver ut set namn, totala delar, bild samt 
            print("<h1 class='SetName'>$setname</h1>");
            print("<p class='TotalpartsText'> Total parts: $totalparts</p>");
            print("$image");

            // Kollar ifall setet innehåller delar/minifigs eller ifall lego setet bara består av andra legoset
            if (mysqli_num_rows($resultparts) != 0 || mysqli_num_rows($resultsminifig) != 0) {
                // SKriver ut sorterings knapparna
                print("<table class='PartsTable'>\n<tr>");
                print("<form class='SortForm' method='GET'>");
                print("<input type='hidden' value='$clickedsetnameid' id='clickedset' name='clickedset'>");
                print("<input type='hidden' value='$srtbystruc' id='srtbystruc' name='srtbystruc'>");
                print("<th><button type='submit' value='Quantity' id='sortby' name='sortby'>Quantity" . $quantityarrow . "</button></th>");
                print("<th><button disabled>Picture</button></th>");
                print("<th><button type='submit' value='ColorID' id='sortby' name='sortby'>Color" . $colorarrow . "</button></th>");
                print("<th><button type='submit' value='Partname' id='sortby' name='sortby'>Part name" . $partarrow . "</button></th>");
                print("</form>");
                print("</tr>\n");

                // Parts utskrivning
                while ($row = mysqli_fetch_array($resultparts)) {
                    print("<tr>");
                    $Quantity = $row['Quantity'];
                    print("<td>$Quantity</td>");

                    $ItemID = $row['ItemID'];
                    $ColorID = $row['ColorID'];

                    if ($row['has_jpg']) {
                        $filename = "P/$ColorID/$ItemID.jpg";
                    } else if ($row['has_gif']) {
                        $filename = "P/$ColorID/$ItemID.gif";
                    } else {
                        $filename = "noimage_small.png";
                    }
                    print("<td><img class='LegoPartImage' src='$link$filename' alt='Part $ItemID'/></td>");

                    $Colorname = $row['Colorname'];
                    print("<td>$Colorname</td>");

                    $Partname = $row['Partname'];
                    print("<td>$Partname</td>");

                    print("</tr>\n");
                }

                // Minfigs utskrivning
                while ($row = mysqli_fetch_array($resultsminifig)) {
                    print("<tr>");
                    $Quantity = $row['Quantity'];
                    $ItemID = $row['MinifigID'];
                    print("<td>$Quantity</td>");
                    $filename = "ML/$ItemID.jpg";
                    print("<td><img class='LegoPartImage' src='$link$filename' alt='Minifig $ItemID'/></td>");

                    $Colorname = "Minifig";
                    print("<td>$Colorname</td>");

                    $Partname = $row['Minifigname'];
                    print("<td>$Partname</td>");

                    print("</tr>\n");
                }

                print("</table>");
            } else {
                // Ifall setet inte består av legobitar/minifigs består setet endast av andra legoset
                print("<h2 class='ErrorSetInLegoSet'>Vekar som om detta lego set endast består av andra lego set</h2>");

                // Hämtar vilka set id det finns i lego setet
                $querylegosets = "SELECT inventory.ItemID FROM inventory WHERE SetID = '$setid'";
                $resultsforlegosetsinlego = mysqli_query($connection, $querylegosets);

                // Skriver ut ett form då användaren kanske även vill komma till självaste setet
                print('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="GET">');
                print('<input type="hidden" value="' . $searchinput . '" name="search" id="search">' . "\n");
                print("<div class='LegoResults'>");

                // While -> går igenom och kollar vad för sets det är
                while ($row = mysqli_fetch_array($resultsforlegosetsinlego)) {
                    print("<div class='LegoResultsItem'>");
                    // Tar första i arrayen för det är set id
                    $setidinset = $row[0];

                    // Hämtar information om setnamnet
                    $querysetname = "SELECT sets.Setname FROM sets WHERE sets.SetID='$setidinset'";
                    $resultsforsetname = mysqli_query($connection, $querysetname);
                    $resultsetname = mysqli_fetch_array($resultsforsetname)[0];

                    //Image searchar efter setnamnet
                    $gif = $row['has_gif'];
                    $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
                    $imagesearch = mysqli_query($connection, $imagequery);
                    $imagevector = mysqli_fetch_array($imagesearch);

                    if ($imagevector['has_jpg']) {
                        $endlink = $link . "SL/$setidinset.jpg";
                    } else if ($imagevector['has_gif']) {
                        $endlink = $link . "SL/$setidinset.jpg";
                    }
                    $image = "<img class='LegoSetImage' src='$endlink' alt=''>";

                    // Printar ut själva form knappen och skickar tillbaka värdena till product.php (Samma php fil som vi är i nu)
                    print("<button class='LegoSetButton' type='submit' value='$setidinset&$resultsetname'name='clickedset' id='clickedset'\n");
                    print("<p class='Setname'>$resultsetname</p>\n");
                    print("$image\n");
                    print("<p class='SetID'>$setidinset</p>\n");
                    print("</button>\n");
                    print("</div>");
                }
                print("</div>");
                print("</form>");
            }
            mysqli_close($connection);
        }
        ?>
    </div>
</body>

</html>