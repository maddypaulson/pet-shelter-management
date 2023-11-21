<!--Used the starter code oracle test as a base for this gui -->

<html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
        <style>
            <?php include 'style.css'; ?>
        </style>
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Judson:400,700" rel="stylesheet">
    </head>

    <body>
        <h1>Animal Shelter Home</h1>
        <div class="square-container">
            <div class="card">
                <div class="circle-icon-container">
                    <div class="circle-icon icon1"></div>
                    <h2>Animals</h2>
                </div>
                <a href="intake_and_adoption.php">
                    <button class="add-animal-btn">Add an animal to the system</button>
                </a>

                <a href="intake_and_adoption.php">
                    <button class="add-animal-btn">Remove an animal from the system</button>
                </a>

                <a href="intake_and_adoption.php">
                    <button class="add-animal-btn">Update animal information</button>
                </a>
            </div>
            <div class="card">
                <div class="circle-icon-container">
                    <div class="circle-icon icon2"></div>
                    <h2>Appointments</h2>
                </div>
                <a href="appointments.php">
                    <button class="add-animal-btn">Create a new appointment</button>
                </a>

                <a href="appointments.php">
                    <button class="add-animal-btn">Remove an existing appointment</button>
                </a>

                <a href="appointments.php">
                    <button class="add-animal-btn">Update an existing appointment</button>
                </a>
            </div>
            <div class="card">
                <div class="circle-icon-container">
                    <div class="circle-icon icon3"></div>
                        <h2>Search</h2>
                </div>
                <a href="search.php">
                    <button class="add-animal-btn">Find an animal for adoption</button>
                </a>
                <a href="search.php">
                    <button class="add-animal-btn">Find all animals adopted by a certain adopter</button>
                </a>

                <a href="search.php">
                    <button class="add-animal-btn">Projection</button>
                </a>
            </div>
            <div class="card">
                <div class="circle-icon-container">
                    <div class="circle-icon icon4"></div>
                        <h2>Explore</h2>
                </div>
                <a href="search.php">
                    <button class="add-animal-btn">Group By</button>
                </a>

                <a href="search.php">
                    <button class="add-animal-btn">Having</button>
                </a>
                <a href="search.php">
                    <button class="add-animal-btn">Nested group by</button>
                </a>
                <a href="search.php">
                    <button class="add-animal-btn">Division</button>
                </a>
            </div>
        </div>
	<?php
	$success = True; //keep track of errors so it redirects the page only if there are no errors
      	$db_conn = NULL; // edit the login credentials in connectToDB()
		
        function connectToDB() {
            global $db_conn;

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
	?>
	</body>
</html>
