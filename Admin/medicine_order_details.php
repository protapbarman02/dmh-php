<?php $ROOT = "../";
require('includes/nav.php');
if (isset($_GET['mo_id'])) {
  $mo_id = get_safe_value($con, $_GET['mo_id']);
  $status = mysqli_fetch_assoc(mysqli_query($con, "select * from medicine_order where mo_id=$mo_id"))['status'];
} else {
?>
  <script>
    window.location.href = "medicine_order.php";
  </script>
<?php
  exit();
}
if (isset($_POST['submit'])) {
  $up_status = get_safe_value($con, $_POST['status']);
  mysqli_query($con, "UPDATE `medicine_order` SET `status` = '$up_status' WHERE `medicine_order`.`mo_id` = $mo_id");
}
?>
<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Order Details : #<?php echo $mo_id; ?></h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="medicine_order.php" class="right-top-link">Medicine Orders</a>
      <span> / </span>
      <p class="right-top-link active">Order Details</p>
    </span>
  </div>
  <div class="admin-medicineOrders-main">
    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th>SL No.</th>
            <th>Medicine Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $res = mysqli_query($con, "select * from medicine_order_details where mo_id=$mo_id");
          while ($row = mysqli_fetch_assoc($res)) {
          ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td>
                <?php
                $m_name = mysqli_fetch_assoc(mysqli_query($con, "select m_name from medicine where m_id={$row['m_id']}"))['m_name'];
                echo $m_name;
                ?>
              </td>
              <td><?php echo $row['mod_price']; ?> Rs/-</td>
              <td>x<?php echo $row['mod_qty']; ?></td>
              <td><?php echo $row['mod_price'] * $row['mod_qty']; ?> Rs/-</td>
            </tr>
          <?php
            $i += 1;
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="text-center mt-4 border">
      <h5>Order Status : <b><?php echo $status; ?></b></h5>
      <div class="div d-flex justify-content-center align-items-center">
        <h4>Update Order Status :</h4>
        <form action="" method="post" class="d-flex">
          <select name="status" id="status" class="form-select">
            <option value="confirmed">confirmed</option>
            <option value="completed">completed</option>
          </select>
          <button type="submit" class="btn" name="submit"><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>check.png" alt="update" style="height:40px;"></button>
        </form>
      </div>
      <button class="btn"><a href="medicine_order.php">Back</a></button>
    </div>
  </div>
</section>
</main>

<?php
require('includes/footer.php');
?>