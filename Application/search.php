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
        <h2 id="selection">SELECTION: Find a Caretaker</h2>
        <form method="GET" action="search.php">
            <input type="hidden" id="selectionQueryRequest" name="selectionQueryRequest">
            Caretaker ID: <input type="text" name="selectionCareID"> <br /><br />
            Caretaker Name: <input type="text" name="selectionName"> <br /><br />
            Fundraiser Event ID: <input type="text" name="selectionFundEvent"> <br /><br />
            Caretaker Address: <input type="text" name="selectionAddress"> <br /><br />
            Caretaker Postal Code: <input type="text" name="selectionPostal"> <br /><br />

            <input type="submit" name="selectionSubmit"></p>
        </form>

        <h2 id="join">JOIN: Find customers who made donations above a certain amount</h2>
        <form method="GET" action="search.php">
            <input type="hidden" id="donationQueryRequest" name="donationQueryRequest">
            Donation Amount: <input type="text" name="donationAmount"> <br /><br />
            <input type="submit" name="donationSubmit"></p>
        </form> 

        <h2 id="projection">PROJECTION: Choose which attributes you would like to see from Animals table</h2>
        <form method="GET" action="search.php"> <!-- refresh page when submitted -->
            <input type="hidden" id="projectionQueryRequest" name="projectionQueryRequest">
            Attributes you want to see: <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="petID"> petID</label><br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="animalName"> Animal Name</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="type"> Animal Type</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="age"> Animal Age</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="favouriteCaretaker"> Animal's Favorite Caretaker</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="previousOwner"> Animal's Previous Owner</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="arrivalDate"> Time Animal Spent in Shelter</label> <br /><br />
                <label><input type="checkbox" name="projectionAttributes[]" value="adopterID"> adopterId</label> <br /><br />
                </select><br /><br />
            <!--Select Attributes: <input type="text" name="projectionAttributes"> <br /><br />-->
            <input type="submit" name="projectionSubmit">
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
