<!--Used the starter code oracle test as a base for this gui -->

<html>
    <head>
        <title>Intake and adoption page</title>
        <style>
            <?php include 'style.css'; ?>
        </style>
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Judson:400,700" rel="stylesheet">
    </head>

    <body>
        <h1>Intake and Adoption</h1>
        <h2 id="add">Add an animal to the system</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertAnimalQueryRequest" name="insertAnimalQueryRequest">
            PetID: <input type="text" name="insPetID"> <br /><br />
            Animal Name: <input type="text" name="insAnimalName"> <br /><br />
            Animal Type: <input type="text" name="insAnimalType"> <br /><br />
            Age: <input type="text" name="insAge"> <br /><br />
            Favourite Caretaker ID: <input type="text" name="insFavCare"> <br /><br />
            Previous Owner ID: <input type="text" name="insPrevOwner"> <br /><br />
            Time in Shelter: <input type="text" name="insTimeIn"> <br /><br />
            Adopter ID: <input type="text" name="insAdopterID"> <br /><br />

            <input type="submit" value="Insert" name="insertAnimalSubmit"></p>
        </form>

        <h2 id="remove">Remove an animal from the system</h2>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteAnimalQueryRequest" name="deleteAnimalQueryRequest">
            Pet ID: <input type="text" name="delPetID"> <br /><br />
            <input type="submit" value="Delete" name="deleteAnimalSubmit"></p>
        </form>

        <h2 id="update">Update animal information</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
        <form method="POST" action="intake_and_adoption.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateAnimalQueryRequest" name="updateAnimalQueryRequest">
            Pet ID: <input type="text" name="upPetID"> <br /><br />
            Age: <input type="text" name="upAge"> <br /><br />
            Favourite Caretaker ID: <input type="text" name="upFavCare"> <br /><br />
            Time in Shelter: <input type="text" name="upTimeIn"> <br /><br />
            Adopter ID: <input type="text" name="upAdopterID"> <br /><br />

            <input type="submit" value="Update" name="updateAnimalSubmit"></p>
        </form>
	</body>

    <?php
        include 'database_and_queries.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            handlePOSTRequest();  // Call the function to handle POST requests
        }
    ?>
</html>

