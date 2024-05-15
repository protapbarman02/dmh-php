<?php
require 'includes/db.inc.php';
require 'includes/config.php';
if (!isset($_SESSION['uid']) || $_SESSION['uid'] == null) {
  exit();
}
if (isset($_POST['type']) && $_POST['type'] != '') {
  $cart_type = $_POST['type'];
  if ($cart_type == 'small_cart') {
    if ($_POST['table'] == "test") {

      $cartRes = mysqli_query($con, "select test.t_fee,test.t_name,test.t_final_fee from test inner join cart on test.t_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='{$_POST['table']}'");
      $rowCount = mysqli_num_rows($cartRes);
      if ($rowCount == 0) {
        echo "Empty";
        exit();
      } else {
        echo "<table class='table'>
                    <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>";
        $total_price = 0;
        $total_mrp = 0;
        while ($cartRow = mysqli_fetch_assoc($cartRes)) {
          echo " <tr>
                        <td>" . $cartRow['t_name'] . "</td>
                        <td>" . $cartRow['t_fee'] . " Rs/-</td>
                    </tr>";
          $total_mrp += $cartRow['t_fee'];
          $total_price += $cartRow['t_final_fee'];
        }
        echo "</tbody>
                    <tfoot>
                        
                        <tr style='color:#339999;'>
                            <td>Total</td>
                            <td>" . $total_price . " Rs/-</td>
                        </tr>
                        <tr>
                            <td>You saved</td>
                            <td>" . ($total_mrp - $total_price) . " Rs/-</td>
                        </tr>
                    </tfoot>
                    </table>";
      }
      exit();
    } else if ($_POST['table'] == "medicine") {
      //medicine table
      $cartRes = mysqli_query($con, "select medicine.m_mrp,medicine.m_name,medicine.m_price from medicine inner join cart on medicine.m_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and c_product_table='{$_POST['table']}'");
      $rowCount = mysqli_num_rows($cartRes);
      if ($rowCount == 0) {
        echo "Empty";
        exit();
      } else {
        echo "<table class='table'>
                    <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>";
        $total_price = 0;
        $total_mrp = 0;
        while ($cartRow = mysqli_fetch_assoc($cartRes)) {
          echo " <tr>
                        <td>" . $cartRow['m_name'] . "</td>
                        <td>" . $cartRow['m_price'] . " Rs/-</td>
                    </tr>";
          $total_mrp += $cartRow['m_mrp'];
          $total_price += $cartRow['m_price'];
        }
        echo "</tbody>
                    <tfoot>
                        
                        <tr>
                            <td>Total</td>
                            <td>" . $total_price . " Rs/-</td>
                        </tr>
                        <tr style='color:#339999;'>
                            <td>You saved</td>
                            <td>" . ($total_mrp - $total_price) . " Rs/-</td>
                        </tr>
                    </tfoot>
                    </table>";
      }
      exit();
    } else if ($_POST['table'] == "package") {
      //package
      $cartRes = mysqli_query($con, "select package.pk_fee,package.pk_name,package.pk_pay_fee,cart.c_qty from package inner join cart on package.pk_id=cart.c_product_id where cart.p_id={$_SESSION['uid']} and cart.c_product_table='{$_POST['table']}'");
      $rowCount = mysqli_num_rows($cartRes);
      if ($rowCount == 0) {
        echo "Empty";
        exit();
      } else {
        echo "<table class='table'>
                    <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>For</th>
                        <th>Total Price</th>
                    </tr>
                    </thead>
                    <tbody>";
        $total_price = 0;
        $total_mrp = 0;
        while ($cartRow = mysqli_fetch_assoc($cartRes)) {
          echo " <tr>
                        <td>" . $cartRow['pk_name'] . "</td>
                        <td>" . $cartRow['c_qty'] . "</td>
                        <td>" . $cartRow['pk_fee'] * $cartRow['c_qty'] . " Rs/-</td>
                    </tr>";
          $total_mrp += $cartRow['pk_fee'] * $cartRow['c_qty'];
          $total_price += $cartRow['pk_pay_fee'] * $cartRow['c_qty'];
        }
        echo "</tbody>
                    <tfoot>
                        <tr>
                            <td colspan='2'>Total</td>
                            <td>" . $total_price . " Rs/-</td>
                        </tr>
                        <tr style='color:#339999;'>
                            <td colspan='2'>You saved</td>
                            <td>" . ($total_mrp - $total_price) . " Rs/-</td>
                        </tr>
                    </tfoot>
                    </table>";
      }
      exit();
    }
  } else if ($cart_type == "main_cart") {
  } else {
?>
    <script>
      window.location.href = "index.php";
    </script>
<?php
  }
}
?>