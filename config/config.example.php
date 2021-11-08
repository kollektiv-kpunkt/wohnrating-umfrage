<?php

$config = [
  "appname" => "Wohnrating",
    "db" => [
        "host" => "",
        "user" => "",
        "pw" => "",
        "database" => ""
    ],
    "email" => [
      "user" => "",
      "pw" => "",
      "from" => ""
    ]
];

global $conn;
$conn = mysqli_connect($config["db"]["host"], $config["db"]["user"], $config["db"]["pw"], $config["db"]["database"]);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}