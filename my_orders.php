<?php $ROOT = "";
$page = 'order';
require("includes/profile_nav.php");
?>
<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
  <h3 class="text-center border-bottom border-info py-2">Medicine Orders</h3>
  <div class="container-fluid d-flex flex-column">
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>Order Amount</th>
          <th>Payment Type</th>
          <th>Order Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $res = mysqli_query($con, "select mo_id,total_price_all_combined,mo_pay_type,mo_date,status from medicine_order where p_id={$_SESSION['uid']} order by mo_id desc");
        while ($row = mysqli_fetch_assoc($res)) {
        ?>
          <tr>
            <td><a href="my_order_details.php?mo_id=<?php echo $row['mo_id']; ?>">(View)</a></td>
            <td><span><?php echo $row['total_price_all_combined']; ?></span> Rs/-</td>
            <td><?php echo strtoupper($row['mo_pay_type']); ?></td>
            <td><?php echo $row['mo_date']; ?></td>
            <td><?php echo $row['status']; ?></td>
          </tr>
        <?php
        }
        ?>

      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</main>
<script>

</script>
<?php
include("$ROOT" . "includes/footer.php");
?>