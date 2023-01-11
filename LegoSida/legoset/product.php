<!-- http://www.student.itn.liu.se/~emidj236/Lego/Lego-Sida/LegoSida/ -->
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/legoset.css">
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
        <?php
        $link = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/";
        $clickedsetnameid = $_GET['clickedset'];
        $splitnameid = explode("&", strval($clickedsetnameid));
        $setid = $splitnameid[0];
        $setname = $splitnameid[1];

        $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

        $partsquantityquery = "SELECT inventory.Quantity FROM inventory WHERE inventory.SetID='$setid'";
        $partquantityresult = mysqli_query($connection, $partsquantityquery);
        $totalparts = 0;

        while ($currentpart = mysqli_fetch_array($partquantityresult)) {
            $totalparts += $currentpart['Quantity'];
        }

        /*
        Image
        */
        $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

        $imagequery = "SELECT * FROM images WHERE ItemtypeID='S' AND ItemID='$setid'";
        $imagesearch = mysqli_query($connection, $imagequery);
        $imagevector = mysqli_fetch_array($imagesearch);

        if ($imagevector['has_jpg']) {
            $endlink = "SL/$setid.jpg";
        } else if ($imagevector['has_gif']) {
            $endlink = "SL/$setid.jpg";
        }
        $image = "<img class='LegoSetImage' src='$link$endlink' alt='No Image Found'>";

        /*
        */

        print("<h1 class='SetName'>$setname</h1>");
        print("<p class='TotalpartsText'> Total parts: $totalparts </p>");
        print("$image");
        print("<table class='PartsTable'>\n<tr>");
        print("<th>Quantity</th>");
        print("<th>Picture</th>");
        print("<th>Color</th>");
        print("<th>Part name</th>");
        print("</tr>\n");

        $query = "SELECT images.has_gif, images.has_jpg, inventory.ItemID, inventory.ColorID, 
        inventory.Quantity, colors.Colorname, parts.Partname 
        FROM inventory, colors, parts, images
        WHERE inventory.SetID='$setid' AND inventory.ItemtypeID='P' AND colors.ColorID=inventory.ColorID AND parts.PartID=inventory.ItemID 
        AND images.ItemID=inventory.ItemID AND images.ColorID=inventory.ColorID
        ORDER BY inventory.Quantity DESC";

        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($result)) {
            print("<tr>");
            $Quantity = $row['Quantity'];
            print("<td>$Quantity</td>");

            $ItemID = $row['ItemID'];
            $ColorID = $row['ColorID'];

            if ($row['has_jpg']) {
                $filename = "P/$ColorID/$ItemID.jpg";
            } 
            else if ($row['has_gif']) {
                $filename = "P/$ColorID/$ItemID.gif";
            }
            else {
                $filename = "noimage_small.png";
            }
            print("<td><img class='LegoPartImage' src='$link$filename' alt='Part $ItemID'/></td>");

            $Colorname = $row['Colorname'];
            print("<td>$Colorname</td>");

            $Partname = $row['Partname'];
            print("<td>$Partname</td>");

            print("</tr>\n");
        }
        print("</table>\n");

        mysqli_close($connection);
        ?>
    </div>
</body>

</html>