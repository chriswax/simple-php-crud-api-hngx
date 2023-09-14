<?php
$DBhost = "db4free.net";
$DBuser = "chriswax";
$DBpassword = "password";
$DBname = "hngx";
$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
