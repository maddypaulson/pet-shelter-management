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
        <h1>Intake and Adoption</h1>
        <h2>Add an animal to the system</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Pet ID: <input type="text" name="insPetID"> <br /><br />
            Animal Name: <input type="text" name="insAnimalName"> <br /><br />
            Animal Type: <input type="text" name="insAnimalType"> <br /><br />
            Age: <input type="text" name="insAge"> <br /><br />
            Favourite Caretaker ID: <input type="text" name="insFavCare"> <br /><br />
            Previous Owner ID: <input type="text" name="insPrevOwner"> <br /><br />
            Time in Shelter: <input type="text" name="insTimeIn"> <br /><br />
            Adopter ID: <input type="text" name="insAdopterID"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <h2>Remove an animal from the system</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Pet ID: <input type="text" name="delPetID"> <br /><br />
            Animal Name: <input type="text" name="delAnimalName"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <h2>Update animal information</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Pet ID: <input type="text" name="upPetID"> <br /><br />
            Age: <input type="text" name="upAge"> <br /><br />
            Favourite Caretaker ID: <input type="text" name="upFavCare"> <br /><br />
            Time in Shelter: <input type="text" name="upTimeIn"> <br /><br />
            Adopter ID: <input type="text" name="upAdopterID"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <h2>Add an adoption record</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Adoption ID: <input type="text" name="insAdoptionID"> <br /><br />
            Pet ID: <input type="text" name="insPetID"> <br /><br />
            Adopter ID: <input type="text" name="insAdopterID"> <br /><br />
            Caretaker ID: <input type="text" name="insCareID"> <br /><br />
            Adoption Date: <input type="text" name="insAdoptDate"> <br /><br />
            Notes: <input type="text" name="insNotes"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <h2>Remove an adoption record</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Adoption ID: <input type="text" name="delAdoptionID"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>
	</body>
</html>

