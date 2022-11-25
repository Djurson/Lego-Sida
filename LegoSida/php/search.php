<!doctype html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lego Sida</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body id="body">
    <?php include("../txt/menuphp.txt") ?>
    <section class="my-sqltest">
        <h1>Parts in set: 375-2</h1>
        <?php $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
        if (!$connection) {
            die('MySQL connection error');
        }

        $set = '375-2';

        $query = "SELECT images.has_gif, images.has_jpg, inventory.ItemID, inventory.ColorID, 
                inventory.Quantity, colors.Colorname, parts.Partname 
                FROM inventory, colors, parts, images
                WHERE inventory.SetID='$set' AND inventory.ItemtypeID='P' AND colors.ColorID=inventory.ColorID AND parts.PartID=inventory.ItemID 
                AND images.ItemID=inventory.ItemID AND images.ColorID=inventory.ColorID
                ORDER BY inventory.Quantity DESC";

        $result = mysqli_query($connection, $query);
        print("<table>\n<tr>");
        print("<th>Quantity</th>");
        print("<th>File name</th>");
        print("<th>Picture</th>");
        print("<th>Color</th>");
        print("<th>Part name</th>");
        print("</tr>\n");
        while ($row = mysqli_fetch_array($result)) {
            print("<tr>");
            $Quantity = $row['Quantity'];
            print("<td>$Quantity</td>");

            $image = "http://weber.itn.liu.se/~stegu76/img.bricklink.com/";
            $ItemID = $row['ItemID'];
            $ColorID = $row['ColorID'];

            if ($row['has_jpg']) {
                $filename = "P/$ColorID/$ItemID.jpg";
            } else if ($row['has_gif']) {
                $filename = "P/$ColorID/$ItemID.gif";
            } else {
                $filename = "noimage_small.png";
            }
            print("<td>$filename</td>");
            print("<td><img src=\"$image$filename\" alt=\"Part $ItemID\"/></td>");

            $Colorname = $row['Colorname'];
            print("<td>$Colorname</td>");

            $Partname = $row['Partname'];
            print("<td>$Partname</td>");

            print("</tr>\n");
        }
        print("</table>\n");

        mysqli_close($connection);
        ?>
        </table>
    </section>
</body>

</html>