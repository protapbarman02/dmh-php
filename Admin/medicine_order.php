<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Medicine Orders</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="medicine_order.php" class="right-top-link active">Medicine Orders</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineOrders-main">
    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th>SL No.</th>
            <th>Order ID(Click for details)</th>
            <th>Billed To</th>
            <th>Patient Name</th>
            <th>Order Date</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Invoice Type</th>
            <th>Shipping Charge</th>
            <th>Total Amount</th>
            <th>Payment Type</th>
            <th>Shipping Address</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $res = mysqli_query($con, "select * from medicine_order");
          while ($row = mysqli_fetch_assoc($res)) {
          ?>
            <tr>
              <td><?php echo $i; ?>.</td>
              <td><a href="medicine_order_details.php?mo_id=<?php echo $row['mo_id']; ?>"><?php echo $row['mo_id']; ?></a></td>
              <td>
                <?php
                $p_name = mysqli_fetch_assoc(mysqli_query($con, "select p_name from patient where p_id={$row['p_id']}"))['p_name'];
                echo $p_name;
                ?>
              </td>
              <td><?php echo $row['ship_p_name']; ?></td>
              <td><?php echo $row['mo_date']; ?></td>
              <td><?php echo $row['mo_email']; ?></td>
              <td><?php echo $row['mo_phn']; ?></td>
              <td>
                <?php
                if ($row['mo_invoice'] == 5) {
                  echo "Print";
                } else {
                  echo "PDF";
                }
                ?>
              <td><?php echo $row['mo_shipping']; ?> Rs/-</td>
              <td><?php echo $row['total_price_all_combined']; ?> Rs/-</td>
              <td><?php echo $row['mo_pay_type']; ?></td>
              <td><?php echo $row['mo_addr']; ?></td>
              <td><?php echo strtoupper($row['status']); ?></td>
            </tr>
          <?php
            $i += 1;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</main>

<?php
require('includes/footer.php');
?>