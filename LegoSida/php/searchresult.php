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

        $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
        if (!$connection) {
            die('MySQL connection error');
        } else {
            $query = "SELECT sets.Setname, sets.SetID FROM sets WHERE (sets.Setname LIKE '%$searchinput%' OR sets.SetID LIKE '%$searchinput%')";
            $result = mysqli_query($connection, $query);


            print("<table>");
            while ($row = mysqli_fetch_array($result)) {
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

                print("<tr>");
                print("<td>$setname</td>");
                print("<td>$setid</td>");
                print("<td>$image</td>");
                print("</tr>");
            }
            print("</table>");
        }
        ?>
    </div>
</body>

</html>