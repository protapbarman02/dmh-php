<?php $ROOT = '../';
require($ROOT . "includes/header.php");
if (!isset($_POST['medicine_checkout'])) {
?>
 <script>
  window.location.href = "../myCart.php";
 </script>
<?php
 exit();
}
$res = mysqli_query($con, "select c_product_id from cart where cart.p_id={$_SESSION['uid']} and c_product_table='medicine'");
if (mysqli_num_rows($res) <= 0) {
?>
 <script>
  window.location.href = "../myCart.php";
 </script>
<?php
 exit();
}
$email = mysqli_fetch_assoc(mysqli_query($con, "select p_email from patient where p_id={$_SESSION['uid']}"))["p_email"];
$addr_default = [];
$medicine_cart_list = [];
$subtotal = 0;
$addr_res = mysqli_query($con, "select * from addr where user_type='patient' and user_id={$_SESSION['uid']} and addr_status=1");
if (mysqli_num_rows($addr_res) > 0) {
 while ($addr_row = mysqli_fetch_assoc($addr_res)) {
  $addr_default[] = $addr_row;
 }
}

$cartRes = mysqli_query($con, "select medicine.m_id, medicine.m_image,medicine.m_name,medicine.m_price,medicine.m_mrp,cart.c_qty,cart.c_id from medicine inner join cart on medicine.m_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='medicine'");
while ($cartRow = mysqli_fetch_assoc($cartRes)) {
 $medicine_cart_list[] = $cartRow;
}

?>

