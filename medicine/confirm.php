<?php $ROOT = '../';
require($ROOT . "includes/header.php");

if (isset($_SESSION['medicine']) && !empty($_SESSION['medicine'])) {
 if (!isset($_POST['default_address']) && !isset($_POST['new_address'])) {
  header("location:../mycart.php");
  exit();
 } else {
  $orderSuccess = 0;
  $orderDetailsSuccess = 0;
  $send_email_pdf = 0;
  if (isset($_POST['default_address'])) {
   $addr_res = mysqli_query($con, "select * from addr where user_type='patient' and user_id={$_SESSION['uid']} and addr_status=1");
   if (mysqli_num_rows($addr_res) <= 0) {
    header("location:checkout.php");
    exit();
   } else {
    while ($addr_row = mysqli_fetch_assoc($addr_res)) {
     $name = $addr_row['user_name'];
     $phn = $addr_row['addr_phn'];
     $email = mysqli_fetch_assoc(mysqli_query($con, "select p_email from patient where p_id={$_SESSION['uid']}"))["p_email"];
     $addrLine = $addr_row['addr_line'];
     $city = $addr_row['addr_city'];
     $landmark = $addr_row['addr_landmark'];
     $state = $addr_row['addr_state'];
     $district = $addr_row['addr_district'];
     $pin = $addr_row['addr_pin'];
    }
   }
  } else if (isset($_POST['new_address'])) {
   if (isset($_POST['name'])) {
    $name = get_safe_value($con, $_POST['name']);
   }
   $phn = get_safe_value($con, $_POST['phone']);
   $email = mysqli_fetch_assoc(mysqli_query($con, "select p_email from patient where p_id={$_SESSION['uid']}"))["p_email"];
   $addrLine = get_safe_value($con, $_POST['addrLine']);
   $city = get_safe_value($con, $_POST['city']);
   $landmark = get_safe_value($con, $_POST['landmark']);
   $state = get_safe_value($con, $_POST['state']);
   $district = get_safe_value($con, $_POST['district']);
   $pin = get_safe_value($con, $_POST['pin']);

   if (isset($_SESSION['add_new_default']) && $_SESSION['add_new_default'] == 1) {
    $name = mysqli_fetch_assoc(mysqli_query($con, "select p_name from patient where p_id={$_SESSION['uid']}"))["p_name"];
    $add = mysqli_query($con, "INSERT INTO `addr` (`user_type`, `user_id`, `user_name`, `addr_phn`, `addr_email`, `addr_line`, `addr_city`, `addr_landmark`, `addr_state`, `addr_district`, `addr_pin`, `addr_status`) VALUES ('patient', {$_SESSION['uid']}, '$name', '$phn', '$email', '$addrLine', '$city', '$landmark', '$state', '$district', '$pin', 1)");
    unset($_SESSION['add_new_default']);
   }
  }
  $invoice_selector = get_safe_value($con, $_POST['invoice_selector']);
  $payment_type = get_safe_value($con, $_POST['payment_type']);
  if ($invoice_selector == "paper") {
   $invoice_price = 5;
   $send_email_pdf = 0;
  } else if ($invoice_selector == "pdf") {
   $invoice_price = 0;
   $send_email_pdf = 1;
  }
  $_SESSION['send_email_pdf'] = $send_email_pdf;
  $discount = 0;
  $subtotal_mrp = 0;
  $total_price_all_combined = 0;
  $shipping_price = 50;
  $total_price_all_combined = $total_price_all_combined + $shipping_price + $invoice_price;
  $full_addr = "Near " . $landmark . ", " . $addrLine . ", " . $city . ", " . $district . ", " . $state . ", " . $pin;
  $res = mysqli_query($con, "INSERT INTO `medicine_order` (`p_id`, `ship_p_name`, `mo_phn`, `mo_email`, `mo_invoice`, `mo_shipping`,`total_price_all_combined` ,`mo_pay_type`, `mo_addr`, `mo_date`, `status`) VALUES ({$_SESSION['uid']}, '$name', '$phn', '$email', $invoice_price, $shipping_price,$total_price_all_combined, '$payment_type','$full_addr', CURRENT_TIMESTAMP(), 'confirmed')");
  if ($res) {
   $mo_id = mysqli_insert_id($con);
   $orderSuccess = 1;
  } else {
   header("location:../mycart.php");
   exit();
  }
  $subtotal = 0;
  if (isset($_SESSION['medicine']) && !empty($_SESSION['medicine'])) {
   foreach ($_SESSION['medicine'] as $medicine) {
    $m_id = $medicine['m_id'];
    $mod_qty = $medicine['c_qty'];
    $mod_price = $medicine['m_price'];
    $m_mrp = $medicine['m_mrp'];

    $insertOrderDetailQuery = "INSERT INTO `medicine_order_details` (`mo_id`, `m_id`, `mod_qty`, `mod_price`) 
                                        VALUES ('$mo_id', '$m_id', '$mod_qty', '$mod_price')";
    $res2 = mysqli_query($con, $insertOrderDetailQuery);
    if ($res2) {
     //remove from cart
     mysqli_query($con, "DELETE FROM cart WHERE `cart`.`c_product_id` = $m_id and `cart`.`p_id`={$_SESSION['uid']} and `cart`.`c_product_table`='medicine'");
     //get quanity and order_count from medicine table
     $res3 = mysqli_query($con, "select m_qty,order_count from medicine where m_id=$m_id");
     while ($qty_count = mysqli_fetch_assoc($res3)) {
      $m_qty = $qty_count['m_qty'] - $mod_qty;
      $order_count = $qty_count['order_count'] + $mod_qty;
     }
     //update qty in medicine table
     mysqli_query($con, "UPDATE `medicine` SET `m_qty` = $m_qty WHERE `medicine`.`m_id` = $m_id");
     //update order count in medicine table
     mysqli_query($con, "UPDATE `medicine` SET `order_count` = $order_count WHERE `medicine`.`m_id` = $m_id");

     $orderDetailsSuccess = 1;
     $subtotal_mrp = $subtotal_mrp + ($m_mrp * $mod_qty);
     $subtotal = $subtotal + ($mod_price * $mod_qty);
     $total_price_all_combined = $total_price_all_combined + ($mod_price * $mod_qty);
    } else {
     header("location:../mycart.php");
     exit();
    }
   }
   $discount = $subtotal_mrp - $subtotal;
  } else {
   header("location:../mycart.php");
   exit();
  }
  mysqli_query($con, "UPDATE `medicine_order` SET `total_price_all_combined` = $total_price_all_combined WHERE `medicine_order`.`mo_id` = $mo_id");
  if ($orderDetailsSuccess == 1 && $orderSuccess == 1) {
  } else {
   header("location:../mycart.php");
   exit();
  }
 }
} else {
 header("location:../mycart.php");
 exit();
}
$_SESSION['email'] = $email;
$_SESSION['mo_id'] = $mo_id;
$billing_res = mysqli_query($con, "select p_name,p_phn,p_email from patient where p_id = {$_SESSION['uid']}");
$shipping_res = mysqli_query($con, "select ship_p_name, mo_phn, mo_email,mo_addr from medicine_order where p_id={$_SESSION['uid']} ORDER BY mo_id DESC LIMIT 1");


