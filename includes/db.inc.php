<?php session_start();
$con = mysqli_connect("localhost", "root", "", "diagnostics_and_medicine_hub");
if (!$con) {
    echo mysqli_connect_error();
    die();
}
