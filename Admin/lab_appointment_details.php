<?php $ROOT = "../";
require('includes/nav.php');
if (isset($_GET['lab_id'])) {
  $lab_id = get_safe_value($con, $_GET['lab_id']);
  $res = mysqli_query($con, "select lab_appointment.*, patient.p_name from lab_appointment inner join patient on lab_appointment.p_id=patient.p_id where lab_appointment.lab_id=$lab_id");
  $row = mysqli_fetch_assoc($res);
  $name = $row['p_name'];
  $date = $row['lab_app_date'];
  $time = $row['lab_app_time'];
  $status = $row['lab_status'];
} else {
?>
  <script>
    window.location.href = "medicine_order.php";
  </script>
<?php
  exit();
}

?>
<section class="admin-right-panel">
  <div class="admin-right-top-bar">
    <h2>Manage Appointment</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="lab_appointment.php" class="right-top-link">Lab Appointments</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineOrders-main">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 col-sm-12 col-12 mt-4 border shadow rounded p-4">
        <h4 class="mb-2 text-center">Manage Lab Appointment</h4>
        <form id="appointment">
          <div class="mt-4">
            <label class="form-label">Patient Name</label>
            <input type="text" value="<?php echo $name; ?>" readonly disabled class="form-control">
          </div>
          <div class="my-3">
            <label class="form-label">Appointment Date</label>
            <input type="text" value="<?php echo $date; ?>" class="form-control" readonly disabled>
          </div>
          <div class="mb-3 my-2 text-center">
            <label for="status" class="form-label">Appointment status</label>
            <select name="status" id="status" class="form-control mt-2 p-1 w-100 border">
              <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
              <option value="confirmed">Confirmed</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>
          <div class="mb-3 text-center">
            <label for="time" class="form-label">Appointment Time</label>
            <input type="time" name="time" id="time" class="form-control" value="<?php echo $time; ?>">
          </div>
          <input type="hidden" name="lab_id" id="lab_id" value="<?php echo $lab_id; ?>">
          <div class="mb-3 text-center border rounded p-2">
            <button type="submit" class="btn btn-success w-100">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>
<script>
  $("#appointment").on("submit", (e) => {
    e.preventDefault()
    if ($("#status").val() != 'request recieved' && $("#time").val() == '00:00:00') {
      alert("time is not set so can not change status to confirmed/completed")
    } else {
      $.ajax({
        method: "POST",
        url: "update_lab_app_details.php",
        data: {
          lab_id: $("#lab_id").val(),
          status: $("#status").val(),
          time: $("#time").val()
        },
        success: function(result) {
          window.location.href = "lab_appointment.php";
        }
      })
    }
  })
</script>
<?php
require('includes/footer.php');
?>