$html = '<div style="width: 425px;height:600px; border: 1px solid black; font-size:10px;">
    <div>
        <div>
            <div style="position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border-radius: 1rem;">
                <div>
                    <div style="text-align: center;font-size:10px;border-bottom:1px solid #F4F4F4; padding:4px;">
                        <img src="../assets/img/others/logo-small.jpg" style="height:30px;">
                        <span style="font-size:12px; font-weight:bold; color:#339999;"> Diagnostics And Medicine Hub</span>
                    </div>
                    <div style="border-bottom:1px solid grey;">
                        <div style="width:50%;float: left; padding:4px;">';
while ($billing_to = mysqli_fetch_assoc($billing_res)) {
 $html .= '<div>
        <p style="margin:0;"><b>Billed To:</b></p>
        <p style="margin:0;">' . $billing_to['p_name'] . '</p>
        <p style="margin:0;">' . $billing_to['p_email'] . '</p>
        <p style="margin:0;">' . $billing_to['p_phn'] . '</p>
        <p style="margin:0;"> Payment Type : ' . $payment_type . '</p>
    </div>';
}
$html .= '</div>
    <div style="width:50%;float: left; padding:4px;">';
while ($shipping_to = mysqli_fetch_assoc($shipping_res)) {
 $html .= '<div>
    <p style="margin:0;"><b>Shipping Address:</b></p>
    <p style="margin:0;">' . $shipping_to['ship_p_name'] . '</p>
    <p style="margin:0;">' . $shipping_to['mo_addr'] . '</p>
    <p style="margin:0;">' . $shipping_to['mo_email'] . '</p>
    <p style="margin:0;">' . $shipping_to['mo_phn'] . '</p>
</div>';
}
$html .= '</div>
    </div>
    <hr/>
    <div>
        <p style="padding-left:4px;"><b>Order Summary :</b></p>
        <div>
            <table style="width:100%;border-collapse:collapse; text-align: center;">
                <thead>
                    <tr>
                        <th style="color:#339999;">No.</th>
                        <th style="color:#339999;">Image</th>
                        <th style="color:#339999;">Medicine</th>
                        <th style="color:#339999;">Price</th>
                        <th style="color:#339999;">Quantity</th>
                        <th style="color:#339999;">Total</th>
                    </tr>
                </thead>
                <tbody>';
