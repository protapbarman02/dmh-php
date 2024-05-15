<?php $ROOT = "../";
require('includes/nav.php');
?>
<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Lab Appointments</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="medicine_order.php" class="right-top-link active">Lab Appointments</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineOrders-main">
    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Patient Age</th>
            <th>Patient Gender</th>
            <th>Patient Email</th>
            <th>Patient Phone No.</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Appointment Type</th>
            <th>Appointment Fee</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = mysqli_query($con, "select * from lab_appointment");
          while ($row = mysqli_fetch_assoc($res)) {
            $res2 = mysqli_query($con, "select * from patient where p_id={$row['p_id']}");
            $row2 = mysqli_fetch_assoc($res2);
          ?>
            <tr>
              <td><?php echo $row2['p_name'] ?></td>
              <td><?php echo age($row2['p_dob']) ?></td>
              <td><?php echo $row2['p_gen'] ?></td>
              <td><?php echo $row2['p_email'] ?></td>
              <td><a href="tel:<?php echo $row2['p_phn'] ?>"><?php echo $row2['p_phn'] ?></a></td>
              <td><?php echo $row['lab_app_date'] ?></td>
              <td><?php echo $row['lab_app_time'] ?></td>
              <td><?php echo $row['lab_type'] ?></td>
              <td><?php echo $row['lab_fee'] ?> Rs/-</td>
              <td><?php echo strtoupper($row['lab_status']); ?></td>
              <td><a href="lab_appointment_details.php?lab_id=<?php echo $row['lab_id']; ?>">manage</a></td>
            </tr>
          <?php
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