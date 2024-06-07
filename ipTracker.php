<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Tracker</title>
</head>
<body>
    <form action="ipTracker.php" method="post">
        <label for="ip">Enter IP address:</label>    
        <input type="text" name="ip">
        <input type="submit">
    </form>

    <?php
    $api_key = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["ip"])) {
        $ip = $_POST["ip"];
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=$api_key&ip=$ip";

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'GET'
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo "<p>There was an error processing your request.</p>";
        } else {
            $arr = json_decode($result, true);
            echo "<h1>IP Information</h1>";
            printData(
                $arr["ip"], 
                $arr["country_name"], 
                $arr["state_prov"], 
                $arr["city"], 
                $arr["isp"], 
                $arr["organization"], 
                $arr["latitude"], 
                $arr["longitude"]
            );
        }
    }

    function printData($ip, $country_name, $state_prov, $city, $isp, $organization, $latitude, $longitude) {
        echo "<br>Your IP: " . htmlspecialchars($ip);
        echo "<br>Your Country: " . htmlspecialchars($country_name);
        echo "<br>Your State: " . htmlspecialchars($state_prov);
        echo "<br>Your City: " . htmlspecialchars($city);
        echo "<br>Your ISP: " . htmlspecialchars($isp);
        echo "<br>Your Organization: " . htmlspecialchars($organization);
        echo "<br>Your Latitude: " . htmlspecialchars($latitude);
        echo "<br>Your Longitude: " . htmlspecialchars($longitude);
    }
    ?>
</body>
</html>
