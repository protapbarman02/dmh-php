<?php $ROOT = "../";
require('includes/nav.php');
$res = mysqli_query($con, "select doc_appointment.*,d_name from doc_appointment inner join doctor on doc_appointment.d_id=doctor.d_id order by doc_a_date and doc_a_time;");
?>
<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Doctor Appointments</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexAppointments.php" class="right-top-link">Appointments</a>
      <span> / </span>
      <a href="doctor_appointment.php" class="right-top-link active">Doctor Appointments</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-doctors-main">

    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th class="serial">#</th>
            <th>Patient Name</th>
            <th>Patient Age</th>
            <th>Patient Gender</th>
            <th>Patient Email</th>
            <th>Patient Phone No.</th>
            <th>Doctor Name</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Appointment Mode</th>
            <th>Appointment Fee</th>
            <th>Status</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['p_name'] ?></td>
              <td><?php echo age($row['p_dob']) ?></td>
              <td><?php echo $row['p_gender'] ?></td>
              <td><?php echo $row['p_email'] ?></td>
              <td><?php echo $row['p_phn'] ?></td>
              <td><?php echo $row['d_name'] ?></td>
              <td><?php echo $row['doc_a_date'] ?></td>
              <td><?php echo $row['doc_a_time'] ?></td>
              <td><?php echo $row['doc_a_mode'] ?></td>
              <td><?php echo $row['doc_a_fee'] ?></td>
              <td><?php echo strtoupper($row['doc_a_status']) ?></td>
              <td><a href="doc_appointment_details.php?doc_a_id=<?php echo $row['doc_a_id']; ?>">manage</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</main>

<?php
require('includes/footer.php');
?>