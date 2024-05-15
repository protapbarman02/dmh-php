<?php $ROOT = "";
$page = 'doc_apps';
require("includes/profile_nav.php");
?>
<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
  <h3 class="text-center border-bottom border-info py-2">Doctor Appointments</h3>
  <div class="container-fluid d-flex flex-column">
    <table class="table">
      <thead>
        <tr>
          <th>Doctor</th>
          <th>Date</th>
          <th>Time</th>
          <th>Mode</th>
          <th>Fee</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $res = mysqli_query($con, "select doc_appointment.doc_a_fee,doc_appointment.d_id,doc_appointment.doc_a_date,doc_appointment.doc_a_time,doc_appointment.doc_a_status,doc_appointment.doc_a_mode,doctor.d_name from doc_appointment inner join doctor on doc_appointment.d_id=doctor.d_id where doc_appointment.p_id={$_SESSION['uid']} order by doc_appointment.doc_a_id desc");
        while ($row = mysqli_fetch_assoc($res)) {
        ?>
          <tr>
            <td><span><?php echo $row['d_name']; ?></span></td>
            <td><?php echo formatDate($row['doc_a_date']); ?></td>
            <td><?php echo convertTo12HourFormat($row['doc_a_time']); ?></td>
            <?php
            if ($row['doc_a_mode'] == 'offline') {
              echo "<td>Chamber Visit</td>";
            } else {
              echo "<td>Online Consultation</td>";
            }
            ?>
            <td><?php echo $row['doc_a_fee']; ?> Rs/-</td>
            <td><?php
                if ($row['doc_a_status'] == 'cancelled') {
                  echo "<span class='text-danger'>" . $row['doc_a_status'] . "</span>";
                } else if ($row['doc_a_status'] == 'confirmed') {
                  echo "<span class='text-warning'>" . $row['doc_a_status'] . "</span>";
                } else if ($row['doc_a_status'] == 'completed') {
                  echo "<span class='text-success'>" . $row['doc_a_status'] . "</span>";
                }
                ?>
            </td>
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