$i = 1;
foreach ($_SESSION['medicine'] as $medicine) {
 $html .= '<tr>
                    <th>' . $i . '</th>
                    <td><img src="../assets/img/medicine/' . $medicine['m_image'] . '" style="height:15px;"></td>
                    <td>
                        <div>
                            <p>' . $medicine['m_name'] . '</p>
                        </div>
                    </td>
                    <td>' . $medicine['m_mrp'] . ' Rs/-</td>
                    <td>x' . $medicine['c_qty'] . '</td>
                    <td>' . $medicine['c_qty'] * $medicine['m_mrp'] . ' Rs/-</td>
                </tr>';
 $i += 1;
}
$html .= '<tr>
    <th colspan="5">Sub Total :</th>
    <td>' . $subtotal_mrp . ' Rs/-</td>
</tr>

<tr>
    <th colspan="5">
        Shipping Charge :</th>
    <td>' . $shipping_price . ' Rs/-</td>
</tr>
<tr>
    <th colspan="5">
        Convenience :</th>
    <td>' . $invoice_price . ' Rs/-</td>
</tr>
<tr>
    <th colspan="5">
        Discount :</th>
    <td>-' . $discount . ' Rs/-</td>
</tr>
<tr>
    <th colspan="5">Total</th>
    <td>
        <b>' . $total_price_all_combined . ' Rs/-</b>
    </td>
</tr></tbody>
</table>
</div>
</div>
<div style="display:flex; justify-content:space-between; background-color:#339999; color:white;padding:12px;">
    <p style="margin:0px;">
        <b>
            <img src="../assets/img/icon/tel.png" style="height:10px;">
            Call Us : 
        </b>
        <a href="tel:+91832-750-7847" style="color:white;">+91-8327507847</a>
    </p>
    <p style="margin:0px;">
        <b>
            <img src="../assets/img/icon/mail.png" style="height:10px;">
                Email Us : 
        </b>
        <a href = "mailto:protapb303@gmail.com" style="color:white;">protapb303@gmail.com</a>
    </p>
</div>
</div>
</div>
</div>
</div>
</div>';
?>

<main class="main-content site-wrapper-reveal" style="height:100vh;">
 <div class="loading-screen" id="loading_screen" style="display:none;">
  <div class="loading-circle"></div>
  <br>
  <p><b style="Color:#339999;">Processing your order !...</b></p>
 </div>
</main>
<script>
 $(document).ready(function() {
  $("#loading_screen").css("display", "flex");
  const {
   jsPDF
  } = window.jspdf;
  var doc = new jsPDF({
   unit: 'px',
   format: 'a4',
   orientation: 'portrait',
   compress: true,
   precision: 2,
   putOnlyUsedFonts: true,
   floatPrecision: 16
  });
  // Set zoom to 1 (100%)
  doc.internal.scaleFactor = 1;
  var pdfjs = <?php echo json_encode($html); ?>;
  var fileName = 'invoice_' + Date.now() + '.pdf';

  doc.html(pdfjs, {
   callback: function(doc) {
    var pdfData = doc.output('blob');
    var formData = new FormData();
    formData.append('pdf', pdfData, fileName);
    $.ajax({
     url: 'save_to_server.php',
     type: 'POST',
     data: formData,
     processData: false,
     contentType: false,
     success: function(data) {
      window.location.href = "thankyou.php";
     },
     error: function(xhr, status, error) {
      console.error('Error uploading PDF file:', error); // Log any errors
     }
    });
   },
   x: 10,
   y: 10
  });
 });
</script>
<?php
require($ROOT . "includes/footer.php");
?>