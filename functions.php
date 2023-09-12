<?php

function esc($value)
{
    global $conn;
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $val);
    $val = strip_tags($val);
    return $val;
}
