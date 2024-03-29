<?php
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

function deletePlace($db)
{
    //checks the id of the chosen place & replaces the companyid with null
    $deletePlace = array_key_first($_POST['deletePlace']);
    $sqlDeletePlace = "UPDATE placement
            SET companyId = NULL 
            WHERE id=$deletePlace";

    $stmtDeletePlace = $db->prepare($sqlDeletePlace);

    $stmtDeletePlace->execute();

    $_POST['deletePlace'] = "";
};

function deleteCompany($db)
{
    $deleteCompany = array_key_first($_POST['deleteCompany']);
    //creates sql to clear the companys placement & executes
    $sqlDeleteCPlace = "UPDATE placement
            SET companyId = NULL 
            WHERE companyId=$deleteCompany";

    $stmtDeleteCPlace = $db->prepare($sqlDeleteCPlace);

    $stmtDeleteCPlace->execute();

    //creates sql to delete the offers that belong to the selected company & executes
    $sqlDeleteOffer = "DELETE FROM offers WHERE companyId=$deleteCompany";

    $stmtDeleteOffer = $db->prepare($sqlDeleteOffer);
    $stmtDeleteOffer->execute();

    //creates sql to delete the competitions that belong to the selected company & executes
    $sqlDeleteCompetition = "DELETE FROM competitions WHERE companyId=$deleteCompany";

    $stmtDeleteCompetition = $db->prepare($sqlDeleteCompetition);
    $stmtDeleteCompetition->execute();

    //creates sql to delete the company from the database & executes
    $sqlDeleteCompany = "DELETE FROM company WHERE id=$deleteCompany;";

    $stmtDeleteCompany = $db->prepare($sqlDeleteCompany);

    $stmtDeleteCompany->execute();
    $_POST['deleteCompany'] = "";
}

function deleteOffer($db)
{
    //deletes the offer with the selected id
    $deleteOffer = array_key_first($_POST['deleteOffer']);
    $sqlDeleteOffer = "DELETE FROM offers WHERE id=$deleteOffer;";

    $stmtDeleteOffer = $db->prepare($sqlDeleteOffer);

    $stmtDeleteOffer->execute();
}

function checkDupesOffer($db)
{
    //creates sql used to check for already existing offers.
    $sqlNodupes = "SELECT * FROM offers";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //checks the offers table & compares the input to the already existing offers
    foreach ($rowNodupes as $names) {

        $arrayContent = ($names['offer'] . $names['companyId']);
        array_push($a, $arrayContent);
    };
    return $a;
}

function createOffer($db)
{
    //checks the users inputs & gives error message if the inputs are incorrect
    if (!isset($_POST['companies'])) {
        $_SESSION['alertError'] = "Välj ett företag";
        header("location:Addcompany.php");
        exit();
    } elseif (isset($_POST['companies']) && $_POST['companies'] != "") {
        //Checks all fields are filled in correctly
        if ($_POST['offerInfo'] == "") {
            $_SESSION['alertError'] = "Erbjudandebeskrivning saknas";
            header("location:Addcompany.php");
            exit();
        } elseif ($_POST['offerPrice'] < 0) {
            $_SESSION['alertError'] = "Priset kan inte vara mindre än 0";
            header("location:Addcompany.php");
            exit();
        } else {
            //assigns the inputs to different variables
            $chosenCompany = $_POST['companies'];
            $offerInfo = trim(htmlspecialchars($_POST['offerInfo']));
            $offerPrice = trim(htmlspecialchars($_POST['offerPrice']));
            $a = checkDupesOffer($db);
            $compareOffer = ($offerInfo . $chosenCompany);
            //Checks if the offer you want to add already exists, adds it if it doesn't
            if (in_array($compareOffer, $a)) {
                $_SESSION['alertError'] = "Erbjudandet finns redan";
                header("location:Addcompany.php");
                exit();
            } else {
                //creates sql to add the offer to the database & executes
                $sqlAddOffer = "INSERT INTO offers (companyId, offer, price)
                VALUES (:chosenCompany, :offerInfo, :offerPrice);";

                $stmtAddOffer = $db->prepare($sqlAddOffer);

                $stmtAddOffer->bindParam('chosenCompany', $chosenCompany, PDO::PARAM_STR);
                $stmtAddOffer->bindParam('offerInfo', $offerInfo, PDO::PARAM_STR);
                $stmtAddOffer->bindParam('offerPrice', $offerPrice, PDO::PARAM_INT);

                $stmtAddOffer->execute();

                $_SESSION['alertSuccess'] = "Erbjudandet har lagts till";
                header("location:Addcompany.php");
                exit();
            }
        }
    }
}

