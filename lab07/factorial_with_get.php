<body>
    <?php
        include("mathfunctions.php");
    ?>
    <h1>Creating Web Applications - Lab 7</h1>
    <?php
        if (isset($_GET["number"])) {
            $num = $_GET["number"];
            if (isPositiveInteger($num)) {
                echo "<p>", $num, "! is ", factorial($num), ".</p>";
            }
        }
        echo "<p><a href='factorial.html'>Return to the Entry Page</a></p>";
    ?>
</body>