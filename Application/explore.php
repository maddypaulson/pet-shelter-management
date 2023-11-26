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
        <h1>Explore</h1>
        <h2 id="groupBy">GROUP BY: Count how many animals of each type we have in pet shelter</h2>
        <form method="GET" action="search.php"> <!-- refresh page when submitted -->
            <input type="hidden" id="groupByQueryRequest" name="groupByQueryRequest">
            Type of animal: <input type="text" name="animalType"> <br /><br />
            <input type="submit" name="groupBySubmit">
        </form>
        <h2 id="having">Aggregation with HAVING: Find fundraiser event types with specified average donation goal or above</h2>
        <form method="GET" action="search.php"> <!-- refresh page when submitted -->
            <input type="hidden" id="havingQueryRequest" name="havingQueryRequest">
            Average Donation Goal Value: <input type="text" name="havingAvgDonationGoalThreshold"> <br /><br />
            <input type="submit" name="havingSubmit">
        </form>

        <h2 id="division">DIVISION: Find adopters who adopted all types of animals</h2>
        <form method="GET" action="search.php"> <!-- refresh page when submitted -->
            <input type="hidden" id="divisionQueryRequest" name="divisionQueryRequest">
            <input type="submit" name="divisionSubmit">
        </form>
	</body>
</html>