function checkDupes($db)
{
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM company;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //checks the company table & compares the input to the already existing companies
    foreach ($rowNodupes as $names) {

        $arrayContent = $names['name'];
        array_push($a, $arrayContent);
    };
    return $a;
}

function createCompany($db)
{
    //Checks if $_POST is set & adds the input to variables
    $companyName = trim(htmlspecialchars($_POST["companyName"]));
    $companyInfo = trim(htmlspecialchars($_POST["companyInfo"]));
    $externalUrl = $_POST["externalUrl"];
    $logoUrl = $_POST["logoUrl"];
    $foodCheck = $_POST['foodCheck'];
    $placement = $_POST['place'];

    $_SESSION['companyName'] = trim(htmlspecialchars($_POST["companyName"]));
    $_SESSION['companyInfo'] = trim(htmlspecialchars($_POST["companyInfo"]));
    $_SESSION['externalUrl'] = $_POST['externalUrl'];
    $_SESSION['logoUrl'] = $_POST['logoUrl'];
    $_SESSION['foodCheck'] = $_POST['foodCheck'];
    $_SESSION['place'] = $_POST['place'];
    //Checks all required fields are filled & inserts error message into alert.
    if ($_POST['companyName'] == "") {
        $_SESSION['alertError'] = "Företagsnamn saknas";
        header("location:Addcompany.php");
        exit();
    } elseif ($_POST['companyInfo'] == "") {
        $_SESSION['alertError'] = "Företagsinfo saknas";
        header("location:Addcompany.php");
        exit();
    } elseif ($_POST['logoUrl'] == "") {
        $_SESSION['alertError'] = "Logo saknas";
        header("location:Addcompany.php");
        exit();
    } elseif (isset($_POST['place']) && $_POST['place'] == "") {
        $_SESSION['alertError'] = "Inga montrar är valda";
        header("location:Addcompany.php");
        exit();
    } elseif (!isset($_POST['place'])) {
        $_SESSION['alertError'] = "Inga montrar är valda";
        header("location:Addcompany.php");
        exit();
    } else {
        $a = checkDupes($db);
        //Checks if the company you want to add already exists, adds it if it doesn't
        if (isset($companyName) && in_array($companyName, $a)) {
            $_SESSION['alertError'] = "Företaget finns redan";
            header("location:Addcompany.php");
            exit();
        } else {
            //prepares sql & binds params for adding a company
            $sql = "INSERT INTO company (name, companyInfo, externalUrl, logoUrl, foodCheck)
                VALUES (:companyName, :companyInfo, :externalUrl, :logoUrl, :foodCheck);";

            $stmt = $db->prepare($sql);

            $stmt->bindParam('companyName', $companyName, PDO::PARAM_STR);
            $stmt->bindParam('companyInfo', $companyInfo, PDO::PARAM_STR);
            $stmt->bindParam('externalUrl', $externalUrl, PDO::PARAM_STR);
            $stmt->bindParam('logoUrl', $logoUrl, PDO::PARAM_STR);
            $stmt->bindParam('foodCheck', $foodCheck, PDO::PARAM_STR);

            $stmt->execute();

            //creates sql for placements & adds the created company to the selected places
            $placementLength = count($placement);
            $sqlUpdatePlacement = "UPDATE placement
            SET companyId = (SELECT id FROM company WHERE NAME=:companyName)
            WHERE id=:placement;";
            $stmtPlacement = $db->prepare($sqlUpdatePlacement);
            $stmtPlacement->bindParam('companyName', $companyName, PDO::PARAM_STR);
            for ($i = 0; $i < $placementLength; $i++) {
                $stmtPlacement->bindParam('placement', $placement[$i], PDO::PARAM_INT);
                $stmtPlacement->execute();
            }
            $_SESSION['alertSuccess'] = "Företaget har lagts till";
            header("location:Addcompany.php");
            exit();
        }
    }
}

