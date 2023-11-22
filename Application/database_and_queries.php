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
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

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
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
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

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_robinmth", "a80425994", "dbhost.students.cs.ubc.ca:1522/stu");

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

        $name = filter_var($_POST['insAnimalName'], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST['insAnimalType'], FILTER_SANITIZE_STRING);
        $age = filter_var($_POST['insAge'], FILTER_VALIDATE_INT);
        $care = filter_var($_POST['insFavCare'], FILTER_SANITIZE_STRING);
        $prev_owner = filter_var($_POST['insPrevOwner'], FILTER_VALIDATE_INT);
        $time = filter_var($_POST['insTimeIn'], FILTER_VALIDATE_INT);
        $adopter = filter_var($_POST['insAdopterID'], FILTER_VALIDATE_INT);

        if($name === false || $type === false || $age === false || $care === false || $prev_owner === false || $time === false || adopter === false){
            echo "Error: Invalid input provided, please try again.";
            return;
        }

        $tuple = array (
            ":bind1" => $name,
            ":bind2" => $type,
            ":bind3" => $age,
            ":bind4" => $care,
            ":bind5" => $prev_owner,
            ":bind6" => $time,
            ":bind7" => $adopter
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("INSERT INTO Animal (animalName, type, age, favouriteCaretaker, previousOwner, timeInShelter, adopterID) VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
        OCICommit($db_conn);
    }

    function handleAnimalDeleteRequest() {
        global $db_conn;

        $petID = filter_var($_POST['delPetID'], FILTER_VALIDATE_INT);

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

        //Q: do I need to delete from all these table or is this handled by script
        executePlainSQL("DELETE FROM VetAppointment WHERE petID = $petID");
        executePlainSQL("DELETE FROM Appointment WHERE petID = $petID");
        executePlainSQL("DELETE FROM Animal WHERE petID = $petID");
    
        OCICommit($db_conn);
    
        echo "Animal with ID $petID deleted successfully.";
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
    
    function isPetIDValid($petID) {
        global $db_conn;
    
        $query = "SELECT COUNT(*) FROM Animal WHERE petID = :bind1";
        $binds = array(":bind1" => $petID);
    
        $result = executeBoundSQL($query, array($binds));
    
        // If the count is greater than 0, the petID is valid
        return $result[0]['COUNT(*)'] > 0;
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