<main class="main-content site-wrapper-reveal">
 <section class="page-title-area">
  <div class="container position-relative">
   <div class="row">
    <div class="col-lg-12">
     <div class="page-title-content">
      <div class="bread-crumbs">
       <a href="<?php echo $ROOT; ?>index.php">Home<span class="breadcrumb-sep">/</span></a>
       <a href="<?php echo $ROOT; ?>myCart.php">Cart<span class="breadcrumb-sep">/</span></a>
       <span class="breadcrumb-sep active">Checkout</span>
      </div>
     </div>
    </div>
   </div>
  </div>
 </section>
 <div class="loading-screen" id="loading_screen" style="display:none;">
  <div class="loading-circle"></div>
  <br>
  <h4><b style="Color:#339999;">Processing your order !...</b></h4>
 </div>

 <section class="checkout_area my-4">
  <div class="container">
   <form action="confirm.php" class="contact-form" method="post" id="order_form">
    <div class="billing_details">
     <div class="row">
      <div class="col-lg-6">
       <div class="mb-4">
        <h3>Shipping Address</h3>
        <?php
        if (empty($addr_default)) {
         echo "No address available";
         $addressAvailavle = 0;
         $_SESSION['add_new_default'] = 1;
        } else {
         $addressAvailavle = 1;
        ?>
         <div class="default-address">
          <?php
          foreach ($addr_default as $addr) {
          ?>
           <div class="div border p-2">
            <p><?php echo $addr['user_name']; ?>, <?php echo $addr['addr_phn']; ?></p>
            <p><?php echo $email; ?></p>
            <p><?php echo $addr['addr_line']; ?>, <?php echo $addr['addr_city']; ?>, <?php echo $addr['addr_landmark']; ?></p>
            <p><?php echo $addr['addr_district']; ?>, <?php echo $addr['addr_state']; ?>, <?php echo $addr['addr_pin']; ?></p>
           </div>

          <?php
          }
          ?>
         </div>
        <?php
        }
        ?>
       </div>

       <div class="col-md-12 mt-4">
        <div class="creat_account">
         <input type="checkbox" id="f-option3" name="selector">
         <label for="f-option3">

          <?php
          if (empty($addr_default)) {
           echo "<h3>Add and Ship To New Address</h3>";
           $addressAvailavle = 0;
          } else {
           echo "<h3>Ship To New Address</h3>";
           $addressAvailavle = 1;
          }
          ?>
         </label>
        </div>
       </div>
       <div class="row hidden-new-address" id="new_address">
        <?php
        if (!empty($addr_default)) {
        ?>
         <div class="col-md-6 form-group">
          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
         </div>
        <?php
        }
        ?>
        <div class="col-md-6 form-group  ">
         <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
        </div>

        <div class="col-md-12 form-group  ">
         <input type="text" class="form-control" id="addrLine" name="addrLine" placeholder="Address Line">
        </div>
        <div class="col-md-6 form-group  ">
         <input type="text" class="form-control" id="city" name="city" placeholder="City">
        </div>
        <div class="col-md-6 form-group  ">
         <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Landmark">
        </div>

        <div class="col-md-6 form-group">
         <select class="form-control" aria-placeholder="State" name="state">
          <option value="West Bengal">West Bengal</option>
         </select>
        </div>

        <div class="col-md-6 form-group">
         <select class="form-control" name="district">
          <option value="" disabled selected hidden>District</option>
          <option value="Cooch Behar">Cooch Behar</option>
          <option value="Alipurduar">Alipurduar</option>
          <option value="Jalpaiguri">Jalpaiguri</option>
         </select>
        </div>
        <div class="col-md-6 form-group">
         <input type="text" class="form-control" id="zip" name="pin" placeholder="Postcode/PIN/ZIP">
        </div>
        <div class="col-md-6">
         <button type="button" class="book-btn-medi" style="padding: 10px; cursor:pointer;" id="confirm_address">Confirm Address</button>
        </div>
       </div>
      </div>
      <div class="col-lg-6">
       <div class="order_box">
        <h2 style="text-align: center;">Your Order</h2>
        <table class="table">
         <tr style="color:black;">
          <td>Medicine</td>
          <td>Qty</td>
          <td>Total</td>
         </tr>

         <?php
         foreach ($medicine_cart_list as $key => $medicine) {
          $_SESSION['medicine'][$key]['m_id'] = $medicine['m_id'];
          $_SESSION['medicine'][$key]['m_name'] = $medicine['m_name'];
          $_SESSION['medicine'][$key]['m_image'] = $medicine['m_image'];
          $_SESSION['medicine'][$key]['c_qty'] = $medicine['c_qty'];
          $_SESSION['medicine'][$key]['m_price'] = $medicine['m_price'];
          $_SESSION['medicine'][$key]['m_mrp'] = $medicine['m_mrp'];

         ?>
          <tr>
           <td>
            <a style="color:white;" href="medicine.php?m_id=<?php echo $medicine['m_id']; ?>">
             <?php echo $medicine['m_name']; ?>

            </a>
           </td>
           <td>
            x <?php echo $medicine['c_qty']; ?>
           </td>
           <td>
            <?php echo $medicine['m_price'] * $medicine['c_qty']; ?>
            Rs/-
           </td>

          </tr>

         <?php
          $subtotal = (float)$subtotal + $medicine['m_price'] * $medicine['c_qty'];
         }
         ?>


        </table>
        <div class="payment_item">
         <div class="radion_btn">
          <input type="radio" id="f-option5" name="invoice_selector" value="pdf">
          <label for="f-option5" class="f-option">Email Invoice as PDF</label>
          <div class="check"></div>
         </div>
         <p>Small changes can make a big difference – save paper, save the environment</p>
         <div class="radion_btn">
          <input type="radio" id="f-option6" name="invoice_selector" value="paper" checked>
          <label for="f-option6" class="f-option">Print Out Invoice</label>
          <div class="check"></div>
         </div>
        </div>
        <table class="table"> <!-- list_2 -->
         <tr>
          <td>Subtotal</td>
          <td><span id="subtotal_val"><?php echo $subtotal; ?></span><span> Rs/-</span></td>
          <td></td>

         </tr>
         <tr>
          <td>Shipping:Flat rate </td>
          <td><span id="shipping_val">50</span><span> Rs/-</span></td>

         </tr>
         <tr>
          <td>Convenience Charge</td>
          <td><span id="invoicePrice">5</span><span> Rs/-</span></td>

         </tr>
         <tr>
          <td>Total </td>
          <td><span id="total_val"></span><span> Rs/-</span></td>

         </tr>

        </table>
        <div class="list list_2">
         <h5>
          <input type="checkbox" id="f-option7" name="payment_type" value="cod" required checked>
          <label for="f-option7" class="f-option-black">Cash On Delivery</label>
         </h5>
        </div>

        <div class="creat_account">
         <input type="checkbox" id="f-option8" name="terms" required>
         <label for="f-option8" class="f-option">I’ve read and accept the </label>
         <a href="#">terms & conditions*</a>
        </div>
        <input type="hidden" id="email" value="<?php echo $email; ?>">
        <input type="hidden" id="address_available" value="<?php echo $addressAvailavle; ?>">

        <div class="row">

         <div class="col-6">
          <button type="button" class="btn confirm-btn">
           <a href="<?php echo $ROOT; ?>myCart.php">Manage Cart</a>
          </button>
         </div>
         <div class="col-6">
          <button type="submit" name="default_address" class="btn confirm-btn" id="confirm_btn" disabled>Confirm Order</button>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </form>
  </div>
  <div class="otp-overlay-con col-lg-4 col-md-6 col-8 p-4 bg-light">
   <div class="row">
    <div class="col">
     <div class="section-title text-center after-success">
      <h3>Please enter OTP sent to <span id="getEmail" style="color:#339999; font-size:1rem"></span></h3>
     </div>
    </div>
   </div>
   <div class="row justify-content-center">
    <div class="col-lg-6 col-12">
     <div class="loading-circle2-cont d-flex align-items-center justify-content-center" style="visibility:hidden;">
      <div class="loading-circle2"></div>
     </div>
     <div class="otp-inp">
      <input type="text" id="email_otp" placeholder="Enter OTP" class="email_verify_otp form-control">
     </div>
     <div class="log-error col-12" id="otp_err"></div>
    </div>
    <div class="col-12 mt-4 text-center">
     <button type="button" class="btn btn-theme col-6" onclick="email_verify_otp()">Verify</button>
    </div>
   </div>
   <!-- <div class="resend">didn't recieve otp? <span onclick="email_sent_otp()" style="color:#339999;">resend...</span></div> -->
  </div>
 </section>
 <script>
  old_address = 0;
  new_address = 0;
  new_address_confirmed = 0;
  otp_verified = 0;
  $(document).ready(function() {
   if ($("#address_available").val() == 0) {
    $('#new_address').removeClass('hidden-new-address');
    $('#new_address input, #new_address select').prop('required', true);
    $('#confirm_btn').attr('name', 'new_address');
    new_address = 1;
    old_address = 0;
   }
   total_val = Number($("#subtotal_val").text()) + Number($("#shipping_val").text()) + Number($("#invoicePrice").text())
   $("#total_val").text(total_val)

   $('#f-option3').change(function() {
    if ($(this).is(':checked')) {
     $('#new_address').removeClass('hidden-new-address');
     $('#new_address input, #new_address select').prop('required', true);
     $('#confirm_btn').attr('name', 'new_address');
     new_address = 1;
     old_address = 0;
    } else {
     $('#new_address').addClass('hidden-new-address');
     $('#new_address input, #new_address select').prop('required', false);
     $('#confirm_btn').attr('name', 'default_address');
     old_address = 1;
     new_address = 0;
    }
   });

   $('input[name="invoice_selector"]').change(function() {
    if ($(this).attr("id") === "f-option5") {
     $("#invoicePrice").text("0");
    } else if ($(this).attr("id") === "f-option6") {
     $("#invoicePrice").text("5");
    }
    total_val = Number($("#subtotal_val").text()) + Number($("#shipping_val").text()) + Number($("#invoicePrice").text())
    $("#total_val").text(total_val)
   });

   $("#confirm_address").click(() => {
    $('#new_address input, #new_address select').val()
    var isEmpty = false;
    $("#new_address input, #new_address select").each(function() {
     if ($(this).val().trim() === '') {
      isEmpty = true;
      new_address_confirmed = 0;
      return false;
     }
     $("#confirm_address").text(" Confirmed ");
     new_address_confirmed = 1;
    });
    if (isEmpty) {
     alert("Please provide Shipping Details");
    }
   })

   function getEmail() {
    var email = $('#email').val().trim();
    return email;
   }

   $('#f-option8').one('change', function() {
    $("#confirm_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').prop('disabled', true);
    $('.log-error').html('');
    let email = getEmail();
    $('#getEmail').html(email);
    $('#getEmail').css("color", "blue");
    $.ajax({
     url: '../send_otp.php',
     type: 'post',
     data: 'email=' + email + '&phn=' + phone + '&type=order_confirm',
     success: function(result) {
      if (result == 'send') {
       $(".otp-overlay-con").css("display", "block");
       $("#order_form").css("opacity", "0.3");
      } else {
       $(".otp-overlay-con").css("display", "none");
       $("#order_form").css("opacity", "1");
       $('#email_err').html('Please try after sometime');
      }
     }
    });

   })
   $('#order_form').on("submit", () => {
    $("#loading_screen").css("display", "flex");
   });

  });

  function email_verify_otp() {
   $('#otp_err').html('');
   var email_otp = $('#email_otp').val().trim();
   if (email_otp == '') {
    $('#otp_err').html('Please enter OTP');
   } else {
    $.ajax({
     url: '../check_otp.php',
     type: 'post',
     data: 'otp=' + email_otp,
     success: function(result) {
      if (result == 'done') {
       otp_verified = 1;
       $(".after-success").text("OTP verified successfully");
       $(".loading-circle2-cont").css("visibility", "visible");
       $("#email_otp").prop('disabled', true);
       $("#confirm_btn").text("Confirm Order").prop('disabled', false);
       // $(".otp-overlay-con").css("display", "none");
       // $("#order_form").css("opacity", "1");
       $('.log-error').html('');
       $("#confirm_btn").removeAttr("disabled");
       setTimeout(function() {
        $(".otp-overlay-con").css("display", "none"); // Hiding the OTP overlay
        $("#order_form").css("opacity", "1"); // Setting form opacity to fully visible
       }, 2000);

      } else {
       otp_verified = 0;
       $('#otp_err').html('Please enter valid OTP');
      }
     }

    });
   }
  }
 </script>

</main>
<?php
require($ROOT . "includes/footer.php");
?>