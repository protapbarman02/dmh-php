<?php
$ROOT = "../";
require("nav.php");
$res = mysqli_query($con, "select doc_appointment.*, patient.p_image from doc_appointment inner join patient on doc_appointment.p_id=patient.p_id where d_id=$d_id and doc_appointment.doc_a_status!='canceled' ORDER BY CAST(doc_appointment.doc_a_time AS TIME) DESC");
?>
<section class="admin-right-panel" style="background-color:white;height:100vh;overflow-y:scroll;">
  <div class="d-flex justify-content-between bg-light m-0 px-4">
    <p><a href="index.php" class="text-dark text-decoration-none">DASHBOARD</a> / <a href="" class="text-dark text-decoration-none">All Appointments</a></p>
    <p><?php echo date('l, F jS Y'); ?></p>
  </div>
  <div class="container">
    <table class="table m-2 p-4" style="width:100%;">
      <thead>
        <tr>
          <th>Patient Image</th>
          <th>Patient Name</th>
          <th>Patient Phone No.</th>
          <th>Patient Problem</th>
          <th>Date</th>
          <th>Time</th>
          <th>Mode</th>
          <th>Paid</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
        ?>
            <tr class="schedule-single">
              <td class="p-2"><img src="<?php echo SITE_IMAGE_PATIENT_LOC . $row['p_image']; ?>" alt="" style="height:30px;width:30px;" class="border rounded-circle"></td>
              <td class="p-2"><?php echo $row['p_name']; ?></td>
              <td class="p-2"><?php echo $row['p_phn']; ?></td>
              <td class="p-2">
                <div style="width:200px;word-wrap:break-word;">
                  <?php echo $row['doc_a_note']; ?>
                </div>
              </td>
              <td class="p-2"><?php echo formatDate($row['doc_a_date']); ?></td>
              <td class="p-2"><?php echo convertTo12HourFormat($row['doc_a_time']); ?></td>
              <td class="p-2"><?php echo $row['doc_a_mode']; ?></td>
              <td class="p-2"><?php echo $row['doc_a_fee']; ?> Rs/-</td>
              <td class="p-2"><?php echo $row['doc_a_status']; ?></td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td>Empty</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</section>
</main>
<script>
  $("#descr-icon").on("click", () => {
    $("#desc-tr").toggleClass("descr-hide");
  })
</script>
<?php
require("$ROOT" . "admin/footer.php");
?>