function selectPlacement($db, $placement)
{
    //prepares sql & binds params.
    $sqlPlacement = "SELECT * FROM placement ORDER BY id;";

    $placementStmt = $db->prepare($sqlPlacement);

    $placementStmt->execute([]);

    $row = $placementStmt->fetchAll();

    //loops the placement table & creates a checkbox list with all the showcases
    foreach ($row as $places) {
        if ($places['companyId'] == null && isset($_SESSION['alertError']) == false) {
            echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]'>$places[id]</div>");
        } elseif (isset($_SESSION['alertError']) == true && $places['companyId'] == null) {
            if (in_array($places['id'], $placement)) {
                echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]' checked>$places[id]</div>");
            } else {
                echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]'>$places[id]</div>");
            }
        } else {
            echo ("<div class='grid-item'><input type='checkbox' disabled>$places[id]</div>");
        }
    }
}


function offerList($db)
{
    //creates sql & creates a list with all existing offers.
    $sql = "SELECT company.name, offers.offer, offers.price, offers.id
    FROM offers
    INNER JOIN company ON offers.companyId=company.id
    ORDER BY companyId;";

    $stmt = $db->prepare($sql);
    $stmt->execute([]);

    while ($row = $stmt->fetch()) {
        echo "<tr>
        <td title='$row[name]'>$row[name]</td>
        <td title='$row[offer]'>$row[offer]</td>
        <td title='$row[price]'>$row[price]</td>
        <td>
        <form method='post'><input type='submit' name='deleteOffer[$row[id]]' value='ta bort'></form>
        </td>
        </tr>";
    }
}

function placementList($db)
{
    //creates sql & creates a list with all booked places.
    $sql = "SELECT placement.id, company.name, placement.companyId
    FROM placement
    INNER JOIN company ON placement.companyId=company.id
    ORDER BY company.id, placement.id;";

    $stmt = $db->prepare($sql);
    $stmt->execute([]);

    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td title='$row[id]'>$row[id]</td>
            <td title='$row[name]'>$row[name]</td>
            <td>
            <form method='post'><input type='submit' name='deletePlace[$row[id]]' value='töm'></form>
            </td>
            </tr>";
    }
}

function companyList($db)
{
    //creates sql & creates a list with all existing companies.
    $sql = "SELECT *
    FROM company";

    $stmt = $db->prepare($sql);
    $stmt->execute([]);

    while ($row = $stmt->fetch()) {
        echo "<tr>
        <td title='$row[name]'>$row[name]</td>
        <td title='$row[companyInfo]'>$row[companyInfo]</td>
        <td title='$row[externalUrl]'>$row[externalUrl]</td>
        <td title='$row[logoUrl]'>$row[logoUrl]</td>
        <td>
        <form method='post'><input type='submit' name='editCompany[$row[id]]' value='ändra'></form>
        </td>
        <td>
        <form method='post'><input type='submit' name='deleteCompany[$row[id]]' value='ta bort'></form>
        </td>
        </tr>";
    }
}

function selectCompany($db)
{
    //creates sql  & executes
    $sqlSelectCompany = "SELECT * FROM company ORDER BY id;";

    $stmtSelectCompany = $db->prepare($sqlSelectCompany);

    $stmtSelectCompany->execute([]);

    $row = $stmtSelectCompany->fetchAll();

    //loops the placement table & creates a checkbox list with all the showcases
    echo "<option value='' disabled selected>Företag</option>";
    foreach ($row as $companies) {
        echo "
    <option value='$companies[id]'>$companies[name]</option>";
    };
}
