<?php
            $serverName = "172.22.0.12";
            $userName = "iaa_user";
            $passWord = 'Apin1402EagleFlight.';
            $dbName = "iaa";

            $conn = new mysqli($serverName, $userName, $passWord, $dbName);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        ?> 