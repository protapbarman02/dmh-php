<?php $ROOT = '';
require("includes/header.php");
if (!isset($isLoggedIn) || $isLoggedIn != 1) {
?>
  <script>
    window.location.href = "login.php";
  </script>
<?php
}
$result = mysqli_query($con, "SELECT lab_app_date, COUNT(*) AS count FROM `lab_appointment` GROUP BY lab_app_date ORDER BY lab_app_date DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
$last_appointment_date = $row['lab_app_date'];
$current_date = date('Y-m-d');
if ($last_appointment_date < $current_date) {
  $estimated_lab_app_date = $current_date;
} else if ($count >= 20) {
  $estimated_lab_app_date = date('Y-m-d', strtotime($last_appointment_date . ' +1 day'));
} else {
  $estimated_lab_app_date = $last_appointment_date;
}

if (isset($_GET['type']) && $_GET['type'] == "removeItem") {
  $c_id = $_GET['c_id'];
  $removeSql = "DELETE FROM cart WHERE c_id=$c_id";
  $con->query($removeSql);
?>
  <script>
    window.location.href = "myCart.php";
  </script>
<?php
}


$test_cart_list = [];
$cartRes = mysqli_query($con, "select test.t_id,test.t_fee,cart.c_qty,test.t_name,test.t_image,test.t_final_fee,cart.c_id from test inner join cart on test.t_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='test'");
$rowCount = mysqli_num_rows($cartRes);
if ($rowCount > 0) {
  while ($cartRow = mysqli_fetch_assoc($cartRes)) {
    $test_cart_list[] = $cartRow;
  }
}
foreach ($test_cart_list as $key => $test) {
  $_SESSION['test'][$key]['t_id'] = $test['t_id'];
  $_SESSION['test'][$key]['t_final_fee'] = $test['t_final_fee'];
}
$package_cart_list = [];
$cartRes = mysqli_query($con, "select package.pk_id,package.pk_fee,cart.c_qty,package.pk_name,package.pk_image,package.pk_pay_fee,cart.c_id from package inner join cart on package.pk_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='package'");
$rowCount = mysqli_num_rows($cartRes);
if ($rowCount > 0) {
  while ($cartRow = mysqli_fetch_assoc($cartRes)) {
    $package_cart_list[] = $cartRow;
  }
}
foreach ($package_cart_list as $key => $package) {
  $_SESSION['package'][$key]['pk_id'] = $package['pk_id'];
  $_SESSION['package'][$key]['pk_pay_fee'] = $package['pk_pay_fee'];
}

$sub_total_test_mrp = 0;
$sub_total_test_final = 0;
$sub_total_test_save = 0;
$sub_total_package_mrp = 0;
$sub_total_package_final = 0;
$sub_total_package_save = 0;
$sub_total_medicine_mrp = 0;
$sub_total_medicine_final = 0;
$sub_total_medicine_save = 0;
$cart_total = 0;
$cart_total_save = 0;
?>
<main class="main-content site-wrapper-reveal">
  <div class="loading-screen" id="loading_screen" style="display:none;">
    <div class="loading-circle"></div>
    <br>
    <h4><b style="Color:#339999;">Processing your order !...</b></h4>
  </div>
  <section class="page-title-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="page-title-content">
            <div class="bread-crumbs">
              <a href="index.php">Home<span class="breadcrumb-sep">/</span></a>
              <span class="breadcrumb-sep active">Cart</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="container main-cart-type-container">
    <div class="row">
      <div class="d-flex justify-content-center main-cart-type">
        <button id="test_select">Lab Tests</button>
        <button id="package_select">Health Packages</button>
        <button id="medicine_select">Medicines</button>
      </div>
    </div>
  </section>
  <div class="container pt-5 border" style="height:100vh;">
    <div class="row px-xl-5">
      <div class="col-lg-8 table-responsive mb-5" class="main-cart-content" id="test_cart">
        <table class="table table-bordered text-center mb-0" id="test_table">
          <thead class="bg-secondary text-dark">
            <tr style="background-color:#339999; color:white;">
              <th>Lab Test</th>
              <th>Price</th>
              <th>Final Amount</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody class="align-middle" id="test-cart-body">
            <?php

            if (empty($test_cart_list)) {
              echo "Empty";
            } else {
              foreach ($test_cart_list as $cartRow) {

            ?>
                <tr>
                  <td class='align-middle'>
                    <img src='<?php echo SITE_IMAGE_TEST_LOC . $cartRow['t_image'] ?>' alt='test' style='width: 50px;'>
                    <a href="diagnosis/test.php?t_id=<?php echo $cartRow['t_id']; ?>"><?php echo $cartRow['t_name']; ?></a>
                  </td>
                  <td class='align-middle'><?php echo $cartRow['t_fee']; ?> Rs/-</td>
                  <td class='align-middle'><?php echo $cartRow['t_final_fee']; ?> Rs/-</td>
                  <td style="display:none;">
                    <div>
                      <input type="hidden" value="<?php echo $cartRow['c_qty']; ?>">
                    </div>
                  </td>
                  <td class='align-middle'><button class='btn btn-sm btn-light'><a href="?type=removeItem&c_id=<?php echo $cartRow['c_id']; ?>"><i class='icofont-delete-alt'></i></a></button></td>
                  <?php
                  $sub_total_test_mrp = $sub_total_test_mrp + $cartRow['t_fee'];
                  $sub_total_test_final = $sub_total_test_final + $cartRow['t_final_fee'];
                  ?>
                </tr>

            <?php
              }
              $sub_total_test_save = $sub_total_test_save + ($sub_total_test_mrp - $sub_total_test_final);
              $cart_total = $cart_total + $sub_total_test_final;
              $cart_total_save = $cart_total_save + $sub_total_test_save;
            }
            ?>
          </tbody>
        </table>
        <!-- checkout -->
        <div class="d-flex justify-content-end pt-2">
          <?php
          if ($sub_total_test_final != 0) {
          ?>
            <div>

              <button class="btn py-2 text-light" style="background-color:#339999; border-radius:0;" onclick="lab_appointment_confirm('test',<?php echo $sub_total_test_final; ?>)">
                Confirm Lab Appointment
              </button>
              <p>Estimated appointment date is</p>
              <p class="text-success"><?php echo $estimated_lab_app_date; ?></p>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="col-lg-8 table-responsive mb-5" class="main-cart-content" id="package_cart">
        <table class="table table-bordered text-center mb-0" id="package_table">
          <thead class="bg-secondary text-dark">
            <tr style="background-color:#339999; color:white;">
              <th>Health Package</th>
              <th>Price</th>
              <th>Final Amount</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody class="align-middle" id="package-cart-body">
            <?php

            if (empty($package_cart_list)) {
              echo "Empty";
            } else {
              foreach ($package_cart_list as $cartRow) {
            ?>
                <tr>
                  <td class='align-middle'><img src='<?php echo SITE_IMAGE_PACKAGE_LOC . $cartRow['pk_image']; ?>' alt='' style='width: 50px;'>
                    <a href="diagnosis/package.php?pk_id=<?php echo $cartRow['pk_id']; ?>"><?php echo $cartRow['pk_name']; ?></a>
                  </td>
                  <td class='align-middle'><?php echo $cartRow['pk_fee']; ?> Rs/-</td>
                  <td class='align-middle'><?php echo $cartRow['pk_pay_fee']; ?> Rs/-</td>
                  <td style="display:none;">
                    <div>
                      <input type="hidden" value="<?php echo $cartRow['c_qty']; ?>">
                    </div>
                  </td>
                  <td class='align-middle'><button class='btn btn-sm btn-light'><a href="?type=removeItem&c_id=<?php echo $cartRow['c_id']; ?>"><i class='icofont-delete-alt'></i></a></button></td>
                  <?php
                  $sub_total_package_mrp = $sub_total_package_mrp + $cartRow['pk_fee'];
                  $sub_total_package_final = $sub_total_package_final + $cartRow['pk_pay_fee'];
                  ?>
                </tr>

            <?php
              }
              $sub_total_package_save = $sub_total_package_save + ($sub_total_package_mrp - $sub_total_package_final);
              $cart_total = $cart_total + $sub_total_package_final;
              $cart_total_save = $cart_total_save + $sub_total_package_save;
            }
            ?>
          </tbody>
        </table>
        <!-- checkout -->
        <div class="d-flex justify-content-end pt-2">
          <?php
          if ($sub_total_package_final != 0) {
          ?>
            <div>
              <button class="btn py-2 text-light" style="background-color:#339999; border-radius:0;" onclick="lab_appointment_confirm('package',<?php echo $sub_total_package_final; ?>)">
                Confirm Health Package
              </button>
              <p>Estimated appointment date is</p>
              <p class="text-success"><?php echo $estimated_lab_app_date; ?></p>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="col-lg-8 table-responsive mb-5" class="main-cart-content" id="medicine_cart">
        <table class="table table-bordered text-center mb-0" id="medicine_table">
          <thead class="bg-secondary text-dark">
            <tr style="background-color:#339999; color:white;">
              <th>Medicine</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody class="align-middle" id="medicine-cart-body">
            <?php
            $cartRes = mysqli_query($con, "select medicine.m_qty,medicine.m_id,medicine.m_mrp,medicine.m_name,medicine.m_image,medicine.m_price,cart.c_qty,cart.c_id from medicine inner join cart on medicine.m_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='medicine'");
            $rowCount = mysqli_num_rows($cartRes);
            if ($rowCount == 0) {
              echo "Empty";
            } else {
              $m_qty_list = [];
              while ($cartRow = mysqli_fetch_assoc($cartRes)) {
                $m_qty_list[] = $cartRow['m_qty'];
            ?>
                <tr>
                  <td class='align-middle'><img src='<?php echo SITE_IMAGE_MEDICINE_LOC . $cartRow['m_image']; ?>' alt='' style='width: 50px;'>
                    <a href="medicine/medicine.php?m_id=<?php echo $cartRow['m_id']; ?>"><?php echo $cartRow['m_name']; ?></a>
                    <?php
                    if ($cartRow['m_qty'] < 10) {
                      echo "<br> <span style='color:red;'>Out of Stock</span>";
                    }
                    ?>
                  </td>
                  <td class='align-middle' style="display:none;"><?php echo $cartRow['m_mrp']; ?></td>
                  <td class='align-middle'><?php echo $cartRow['m_price']; ?> Rs/-</td>
                  <td class='align-middle'>
                    <div class='d-flex justify-content-center'>
                      <button class='btn btn-sm btn-plus-minus' id='medicine_qty_minus_<?php echo $cartRow['c_id']; ?>' onclick="qty_minus('medicine',<?php echo $cartRow['c_id']; ?>,<?php echo $cartRow['m_price']; ?>)">
                        <i class='icofont-minus'></i>
                      </button>
                      <input type='text' class='cart-qty' id='medicine_qty_<?php echo $cartRow['c_id'] ?>' value='<?php echo $cartRow['c_qty']; ?>'>
                      <button class='btn btn-sm btn-plus-minus' id='medicine_qty_plus_<?php echo $cartRow['c_id']; ?>' onclick="qty_plus('medicine',<?php echo $cartRow['c_id']; ?>,<?php echo $cartRow['m_price']; ?>)">
                        <i class='icofont-plus'></i>
                      </button>
                    </div>
                  </td>
                  <td class='align-middle' id="medicine_total_price_each_<?php echo $cartRow['c_id']; ?>"><span><?php echo $cartRow['m_price'] * $cartRow['c_qty']; ?></span> Rs/-</td>
                  <td class='align-middle'><button class='btn btn-sm btn-light'><a href="?type=removeItem&c_id=<?php echo $cartRow['c_id']; ?>"><i class='icofont-delete-alt'></i></a></button></td>
                  <?php
                  $sub_total_medicine_mrp = $sub_total_medicine_mrp + $cartRow['m_mrp'] * $cartRow['c_qty'];
                  $sub_total_medicine_final = $sub_total_medicine_final + $cartRow['m_price'] * $cartRow['c_qty'];
                  ?>
                </tr>

            <?php
              }
              $sub_total_medicine_save = $sub_total_medicine_save + ($sub_total_medicine_mrp - $sub_total_medicine_final);
              $cart_total = $cart_total + $sub_total_medicine_final;
              $cart_total_save = $cart_total_save + $sub_total_medicine_save;
            }
            ?>
          </tbody>
        </table>
        <!-- checkout -->
        <div class="d-flex justify-content-end pt-2">
          <?php
          if ($sub_total_medicine_final != 0) {
          ?>
            <form action="medicine/checkout.php" method="post">
              <?php
              foreach ($m_qty_list as $qty) {
                if ($qty < 10) {
                  $no_stock = 1;
                } else {
                  $no_stock = 0;
                }
              }
              if ($no_stock == 1) {
                echo '<button type="submit" name="medicine_checkout" class="btn py-2 text-light" style="background-color:#989899; border-radius:0;" disabled>
                                        Proceed To Checkout(Medicines)
                                        </button>';
              } else if ($no_stock == 0) {
                echo '<button type="submit" name="medicine_checkout" class="btn py-2 text-light" style="background-color:#339999; border-radius:0;">
                                        Proceed To Checkout(Medicines)
                                    </button>';
              }
              ?>
            </form>
          <?php
          }
          ?>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="row pt-2" style="background-color: #339999;">
          <div class="col">
            <h5 class="text-light text-center">Cart Summary</h5>
          </div>
        </div>
        <div class="row d-flex flex-column">
          <div class="col mt-2 d-flex justify-content-between align-items-center" style="background-color: #339999; color:white;">
            <span>Lab Tests</span>
            <img src="<?php echo SITE_IMAGE_ICON_LOC ?>menu.png" style="height:10px" alt="down" id="cart_test_icon">
          </div>
          <div class="col" id="cart_test_item">
            <div class="d-flex flex-column">
              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">Total</h6>
                  <h6 class="font-weight-medium"><span id="cart_test_price_span"><?php echo $sub_total_test_final; ?></span> Rs/-</h6>
                </div>
              </div>

              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">You Saved</h6>
                  <h6 class="font-weight-medium"><span id="cart_test_save_span"><?php echo $sub_total_test_save; ?></span> Rs/-</h6>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="row d-flex flex-column">
          <div class="col mt-2 d-flex justify-content-between align-items-center" style="background-color: #339999; color:white;">
            <span>Health Packages</span>
            <img src="<?php echo SITE_IMAGE_ICON_LOC ?>menu.png" style="height:10px" alt="down" id="cart_package_icon">
          </div>
          <div class="col" id="cart_package_item">
            <div class="d-flex flex-column">
              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">Total</h6>
                  <h6 class="font-weight-medium"><span id="cart_package_price_span"><?php echo $sub_total_package_final; ?></span> Rs/-</h6>
                </div>
              </div>

              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">You Saved</h6>
                  <h6 class="font-weight-medium"><span id="cart_package_save_span"><?php echo $sub_total_package_save; ?></span> Rs/-</h6>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="row d-flex flex-column" style="border-bottom:1px solid #339999;">
          <div class="col mt-2 d-flex justify-content-between align-items-center" style="background-color: #339999; color:white;">
            <span>Medicines</span>
            <img src="<?php echo SITE_IMAGE_ICON_LOC ?>menu.png" style="height:10px" alt="down" id="cart_medicine_icon">
          </div>
          <div class="col" id="cart_medicine_item">
            <div class="d-flex flex-column">
              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">Total</h6>
                  <h6 class="font-weight-medium"><span id="cart_medicine_price_span"><?php echo $sub_total_medicine_final; ?></span> Rs/-</h6>
                </div>
              </div>

              <div class="pt-2">
                <div class="col d-flex justify-content-between">
                  <h6 class="font-weight-medium">You Saved</h6>
                  <h6 class="font-weight-medium"><span id="cart_medicine_save_span"><?php echo $sub_total_medicine_save; ?></span> Rs/-</h6>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!--  -->
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $("#package_cart,#medicine_cart,#cart_package_item,#cart_medicine_item").css("display", "none")
      $("#test_select").css("background-color", "#339999")

      $("#test_select").click(() => {
        $("#test_select").css("background-color", "#339999")
        $("#package_select,#medicine_select").css("background-color", "#416464")
        $("#package_cart,#medicine_cart,#cart_package_item,#cart_medicine_item").css("display", "none")
        $("#test_cart,#cart_test_item").css("display", "block")

      })
      $("#package_select").click(() => {
        $("#package_select").css("background-color", "#339999")
        $("#test_select,#medicine_select").css("background-color", "#416464")
        $("#medicine_cart,#test_cart,#cart_test_item,#cart_medicine_item").css("display", "none")
        $("#package_cart,#cart_package_item").css("display", "block")

      })
      $("#medicine_select").click(() => {
        $("#medicine_select").css("background-color", "#339999")
        $("#test_select,#package_select").css("background-color", "#416464")
        $("#medicine_cart,#cart_medicine_item").css("display", "block")
        $("#test_cart,#package_cart,#cart_test_item,#cart_package_item").css("display", "none")

      })
    })


    function qty_minus(table, id, price) {
      var qty_val = Number($("#" + table + "_qty_" + id).val());
      if ((table == "test" || table == "package") && (1 < qty_val && qty_val <= 4)) {
        updateQuantity(qty_val, table, id, 'minus', price);
      } else if (table == "medicine" && (1 < qty_val && qty_val <= 10)) {
        updateQuantity(qty_val, table, id, 'minus', price);
      }
    }

    function qty_plus(table, id, price) {
      var qty_val = Number($("#" + table + "_qty_" + id).val());
      if ((table == "test" || table == "package") && (1 <= qty_val && qty_val < 4)) {
        updateQuantity(qty_val, table, id, 'plus', price);
      } else if (table == "medicine" && (1 <= qty_val && qty_val < 10)) {
        updateQuantity(qty_val, table, id, 'plus', price);
      }
    }

    function updateQuantity(qty_val, table, id, action, price) {
      if (action == 'minus') {
        $("#" + table + "_qty_" + id).val(qty_val - 1);
      } else if (action == 'plus') {
        $("#" + table + "_qty_" + id).val(qty_val + 1);
      } else {
        return;
      }
      $("#" + table + "_total_price_each_" + id + ">span").text(price * ($("#" + table + "_qty_" + id).val()))

      $.ajax({
        url: 'cart_manage.php',
        method: 'post',
        data: {
          cart_id: id,
          qty: $("#" + table + "_qty_" + id).val(),
        }
      });
      var data = get_cart_priceLidst_ultimate();
      var ultimate_totals = calculateTotals(data)
      populateValues(ultimate_totals)

    }

    function get_cart_priceLidst_ultimate() {
      // Initialize an empty object to store items for each category
      var itemList = {};

      // Loop through each table
      ['medicine-cart-body', 'package-cart-body', 'test-cart-body'].forEach(function(category) {
        // Select the table by its class
        var tableBody = document.querySelector('#' + category);

        // Initialize an empty array to store items for this category
        itemList[category] = [];

        // Loop through each row of the table
        tableBody.querySelectorAll('tr').forEach(function(row) {
          // Extract name and price from the row
          var mrp = Number(row.cells[1].textContent.replace(' Rs/-', ''));
          var price = Number(row.cells[2].textContent.replace(' Rs/-', ''));
          var qty = row.cells[3].querySelector('div input').value;
          // Create an object for the item and add it to the itemList array for this category
          itemList[category].push({
            mrp: mrp,
            price: price,
            qty: qty
          });
        });
      });
      return itemList;
    }

    // Function to calculate total MRP, total price, and savings for each category
    function calculateTotals(data) {
      var categoryTotals = {};

      // Iterate over each category in the data object
      for (var category in data) {
        var items = data[category];
        var totalMRP = 0;
        var totalPrice = 0;

        // Calculate total MRP and total price for items in the current category
        items.forEach(function(item) {
          var qty = parseInt(item.qty);
          totalMRP += item.mrp * qty;
          totalPrice += item.price * qty;
        });

        // Calculate total savings
        var totalSavings = totalMRP - totalPrice;

        // Store total MRp, total price, and total savings for the current category
        categoryTotals[category] = {
          totalPrice: totalPrice,
          totalSavings: totalSavings
        };
      }

      return categoryTotals;
    }

    function populateValues(totals) {
      // Populate values for Lab Tests
      $('#cart_test_price_span').text(totals['test-cart-body'].totalPrice);
      $('#cart_test_save_span').text(totals['test-cart-body'].totalSavings);

      // Populate values for Health Packages
      $('#cart_package_price_span').text(totals['package-cart-body'].totalPrice);
      $('#cart_package_save_span').text(totals['package-cart-body'].totalSavings);

      // Populate values for Medicines
      $('#cart_medicine_price_span').text(totals['medicine-cart-body'].totalPrice);
      $('#cart_medicine_save_span').text(totals['medicine-cart-body'].totalSavings);

      $('#cart_total_price_span').text(totals['test-cart-body'].totalPrice + totals['package-cart-body'].totalPrice + totals['medicine-cart-body'].totalPrice)
      $('#cart_total_save_span').text(totals['test-cart-body'].totalSavings + totals['package-cart-body'].totalSavings + totals['medicine-cart-body'].totalSavings)
    }




    function lab_appointment_confirm(type, price) {
      $("#loading_screen").css("display", "flex");
      jQuery.ajax({
        url: 'diagnosis/checkout.php',
        type: 'post',
        data: 'type=' + type + '&price=' + price,
        success: function(result) {
          console.log(result)
          if (result == 'done') {
            $("#loading_screen").html("<div class='d-flex flex-column align-items-center'><h2 class='theme-color'>Thank You !</h2><h3>Your appointment request is registered</h3></br> <h3>you'll be contacted in an hour</h3><h5><a href='my_lab_appointments.php' class='text-decoration-underline'>View Your Appointments</a></h5></div>");
          } else {
            $("#loading_screen").html(`Sorry, the ${type} is not available right now`);
          }
        }

      });
    }
  </script>
</main>
<?php require("includes/footer.php"); ?>