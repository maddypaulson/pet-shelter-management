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
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Pet ID: <input type="text" name="insPetID"> <br /><br />
            Caretaker ID: <input type="text" name="insCaretakerID"> <br /><br />
            Customer ID: <input type="text" name="insCustomerID"> <br /><br />
            Appointment Date: <input type="text" name="insAppointDate"> <br /><br />
            Appointment Time: <input type="text" name="insAppointTime"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form> 

        <h2>Remove an existing appointment</h2>
        <form method="POST" action="appointments.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Pet ID: <input type="text" name="delPetID"> <br /><br />
            Caretaker ID: <input type="text" name="delCaretakerID"> <br /><br />
            Customer ID: <input type="text" name="delCustomerID"> <br /><br />
            Appointment Date: <input type="text" name="delAppointDate"> <br /><br />
            Appointment Time: <input type="text" name="delAppointTime"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <h2>Update an existing appointment</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
        <form method="POST" action="appointments.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Pet ID: <input type="text" name="upPetID"> <br /><br />
            Caretaker ID: <input type="text" name="upCaretakerID"> <br /><br />
            Customer ID: <input type="text" name="upCustomerID"> <br /><br />
            Appointment Date: <input type="text" name="upAppointDate"> <br /><br />
            Appointment Time: <input type="text" name="upAppointTime"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <h2>Create a new vet appointment</h2>
        <form method="POST" action="appointments.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Date: <input type="text" name="insDate"> <br /><br />
            Time: <input type="text" name="insTime"> <br /><br />
            Vet License ID: <input type="text" name="insVetID"> <br /><br />
            Pet ID: <input type="text" name="insPetID"> <br /><br />
            Reason: <input type="text" name="insReason"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form> 


	</body>
</html>


