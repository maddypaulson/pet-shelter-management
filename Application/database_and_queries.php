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
            echo "<br>Operation successful<br>";
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
        $db_conn = OCILogon("ora_maddy02", "a36440824", "dbhost.students.cs.ubc.ca:1522/stu");

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

        $petID = filter_var($_POST['insPetID'], FILTER_VALIDATE_INT);
        $name = filter_var($_POST['insAnimalName'], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST['insAnimalType'], FILTER_SANITIZE_STRING);
        $age = ($_POST['insAge'] !== '') ? filter_var($_POST['insAge'], FILTER_VALIDATE_INT) : null;
        $care = ($_POST['insFavCare'] !== '') ? filter_var($_POST['insFavCare'], FILTER_SANITIZE_STRING) : null;
        $prev_owner = ($_POST['insPrevOwner'] !== '') ? filter_var($_POST['insPrevOwner'], FILTER_VALIDATE_INT) : null;
        $time = ($_POST['insTimeIn'] !== '') ? filter_var($_POST['insTimeIn'], FILTER_VALIDATE_INT) : null;
        $adopter = ($_POST['insAdopterID'] !== '') ? filter_var($_POST['insAdopterID'], FILTER_VALIDATE_INT) : null;
        
        if($petID === false){
            echo "Error: Invalid petID";
            return;
        } else if ($age === false){
            echo "Error: Invalid age";
            return;
        } else if ($care === false){
            echo "Error: Invalid caretaker ID";
            return;
        } else if ($prev_owner === false) {
            echo "Error: Invalid previous owner";
            return;
        } else if ($time === false) {
            echo "Error: Invalid time in shelter";
            return;
        } else if ($adopter === false) {
            echo "Error: Invalid adopter ID";
            return;            
        }

        $tuple = array (
            ":bind1" => $petID,
            ":bind2" => $name,
            ":bind3" => $type,
            ":bind4" => $age,
            ":bind5" => $care,
            ":bind6" => $prev_owner,
            ":bind7" => $time,
            ":bind8" => $adopter
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("INSERT INTO Animal VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
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

        executeBoundSQL("DELETE FROM Animal WHERE petID = :bind1", $alltuples);

        OCICommit($db_conn);

    }

    function handleAnimalUpdateRequest() {
        global $db_conn;
    
        // Sanitize and validate user input
        $petID = filter_var($_POST['upPetID'], FILTER_VALIDATE_INT);
        $age = filter_var($_POST['upAge'], FILTER_VALIDATE_INT);
        $favCare = filter_var($_POST['upFavCare'], FILTER_SANITIZE_STRING);
        $timeIn = filter_var($_POST['upTimeIn'], FILTER_VALIDATE_INT);
        $adopterID = filter_var($_POST['upAdopterID'], FILTER_VALIDATE_INT);
    
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
    
        // Prepare the update query with bind variables
        $query = "UPDATE Animal SET ";
        $bindArray = array();
    
        if ($age !== false) {
            $query .= "age = :age, ";
            $bindArray[":age"] = $age;
        }
        if ($favCare !== false) {
            $query .= "favouriteCaretaker = :favCare, ";
            $bindArray[":favCare"] = $favCare;
        }
        if ($timeIn !== false) {
            $query .= "timeInShelter = :timeIn, ";
            $bindArray[":timeIn"] = $timeIn;
        }
        if ($adopterID !== false) {
            $query .= "adopterID = :adopterID, ";
            $bindArray[":adopterID"] = $adopterID;
        }
    
        $query = rtrim($query, ", ") . " WHERE petID = :petID";
        $bindArray[":petID"] = $petID;
  
        executeBoundSQL($query, $bindArray);
        OCICommit($db_conn);
    
        echo "Animal information updated successfully.";
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

    function handleJoinRequest(){
        global $db_conn;

        
        OCICommit($db_conn);
    }

    function handleGroupByRequest($animalType){
        global $db_conn;

        // sanitize user input
        $type = filter_var($animalType, FILTER_SANITIZE_STRING);

        // check if the provided animalType exists in the Animal table
        if (!isAnimalTypeValid($type)) {
            echo "Error: Animal with type $type is not found.";
            return;
        }

        $query = "SELECT type, COUNT(*) as typeCount FROM Animal WHERE type = :animalType GROUP BY type";

        $binds = array(":animalType" => $type);
        $result = executeBoundSQL($query, array($binds));

        echo "<h3> Animal Count for Type: $type </h3>";
        echo "<table>";
        echo "<tr><th>Animal Type</th><th>Count</th></tr>";

        foreach ($result as $row) {
            echo "<tr><td>" . $row["TYPE"] . "</td><td>" . $row["TYPECOUNT"] . "</td></tr>";
        }

        echo "</table>";
        OCICommit($db_conn);
    }
    
    function handleProjectionRequest($selectedAttributes) {
        global $db_conn;
    
        $animalsAttributes = array();
    
        foreach ($selectedAttributes as $attribute) {
            // sanitize user input
            $animalAttribute = filter_var($attribute, FILTER_SANITIZE_STRING);
            
            // validate user input
            if ($animalAttribute === false) {
                echo "Error: Invalid input for". $attribute;
                return;
            } 
            else {
                $animalAttributes[] = $animalAttribute;
            }
        }
    
        $selectAttributes = implode(", ", $sanitizedAttributes);
        $query = "SELECT $selectAttributes FROM Animal";
    
        $result = executePlainSQL($query);
    
        echo "<h3>Selected Attributes from Animal Table</h3>";
        echo "<table>";
        
        echo "<tr>";
        foreach ($animalAttributes as $attribute) {
            echo "<th>$attribute</th>";
        }
        echo "</tr>";
    
        foreach ($result as $row) {
            echo "<tr>";
            foreach ($animalAttributes as $attribute) {
                echo "<td>" . $row[$attribute] . "</td>";
            }
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
            }

            disconnectFromDB();
        }
    }
?>