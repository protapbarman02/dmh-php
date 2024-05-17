<?php $ROOT = "../";
include("$ROOT" . "includes/header.php");
if (isset($_SESSION['mo_id'])) {
 if (!isset($_SESSION['medicine'])) {
?>
  <script>
   window.location.href = "../myCart.php";
  </script>
 <?php
  die();
 }
} else {
 ?>
 <script>
  window.location.href = "../myCart.php";
 </script>
<?php
 die();
}
$invoice_price = 0;
$sent_invoice = 0;
//medicine order table(shipping)
$order = [];
$res = mysqli_query($con, "select * from medicine_order where mo_id={$_SESSION['mo_id']} and p_id={$_SESSION['uid']}");
while ($row = mysqli_fetch_assoc($res)) {
 $order[] = $row;
}
foreach ($order as $order_info) {
 $invoice_price = $order_info['mo_invoice'];
 $shipping_price = $order_info['mo_shipping'];
 $total_price_all_combined = $order_info['total_price_all_combined'];
 $email = $order_info['mo_email'];
}
if ($invoice_price == 0) {
 $sent_invoice = 1;
}

?>
<main class="main-content site-wrapper-reveal">
 <section class="order_details section_gap">
  <div class="container">
   <h3 class="title_confirmation">Thank you. Your order has been received.
    <?php
    if ($sent_invoice == 1) {
     echo "<p>Invoice is sent to $email</p>";
    }
    ?>
   </h3>
   <div class="row order_d_inner">
    <div class="col-lg-6">
     <div class="details_item">
      <h4>Order Info</h4>
      <ul class="list">
       <?php
       foreach ($order as $order_info) {
       ?>
        <li><a href="#"><span>Order Date-Time</span> : <?php echo $order_info['mo_date']; ?></a></li>
        <li><a href="#"><span>Order Final Amount</span> : <?php echo $order_info['total_price_all_combined']; ?> Rs/-</a></li>
        <li><a href="#"><span>Payement Type</span> : <?php echo $order_info['mo_pay_type']; ?></a></li>
        <li><a href="#"><span>Email Address</span> : <?php echo $order_info['mo_email']; ?></a></li>
        <li><a href="#"><span>Shipping Address</span> : <?php echo $order_info['mo_addr']; ?></a></li>
       <?php
       }
       ?>
      </ul>
     </div>
    </div>


   </div>
   <div class="order_details_table">
    <h2>Order Details</h2>
    <div class="table-responsive">
     <table class="table">
      <thead>

       <tr>
        <th scope="col">Medicine</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total</th>
       </tr>

      </thead>
      <tbody>
       <?php
       $subtotal = 0;
       $discount = 0;
       $final_price_each = 0;
       foreach ($_SESSION['medicine'] as $medicine) {
       ?>
        <tr>
         <td>
          <p><?php echo $medicine['m_name']; ?></p>
         </td>
         <td>
          <h5>x <?php echo $medicine['c_qty']; ?></h5>
         </td>
         <td>
          <p><?php echo $medicine['c_qty'] * $medicine['m_mrp']; ?> Rs/-</p>
         </td>
        </tr>
       <?php
        $subtotal += $medicine['c_qty'] * $medicine['m_mrp'];
        $final_price_each += $medicine['c_qty'] * $medicine['m_price'];
       }
       ?>
       <tr>
        <td>
         <h4>Subtotal</h4>
        </td>
        <td>
         <h5></h5>
        </td>
        <td>
         <p><span><?php echo $subtotal; ?></span> Rs/-</p>
        </td>
       </tr>

       <tr>
        <td>
         <h4>Shipping</h4>
        </td>
        <td>
         <h5></h5>
        </td>
        <td>
         <p>Flat rate: <span><?php echo $shipping_price; ?></span> Rs/-</p>
        </td>
       </tr>
       <tr>
        <td>
         <h4>Invoice</h4>
        </td>
        <td>
         <h5></h5>
        </td>
        <td>
         <p><span><?php echo $invoice_price; ?></span> Rs/-</p>
        </td>
       </tr>
       <tr>
        <td>
         <h4>Discount</h4>
        </td>
        <td>
         <h5></h5>
        </td>
        <td>
         <p><span>- <?php echo ($subtotal - $final_price_each); ?></span> Rs/-</p>
        </td>
       </tr>
       <tr>
        <td>
         <h4>Total</h4>
        </td>
        <td>
         <h5></h5>
        </td>
        <td>
         <p><span><?php echo $total_price_all_combined; ?></span> Rs/-</p>
        </td>
       </tr>
       <tr>
        <td>
          <h4>Estimated Delivery Data :</h4>
        </td>
        <td><h5></h5></td>
        <td>
          <p>
          <?php 
          $today = date("Y-m-d");
          $future_date = date("Y-m-d", strtotime("+7 days"));
          echo $future_date; 
          ?>
          </p>
        </td>
       </tr>
      </tbody>
     </table>
    </div>
   </div>
  </div>
 </section>

</main>
<?php
unset($_SESSION['medicine']);
unset($_SESSION['mo_id']);
unset($_SESSION['email']);
include('../smtp/PHPMailerAutoload.php');
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPSecure = "tls";
$mail->SMTPAuth = true;
$mail->Username = "protapb303@gmail.com";
$mail->Password = "xkhyqhqyixfmcspm";
$mail->SetFrom("protapb303@gmail.com");
$mail->addAddress($email);
$mail->IsHTML(true);
$mail->Subject = "Thank You";
$mail->Body = "Your order is confirmed at Diagnostics and Medicine Hub, total amount of $total_price_all_combined Rs/- for your order is to be paid as COD";
$mail->SMTPOptions = array('ssl' => array(
 'verify_peer' => false,
 'verify_peer_name' => false,
 'allow_self_signed' => false
));
$mail->send();


include("$ROOT" . "includes/footer.php");
?>