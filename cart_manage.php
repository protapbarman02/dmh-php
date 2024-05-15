<?php
require("includes/db.inc.php");
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if all necessary parameters are set
  if (isset($_POST["qty"]) && isset($_POST["cart_id"])) {
    $patient_id = $_SESSION['uid'];

    // Retrieve the values from the POST data
    $qty = $_POST["qty"];
    $c_id = $_POST["cart_id"];

    $updateSql = "UPDATE cart SET c_qty = $qty, c_added_at =CURRENT_TIMESTAMP() WHERE p_id = $patient_id AND c_id = $c_id";
    $con->query($updateSql);

    echo "success";
  } else {
    echo "internal_error";
    // If any of the parameters are missing, return an error message
  }
} else {
  // If the request is not a POST request, return an error message
  echo "method_rror";
}
