<?php
//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";
require_once "functionsAdminPage.php";

//Session to check if you are logged in
session_start();
if (empty($_SESSION['loggedin'])) {
    header('Location: Login.php');
    exit;
}

//connect to the database
$db = connectDatabase();

//creates the function array_key_first if the server runs a php version that doesn't support it
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

if (isset($_POST['createAccount'])) {
    //checks if the user is trying to add a new admin-account
    createUser($db);
}

if (isset($_POST['deleteUser'])) {
    //checks if the user is trying to delete a user
    deleteUser($db);
}

if (isset($_POST['deleteCompetition'])) {
    //checks if the user is trying to delete a competition
    deleteCompetition($db);
}

if (isset($_POST['createCompetition'])) {
    //checks if the user is trying to create a competition
    createCompetition($db);
}
if (isset($_POST['addOpenHours'])) {
    //checks if the user is trying to add open hours
    addOpenhours($db);
}

if (isset($_POST['deleteOpenHours'])) {
    //checks if the user is trying to delete open hours
    deleteOpenHours($db);
}
if (isset($_POST['addQrCode'])) {
    //checks if the user is trying to add a qr code
    addQrCode($db);
}

if (isset($_POST['deleteQr'])) {
    //checks if the user is trying to delete a qr code
    deleteQr($db);
}

if (isset($_POST['deleteQrData'])) {
    //checks if the user is trying to delete gr data
    deleteQrData($db);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpage.css">
    <title>Admin main</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navcontent">
                <li><a class="btn adminbtn" href="AdminPage.php">Admin</a></li>
                <li><a class="btn" href="Sponsors.php">Sponsorer</a></li>
                <li><a class="btn" href="Addcompany.php">Utställare</a></li>
            </div>
        </nav>
    </header>
    <main>
        <?php
        //session to create alerts on actions
        if (isset($_SESSION['alertError'])) {
            if (isset($_SESSION["alertError"])) {
                $error = $_SESSION["alertError"];
            } else {
                $error = "";
            }

            echo "<div class='error-msg'>
                <i class='fa fa-times-circle'></i>
                $error
                </div>";
        } elseif (isset($_SESSION['alertSuccess'])) {
            if (isset($_SESSION["alertSuccess"])) {
                $success = $_SESSION["alertSuccess"];
            } else {
                $success = "";
            }

            echo "<div class='success-msg'>
                <i class='fa fa-check'></i>
                $success
                </div>";
        }

        ?>
        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Tävlingsägare:</th>
                            <th>Länk till tävling:</th>
                            <th>Ta bort:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        competitionList($db);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="inputbox">
                <form method="POST">
                    <select name="companies" class="selectCompany">
                        <?php
                        selectCompany($db);
                        ?>
                    </select><br>
                    <input type="url" id="formUrl" name="formUrl" placeholder="Länk till ny tävling" maxlength="500" autocomplete="off"><br>
                    <button name="createCompetition" type="submit">Lägg till</button>
                </form>
            </div>
        </div>

        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Användarnamn:</th>
                            <th>Ta bort:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        userList($db);
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="inputbox">
                <Form method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" autocomplete="off"><br>
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="off"><br>
                    <button name="createAccount" type="submit">Create Account</button>
                </Form>
            </div>
        </div>

        <div class="contentbox">

            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Qr-kod:</th>
                            <th>Länkad sida:</th>
                            <th>QR koden:</th>
                            <th>Ta bort qr-kod:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <script>
                            function deleteQRcode(id) {
                                return (confirm("Vill du radera Qr-koden och all data som hör till den?"));
                            }
                        </script>
                        <?php
                        //creates sql & creates a list with the different qr-codes that exist
                        $sql = "SELECT * FROM qrcodes";

                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute([]);

                        while ($row = $stmt->fetch()) {
                            $filename = "qrcodes/" . $row['qrName'] . ".png";


                            echo "<tr>
                    <td>$row[qrName]</td>
                    <td>$row[Url]</td>
                    <td><a href='$filename' download><img src='$filename' alt='$filename' width='100' height='100'></a></td>
                    <td>
                    <form method='post' onsubmit='return deleteQRcode($row[id])'><input type='submit' name='deleteQr[$row[id]]'  value='Ta bort'></form>
                    </td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="inputbox">
                <form method="POST">
                    <input type="text" id="qrName" name="qrName" placeholder="Namn på qr-kod" autocomplete="off"><br>
                    <input type="url" id="qrUrl" name="qrUrl" placeholder="Länk till qr-kod" autocomplete="off"><br>
                    <button type="submit" name="addQrCode">Lägg till</button>
                </form>
            </div>
        </div>

        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Scannad kod:</th>
                            <th>När koden scannats:</th>
                            <th>Scannad av:</th>
                            <th>Ta bort post:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //creates sql & creates a list with qr-scan data.
                        $sql = "SELECT qrcodes.qrName, qrscan.dateTime, qrscan.device, qrscan.qrId, qrscan.id AS scanId
                FROM qrScan
                INNER JOIN qrcodes ON qrScan.qrId=qrcodes.id
                ORDER BY qrscan.device, qrscan.dateTime;";

                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute([]);

                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                    <td>$row[qrName]</td>
                    <td>$row[dateTime]</td>
                    <td>$row[device]</td>
                    <td>
                    <form method='post'><input type='submit' name='deleteQrData[$row[scanId]]' value='Ta bort'></form>
                    </td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>enhet:</th>
                            <th>antal scanningar:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //creates sql & creates a list with qr-scan data.
                        $sql = "SELECT `device`, COUNT(*) AS `count` 
                FROM qrscan
                GROUP BY `device`;";

                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute([]);

                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                    <td>$row[device]</td>
                    <td>$row[count]</td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Namn:</th>
                            <th>antal scanningar:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //creates sql & creates a list with qr-scan data.
                        $sql = "SELECT qrcodes.qrName, COUNT(*) AS `count`
                FROM qrScan
                INNER JOIN qrcodes ON qrscan.qrId=qrcodes.id GROUP BY qrId";

                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute([]);

                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                    <td>$row[qrName]</td>
                    <td>$row[count]</td>
                    </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Öppettider:</th>
                            <th>Datum:</th>
                            <th>Ta bort:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //creates sql & creates a list with the different qr-codes that exist
                        $sqlOpenHours = "SELECT * FROM openhours";

                        $stmtOpenHours = $db->prepare($sqlOpenHours);
                        $stmtOpenHours->execute([]);

                        while ($row = $stmtOpenHours->fetch()) {
                            echo "<tr>
                    <td>$row[openHours]</td>
                    <td>$row[openDates]</td>
                    <td>
                        <form method='post'><input type='submit' name='deleteOpenHours[$row[id]]' value='Ta bort'></form>
                    </td>
                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="inputbox">
                <form method="POST">
                    <input type="text" id="openHours" name="openHours" placeholder="Öppettider" autocomplete="off"><br>
                    <input type="text" id="openDates" name="openDates" placeholder="Datum" autocomplete="off"><br>
                    <button type="submit" Name="addOpenHours">Lägg till</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
