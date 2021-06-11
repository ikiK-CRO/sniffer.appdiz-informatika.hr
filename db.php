<?php

$con = mysqli_connect("localhost", "appdizinformatik_sniffer", "M7bNwsIMRJ8K", "appdizinformatik_sniffer");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
