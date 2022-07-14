<?php
    // Paths
    $domain = "https://".$_SERVER["SERVER_NAME"];
    $folderPath = str_replace("index.php", "", $_SERVER['PHP_SELF']);
    $picturesDirectory = "img";

    // Use timestamp to get a different picture each second (another solution is to use rand())
    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    $pictures = scandir($picturesDirectory, 1);
    $picturesNumber = count($pictures) - 2;
    $picture = $pictures[$timestamp%$picturesNumber];

    // 🎵 Oh, ariá-raió Obá, Obá, Obá 🎵 ~ https://www.youtube.com/watch?v=Tfa6fRjPlUE
    $resourceURL = $domain.$folderPath.$picturesDirectory."/".($picture);
    $pathParts = pathinfo($resourceURL);
    $resource = fopen($resourceURL, "rb");

    // Set headers (don't cache resources!)
    header("Content-Type: image/".$pathParts['extension']);
    header("Content-Length: ".filesize($resourceURL));
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Return file
    fpassthru($resource);
    exit;