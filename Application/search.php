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
        <h1>Search the Database</h1>
        <a href="home-page.php">
            <button class="return-home">Return to Home Page</button>
        </a>
        <h2 id="projection">PROJECTION: Choose which attributes you would like to see from Animals table</h2>
        <form method="POST" action="search.php"> <!-- refresh page when submitted -->
            <input type="checkbox" name="projectionAttributes[]" value="petID"> petID<br>
            <input type="checkbox" name="projectionAttributes[]" value="animalName"> animalName<br>
            <input type="checkbox" name="projectionAttributes[]" value="type"> type<br>
            <input type="checkbox" name="projectionAttributes[]" value="age"> age<br>
            <input type="checkbox" name="projectionAttributes[]" value="favouriteCaretaker"> Animal's Favorite Caretaker<br>
            <input type="checkbox" name="projectionAttributes[]" value="previousOwner"> Animal's Previous Owner<br>
            <input type="checkbox" name="projectionAttributes[]" value="arrivalDate"> Time Animal Spent in Shelter<br>
            <input type="checkbox" name="projectionAttributes[]" value="adopterID"> adopterId<br>
            
            <input type="submit" name="projectionSubmit" value="submit">
        </form>
	</body>
    <!-- call GET or POST function -->
    <?php
        include 'database_and_queries.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            handlePOSTRequest();
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            handleGETRequest();
        }
    ?>
</html>
