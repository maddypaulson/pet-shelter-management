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
        
        <h2>SELECTION: Find an animal for adoption based on animal type, age, or time in the shelter</h2>
        <form method="GET" action="search.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectionQueryRequest" name="selectionQueryRequest">
            Animal Type: <input type="text" name="selectionType"> <br /><br />
            Age: <input type="text" name="selectionAge"> <br /><br />
            Time in Shelter: <input type="text" name="selectionTimeIn"> <br /><br />

            <input type="submit" name="selectionSubmit"></p>
        </form>

        <h2>JOIN: Find all animals adopted by a person</h2>
        <form method="GET" action="search.php"> <!--refresh page when submitted-->
            <input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
            Adopter ID: <input type="text" name="selectionType"> <br /><br />
            <input type="submit" name="joinSubmit"></p>
        </form>
	</body>
</html>
