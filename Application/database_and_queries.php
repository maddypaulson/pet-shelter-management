<?php
    /* DATABASE MANAGEMENT FUNCTIONS */
    
    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    function debugAlertMessage($message) {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        } else {
            // Operation was successful
            if($success){
                echo "<h3>Operation successful<h3>";
            }
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list) {
        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);
    
        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }
    
        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                OCIBindByName($statement, $bind, $val);
                unset($val);
            }
    
            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement);
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
                // If one execution fails, stop processing further and exit the loop
                break;
            }
        }
    
        // Display success message only if all commands were successful
        if ($success) {
            echo "<h3>Operation successful<h3>";
        }
    }

    function printResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table demoTable:<br>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function connectToDB() {
        global $db_conn;

        debugAlertMessage("test");

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_ubovict", "a77903797", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB() {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    /* QUERIES */
 
    function handleAnimalInsertRequest() {
        global $db_conn;
    
        /* Sanitize data */
        $name = filter_var($_POST['insAnimalName'], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST['insAnimalType'], FILTER_SANITIZE_STRING);
        $age = ($_POST['insAge'] !== '') ? filter_var($_POST['insAge'], FILTER_VALIDATE_INT) : null;
        $care = ($_POST['insFavCare'] !== '') ? filter_var($_POST['insFavCare'], FILTER_SANITIZE_STRING) : null;
        $prev_owner = ($_POST['insPrevOwner'] !== '') ? filter_var($_POST['insPrevOwner'], FILTER_VALIDATE_INT) : null;
        $arrivalYear = filter_var($_POST['arrivalYear'], FILTER_VALIDATE_INT);
        $arrivalMonth = filter_var($_POST['arrivalMonth'], FILTER_VALIDATE_INT);
        $arrivalDay = filter_var($_POST['arrivalDay'], FILTER_VALIDATE_INT);
        $adopter = ($_POST['insAdopterID'] !== '') ? filter_var($_POST['insAdopterID'], FILTER_VALIDATE_INT) : null;
    
        if ($name === false) {
            echo "Error: Invalid name";
            return;
        } elseif ($age === false || $age <= 0) {
            echo "Error: Invalid age";
            return;
        } elseif ($care === false) {
            echo "Error: Invalid caretaker ID";
            return;
        } elseif ($prev_owner === false) {
            echo "Error: Invalid previous owner";
            return;
        } elseif ($arrivalYear === false || $arrivalMonth === false || $arrivalDay === false) {
            echo "Error: Invalid arrival date";
            return;
        } elseif ($adopter === false) {
            echo "Error: Invalid adopter ID";
            return;
        }
    
        // Check caretaker ID
        if ($care !== null) {
            if (!checkForeignKey($care, "caretakerID", "AnimalCaretaker")) {
                echo "Error: Invalid caretaker ID";
                return;
            }
        }
    
        // Check customer ID
        if ($prev_owner !== null) {
            if (!checkForeignKey($prev_owner, "customerID", "Customer")) {
                echo "Error: Invalid customer ID";
                return;
            }
        }
    
        // Check adopter ID
        if ($adopter !== null) {
            if (!checkForeignKey($adopter, "adopterID", "Adopter")) {
                echo "Error: Invalid adopter ID";
                return;
            }
        }
    
        // Construct the Arrival Date in the format 'YYYY-MM-DD'
        $arrivalDate = sprintf("%04d-%02d-%02d", $arrivalYear, $arrivalMonth, $arrivalDay);

    
        $tuple = array(
            ":bind1" => $name,
            ":bind2" => $type,
            ":bind3" => $age,
            ":bind4" => $care,
            ":bind5" => $prev_owner,
            ":bind6" => $arrivalDate,
            ":bind7" => $adopter
        );
    
        $alltuples = array(
            $tuple
        );
    
        executeBoundSQL("INSERT INTO Animal (animalName, type, age, favouriteCaretaker, previousOwner, arrivalDate, adopterID) VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, TO_DATE(:bind6, 'YYYY-MM-DD'), :bind7)", $alltuples);
        OCICommit($db_conn);
    }
    

    function handleAnimalDeleteRequest() {
        global $db_conn;

        $petID = filter_var($_POST['delPetID'], FILTER_VALIDATE_INT);

        if($petID === false){
            echo "Error: Invalid input for Pet ID.";
            return;
        }

        if (!isPetIDValid($petID)) {
            echo "Error: Pet with ID $petID not found.";
            return;
        }

        $tuple = array (
            ":bind1" => $_POST['delPetID']
        );
        
        $alltuples = array (
            $tuple
        );

        executeBoundSQL("DELETE FROM PetAdopter WHERE petID = :bind1", $alltuples);
        executeBoundSQL("DELETE FROM Appointment WHERE petID = :bind1", $alltuples);
        executeBoundSQL("DELETE FROM Animal WHERE petID = :bind1", $alltuples);

        OCICommit($db_conn);

    }

    function handleAnimalUpdateRequest() {
        global $db_conn;

        $petID = filter_var($_POST['upPetID'], FILTER_VALIDATE_INT);
        $age = ($_POST['upAge'] !== '') ? filter_var($_POST['upAge'], FILTER_VALIDATE_INT) : null;
        $care = ($_POST['upFavCare'] !== '') ? filter_var($_POST['upFavCare'], FILTER_SANITIZE_STRING) : null;
        $adopter = ($_POST['upAdopterID'] !== '') ? filter_var($_POST['upAdopterID'], FILTER_VALIDATE_INT) : null;

        if($petID === false){
            echo "Error: Invalid input for Pet ID.";
            return;
        }

        if (!isPetIDValid($petID)) {
            echo "Error: Pet with ID $petID not found.";
            return;
        }

        if ($care !== null) {
            if (!checkForeignKey($care, "caretakerID", "AnimalCaretaker")) {
                echo "Error: Invalid caretaker ID";
                return;
            }
            executePlainSQL("UPDATE Animal SET favouriteCaretaker='" . $care . "' WHERE petID='" . $petID . "'");
        }

        if ($adopter !== null) {
            if (!checkForeignKey($adopter, "adopterID", "Adopter")) {
                echo "Error: Invalid adopter ID";
                return;
            }
            executePlainSQL("UPDATE Animal SET adopterID='" . $adopter . "' WHERE petID='" . $petID . "'");
        }

        if($age !== null){
            executePlainSQL("UPDATE Animal SET age='" . $age . "' WHERE petID='" . $petID . "'");
        }
        
        OCICommit($db_conn);
    }
    
    
    //Similar to the execute bound SQL function/
    function isPetIDValid($petID) {
        global $db_conn, $success;
    
        // Use prepared statement to prevent SQL injection
        $query = "SELECT COUNT(*) AS count FROM Animal WHERE petID = :bind1";
        $binds = array(":bind1" => $petID);
    
        $statement = OCIParse($db_conn, $query);
    
        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $query . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }
    
        foreach ($binds as $bind => $val) {
            OCIBindByName($statement, $bind, $val);
            unset($val);
        }
    
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $query . "<br>";
            $e = OCI_Error($statement);
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    
        // Fetch the result
        $result = OCI_Fetch_Array($statement, OCI_ASSOC);
    
        // Check the count from the result
        return $result['COUNT'] > 0;
    }

    //Similar to the execute bound SQL function
    function checkForeignKey($foreign_key, $attribute_name, $table) {
        global $db_conn, $success;
    
        // Use prepared statement to prevent SQL injection
        $query = "SELECT COUNT(*) AS count FROM $table WHERE $attribute_name = :bind1";
        $binds = array(":bind1" => $foreign_key);
    
        $statement = OCIParse($db_conn, $query);
    
        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $query . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }
    
        foreach ($binds as $bind => $val) {
            OCIBindByName($statement, $bind, $val);
            unset($val);
        }
    
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $query . "<br>";
            $e = OCI_Error($statement);
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    
        // Fetch the result
        $result = OCI_Fetch_Array($statement, OCI_ASSOC);
    
        // Check the count from the result
        return $result['COUNT'] > 0;
    }
    
    function handleAppointmentInsertRequest() {
        global $db_conn;

        $petID = filter_var($_POST['insAnimalName'], FILTER_VALIDATE_INT);
        $careTakerID = filter_var($_POST['insAnimalType'], FILTER_VALIDATE_INT);
        $customerID = filter_var($_POST['insAge'], FILTER_VALIDATE_INT);
        $date = filter_var($_POST['insFavCare'], FILTER_SANITIZE_STRING);
        $time = filter_var($_POST['insPrevOwner'], FILTER_SANITIZE_STRING);

        // Validate petID
        if ($petID === false) {
            echo "Error: Invalid input for Pet ID.";
            return;
        }
    
        // Check if the provided petID exists in the Animal table
        if (!isPetIDValid($petID)) {
            echo "Error: Pet with ID $petID not found.";
            return;
        }

        if($careTakerID === false || $customerID === false || $date === false || $time === false){
            echo "Error: Invalid input provided, please try again.";
            return;
        }

        $tuple = array (
            ":bind1" => $petID,
            ":bind2" => $careTakerID,
            ":bind3" => $customerID,
            ":bind4" => $date,
            ":bind5" => $time
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("INSERT INTO Appointment (petID, caretakerID, customerID, apptDate, apptTime) VALUES (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
        OCICommit($db_conn);
    }

    function handleAppointmentDeleteRequest() {
        global $db_conn;

        $petID = filter_var($_POST['insAnimalName'], FILTER_VALIDATE_INT);
        $careTakerID = filter_var($_POST['insAnimalType'], FILTER_VALIDATE_INT);
        $customerID = filter_var($_POST['insAge'], FILTER_VALIDATE_INT);
        $date = filter_var($_POST['insFavCare'], FILTER_SANITIZE_STRING);
        $time = filter_var($_POST['insPrevOwner'], FILTER_SANITIZE_STRING);

        // Validate petID
        if ($petID === false) {
            echo "Error: Invalid input for Pet ID.";
            return;
        }
    
        // Check if the provided petID exists in the Animal table
        if (!isPetIDValid($petID)) {
            echo "Error: Pet with ID $petID not found.";
            return;
        }

        //TO DO: VERIFY THAT THE APPOINTMENT EXISTS

        executePlainSQL("DELETE FROM Appointment WHERE petID = $petID AND caretakerID = $careTakerID AND customerID = $customerID AND apptDate = $date AND apptTime = $time");
    
        OCICommit($db_conn);
    
        echo "Appointment on $date at $time for animal with ID $petID deleted successfully.";
    }

    function handleSelectionRequest() {
        global $db_conn;
    
        $careID = ($_GET['selectionCareID'] !== '') ? filter_var($_GET['selectionCareID'], FILTER_VALIDATE_INT) : null;
        $careName = ($_GET['selectionName'] !== '') ? "'" . filter_var($_GET['selectionName'], FILTER_SANITIZE_STRING) . "'" : null;
        $fundraiserID = ($_GET['selectionFundEvent'] !== '') ? filter_var($_GET['selectionFundEvent'], FILTER_VALIDATE_INT) : null;
        $address = ($_GET['selectionAddress'] !== '') ? "'" . filter_var($_GET['selectionAddress'], FILTER_SANITIZE_STRING) . "'" : null;
        $postalCode = ($_GET['selectionPostal'] !== '') ? "'" . filter_var($_GET['selectionPostal'], FILTER_SANITIZE_STRING) . "'" : null;
    
        if ($careID === false) {
            echo "Error: Invalid caretaker ID";
            return;
        } elseif ($careName === false) {
            echo "Error: Invalid caretaker name";
            return;
        } elseif ($fundraiserID === false) {
            echo "Error: Invalid fundraiser ID";
            return;
        } elseif ($address === false) {
            echo "Error: Invalid address";
            return;
        } elseif ($postalCode === false) {
            echo "Error: Invalid postal code";
            return;
        }
    
        $query = "SELECT * FROM AnimalCaretaker WHERE ";
    
        $conditions = array();
        if ($careID !== null) {
            $conditions[] = "caretakerID = $careID";
        }
        if ($careName !== null) {
            $conditions[] = "caretakerName = $careName";
        }
        if ($fundraiserID !== null) {
            $conditions[] = "fundEventID = $fundraiserID";
        }
        if ($address !== null) {
            $conditions[] = "caretakerAddress = $address";
        }
        if ($postalCode !== null) {
            $conditions[] = "caretakerPostalCode = $postalCode";
        }
    
        $query .= implode(" AND ", $conditions);
    
        $result = executePlainSQL($query);

        echo "<h2>Search Results</h2>";
        echo "<table>";
        echo "<tr><th>Caretaker ID</th><th>Caretaker Name</th><th>Fundraiser ID</th><th>Address</th><th>Postal Code</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['CARETAKERID'] . "</td>";
            echo "<td>" . $row['CARETAKERNAME'] . "</td>";
            echo "<td>" . $row['FUNDEVENTID'] . "</td>";
            echo "<td>" . $row['CARETAKERADDRESS'] . "</td>";
            echo "<td>" . $row['CARETAKERPOSTALCODE'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        OCICommit($db_conn);
    }    

    function handleJoinRequest(){
        global $db_conn;
    
        $donation = ($_GET['donationAmount'] !== '') ? filter_var($_GET['donationAmount'], FILTER_VALIDATE_INT) : null;
        
        if($donation === false){
            echo "Error: Donation must be an integer value.";
            return;
        }
    
        $query = "SELECT Customer.customerName, Donation.amount FROM Customer
        JOIN Donation ON Customer.customerID = Donation.customerID
        WHERE Donation.amount > $donation";
    
        // Execute the query without binding
        $result = executePlainSQL($query);
    
        echo "<h1>Search Results</h1>";
        echo "<h2>Customers with Donations above $donation</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Customer Name</th><th>Donation Amount</th></tr>";
    
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['CUSTOMERNAME'] . "</td>";
            echo "<td>" . $row['AMOUNT'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    
        OCICommit($db_conn);
    }
    
    function handleProjectionRequest() {
        global $db_conn;
    
        // getting info which attribute checkboxes were selected when the query request is submitted
        $selectedAttributes = isset($_GET['projectionAttributes']) ? $_GET['projectionAttributes'] : array();
        $query = "SELECT ";


        if (in_array("petID", $selectedAttributes)) {
            // petID checkbox was selected
            $query .= implode($petID, ", ");
        }
        if (in_array("animalName", $selectedAttributes)) {
            // animalName checkbox was selected
            $query .= implode($animalName, ", ");
        }
        if (in_array("type", $selectedAttributes)) {
            // type checkbox was selected
            $query .= implode($type, ", ");
        }
        if (in_array("age", $selectedAttributes)) {
            // age checkbox was selected
            $query .= implode($age, ", ");
        }
        if (in_array("favouriteCaretaker", $selectedAttributes)) {
            // favouriteCaretaker checkbox was selected
            $query .= implode($favouriteCaretaker, ", ");
        }
        if (in_array("previousOwner", $selectedAttributes)) {
            // previousOwner checkbox was selected
            $query .= implode($previousOwner, ", ");
        }
        if (in_array("arrivalDate", $selectedAttributes)) {
            // arrivalDate checkbox was selected
            $query .= implode($arrivalDate, ", ");
        }
        if (in_array("adopterID", $selectedAttributes)) {
            // adopterID checkbox was selected
            $query .= implode($adopterID, ", ");
        }
    
        $query = rtrim($query, ", ") . " FROM Animal";
        
        $result = executePlainSQL($query);

        echo "<h2>Search Results</h2>";
        echo "<table>";
        
        $columnHeaders = !empty($selectedAttributes) ? $selectedAttributes : array("petID", "animalName", "type", "age", "favouriteCaretaker", "previousOwner", "arrivalDate", "adopterID");
        echo "<tr>";
        foreach ($columnHeaders as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            foreach ($columnHeaders as $header) {
                echo "<td>" . $row[$header] . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        OCICommit($db_conn);
    }


    function handleGroupByRequest(){
        global $db_conn;

        $animal_type = ($_GET['animalType'] !== '') ? "'" . filter_var($_GET['animalType'], FILTER_SANITIZE_STRING) . "'" : null;

        if ($type === false || $type === null) {
            echo "Error: Invalid animal type";
            return;
        }
    
        $query = "SELECT type, COUNT(*) as typeCount 
                FROM Animal 
                WHERE type = :animal_type
                GROUP BY type"; 

    
        $result = executePlainSQL($query);

        echo "<h2> Search Results</h2>";
        echo "<table>";
        echo "<tr><th>Animal Type</th><th>Count</th></tr>";

        while($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['TYPE'] . "</td>";
            echo "<td>" . $row['TYPECOUNT'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

        OCICommit($db_conn);
    }
    
    function handleNestedAggregationRequest() {
        global $db_conn;
    
        $donation = ($_GET['havingAvgDonationGoalThreshold'] !== '') ? filter_var($_GET['havingAvgDonationGoalThreshold'], FILTER_VALIDATE_INT) : null;

        if($donation === false){
            echo "Error: Average Donation Amount must be an integer value.";
            return;
        }
    
        $query = "SELECT FundraiserEvent.eventType, AVG(FundraiserEvent.donationGoal) AS avgDonationGoal 
        FROM FundraiserEvent
        GROUP BY eventType
        HAVING AVG(FundraiserEvent.donationGoal) >= :donation";

        $result = executePlainSQL($query);
    
        echo "<h2>Search Results</h2>";
        echo "<table>";
        echo "<tr><th>Event Type</th><th>Average Donation Amount</th></tr>";
    
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['EVENTTYPE'] . "</td>";
            echo "<td>" . $row['AVGDONATIONGOAL'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        OCICommit($db_conn);
    }
    
    function handleDivisionRequest() {
        global $db_conn;
    
        $query = "SELECT DISTINCT a.adopterID, a.adopterName
        FROM Adopter a
        WHERE NOT EXISTS ( 
            SELECT t.type
            FROM AnimalType t
            WHERE NOT EXISTS (
                SELECT aa.animalID
                FROM AnimalAdoption aa
                WHERE aa.adopterID = a.adopterID AND aa.type = t.type))";
    
        $result = executePlainSQL($query);
    
        echo "<h2>Search Results</h2>";
        echo "<table>";
        echo "<tr><th>Adopter ID</th><th>Adopter Name</th></tr>";
    
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['ADOPTERID'] . "</td>";
            echo "<td>" . $row['ADOPTERNAME'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    
        OCICommit($db_conn);
    }
    
    
    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('insertAnimalSubmit', $_POST)) {
                handleAnimalInsertRequest();
            } else if (array_key_exists('deleteAnimalSubmit', $_POST)) {
                handleAnimalDeleteRequest();
            } else if (array_key_exists('updateAnimalSubmit', $_POST)) {
                handleAnimalUpdateRequest();
            } else if (array_key_exists('insertApptQueryRequest', $_POST)) {
                handleAppointmentInsertRequest();
            } else if (array_key_exists('deleteApptQueryRequest', $_POST)) {
                handleAppointmentDeleteRequest();
            }
            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            } else if (array_key_exists('selectionSubmit', $_GET)) {
                handleSelectionRequest();
            } else if (array_key_exists('donationSubmit', $_GET)) {
                handleJoinRequest();
            } else if (array_key_exists('projectionSubmit', $_GET)) {
                handleProjectionRequest();
            } else if (array_key_exists('groupBySubmit', $_GET)) {
                handleGroupByRequest();
            } else if (array_key_exists('havingSubmit', $_GET)) {
                handleNestedAggregationRequest();
            } else if (array_key_exists('divisionSubmit', $_GET)) {
                handleDivisionRequest();
            } 

            disconnectFromDB();
        }
    }
?>