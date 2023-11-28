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
            <a href="intake_and_adoption.php#add">
                <button class="add-animal-btn">Add an animal to the system</button>
            </a>

            <a href="intake_and_adoption.php#remove">
                <button class="add-animal-btn">Remove an animal from the system</button>
            </a>

            <a href="intake_and_adoption.php#update">
                <button class="add-animal-btn">Update animal information</button>
            </a>
        </div>
        <div class="card">
            <div class="circle-icon-container">
                <div class="circle-icon icon2"></div>
                <h2>Seek</h2>
            </div>
            <a href="seek.php#selection">
                <button class="add-animal-btn">Selection Query</button>
            </a>
            <a href="seek.php#join">
                <button class="add-animal-btn">Join Query</button>
            </a>

        </div>
        <div class="card">
            <div class="circle-icon-container">
                <div class="circle-icon icon3"></div>
                <h2>Search</h2>
            </div>
            <a href="search.php#projection">
                <button class="add-animal-btn">Projection Query</button>
            </a>
            <a href="explore.php#groupBy">
                <button class="add-animal-btn">Group By Query</button>
            </a>
        </div>
        <div class="card">
            <div class="circle-icon-container">
                <div class="circle-icon icon4"></div>
                <h2>Explore</h2>
            </div>
            <a href="explore.php#having">
                <button class="add-animal-btn">Having Query</button>
            </a>
            <a href="explore.php">
                <button class="add-animal-btn">Nested Group by Query</button>
            </a>
            <a href="explore.php#division">
                <button class="add-animal-btn">Division Query</button>
            </a>
        </div>
    </div>
</body>
</html>
