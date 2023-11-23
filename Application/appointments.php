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
        <h1>Appointment Management</h1>
        <h2>Create a new appointment</h2>
        <form method="POST" action="appointments.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertApptQueryRequest" name="insertApptQueryRequest">
            Pet ID: <input type="text" name="insPetID"> <br /><br />
            Caretaker ID: <input type="text" name="insCaretakerID"> <br /><br />
            Customer ID: <input type="text" name="insCustomerID"> <br /><br />
            Appointment Date: <input type="text" name="insAppointDate"> <br /><br />
            Appointment Time: <input type="text" name="insAppointTime"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form> 

        <h2>Remove an existing appointment</h2>
        <form method="POST" action="appointments.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteApptQueryRequest" name="deleteApptQueryRequest">
            Pet ID: <input type="text" name="delPetID"> <br /><br />
            Caretaker ID: <input type="text" name="delCaretakerID"> <br /><br />
            Customer ID: <input type="text" name="delCustomerID"> <br /><br />
            Appointment Date: <input type="text" name="delAppointDate"> <br /><br />
            Appointment Time: <input type="text" name="delAppointTime"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>
	</body>

    <?php
        include 'database_and_queries.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            handlePOSTRequest();  // Call the function to handle POST requests
        }
    ?>
</html>


