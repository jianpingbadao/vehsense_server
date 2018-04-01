<!DOCTYPE html>
<html>
<head>
    <title>VehSense</title>
</head>

<body>
    <h1 align="center">Welcome to VehSense!</h1>

    <?php
    include "utility.php";

    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
    } else {
        $uri = 'http://';
    }
    // $uri .= $_SERVER['HTTP_HOST'];

    date_default_timezone_set("America/New_York");
    echo "Current time (ET) is: " . date("h:i:sa"), "<br>";

    // echo exec('whoami');

    // exit;
    ?>
    <a href="EULA.html">End User Licence Agreement</a>

</body>
</html>
