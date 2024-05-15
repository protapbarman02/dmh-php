<?php $ROOT = "";
$page = 'address';
require("includes/profile_nav.php");
$addr_res = mysqli_query($con, "select addr_id from addr where user_type='patient' and user_id={$_SESSION['uid']}");
$addr_id = '';
$username = '';
$addr_phn = '';
$addr_line = '';
$addr_city = '';
$addr_landmark = '';
$addr_state = '';
$addr_district = '';
$addr_pin = '';
if (isset($_GET['type'])) {
  $type = get_safe_value($con, $_GET['type']);
  if ($type == "edit") {
    $addr_id = get_safe_value($con, $_GET['addr_id']);
    $addr_res = mysqli_query($con, "select * from addr where addr_id=$addr_id");
    while ($addr_row = mysqli_fetch_assoc($addr_res)) {
      $username = $addr_row['user_name'];
      $addr_phn = $addr_row['addr_phn'];
      $addr_line = $addr_row['addr_line'];
      $addr_city = $addr_row['addr_city'];
      $addr_landmark = $addr_row['addr_landmark'];
      $addr_state = $addr_row['addr_state'];
      $addr_district = $addr_row['addr_district'];
      $addr_pin = $addr_row['addr_pin'];
    }
  }
}
if (isset($_POST['submit'])) {
  $addr_phn = $_POST['phone'];
  $addr_line = $_POST['addrLine'];
  $addr_city = $_POST['city'];
  $addr_landmark = $_POST['landmark'];
  $addr_state = $_POST['state'];
  $addr_district = $_POST['district'];
  $addr_pin = $_POST['pin'];

  if (isset($_POST['type'])) {
    $type = get_safe_value($con, $_POST['type']);
    if ($type == "edit") {
      $addr_id = get_safe_value($con, $_POST['addr_id']);
      mysqli_query($con, "UPDATE addr SET user_name = '$username',addr_phn = '$addr_phn',addr_line = '$addr_line',addr_city = '$addr_city',addr_landmark = '$addr_landmark',addr_state = '$addr_state',addr_district = '$addr_district',addr_pin = '$addr_pin' WHERE addr_id = $addr_id");
    } else if ($type == "add") {
      if (mysqli_num_rows($addr_res) <= 0) {
        mysqli_query($con, "INSERT INTO addr (user_type, user_id, user_name, addr_phn,addr_email, addr_line, addr_city, addr_landmark, addr_state, addr_district, addr_pin, addr_status) VALUES ('patient',{$_SESSION['uid']},'$p_name', '$addr_phn','$p_email', '$addr_line', '$addr_city', '$addr_landmark', '$addr_state', '$addr_district', '$addr_pin', 1)");
      } else {
        $username = $_POST['name'];
        mysqli_query($con, "INSERT INTO addr (user_type, user_id, user_name, addr_phn,addr_email, addr_line, addr_city, addr_landmark, addr_state, addr_district, addr_pin, addr_status) VALUES ('patient',{$_SESSION['uid']},'$username', '$addr_phn','$p_email', '$addr_line', '$addr_city', '$addr_landmark', '$addr_state', '$addr_district', '$addr_pin', 0)");
      }
    }
?>
    <script>
      window.location.href = "my_address.php";
    </script>
<?php
  }
}
?>
<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
  <h3 class="text-center border-bottom border-info py-2">Addresses</h3>
  <div class="container-fluid d-flex flex-column">
    <form class="contact-form m-2 p-2" method="post" action="">
      <div class="row border-bottom">
        <div class="col-md-12 form-group">
          <?php
          if (mysqli_num_rows($addr_res) > 0) {
          ?>
            <label for="name">Full Name </label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $username; ?>">
          <?php } ?>
        </div>
        <div class="col-md-12 form-group">
          <label for="phone">Phone No. </label>
          <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $addr_phn; ?>">
        </div>

        <div class="col-md-12 form-group">
          <label for="addrLine">Address Line</label>
          <input type="text" class="form-control" id="addrLine" name="addrLine" value="<?php echo $addr_line; ?>">
        </div>
        <div class="col-md-6 form-group">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" name="city" value="<?php echo $addr_city; ?>">
        </div>
        <div class="col-md-6 form-group">
          <label for="landmark">Landmark</label>
          <input type="text" class="form-control" id="landmark" name="landmark" value="<?php echo $addr_landmark; ?>">
        </div>

        <div class="col-md-6 form-group">
          <label for="state">State</label>
          <select class="form-control" aria-placeholder="State" name="state">
            <?php
            if ($type != "edit") {
              echo '<option value="West Bengal">West Bengal</option>';
            } else {
              echo '<option value="' . $addr_state . '">' . $addr_state . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label for="district">District</label>
          <select class="form-control" name="district" required>
            <?php
            if ($type != "edit") {
              echo "<option value='' disabled selected hidden>District</option>";
            } else {
            ?>
              <option value="<?php echo $addr_district; ?>"><?php echo $addr_district; ?></option>
            <?php
            }
            ?>
            <option value="Alipurduar">Alipurduar</option>
            <option value="Jalpaiguri">Cooch Behar</option>
            <option value="Jalpaiguri">Jalpaiguri</option>
          </select>
        </div>
        <div class="col-md-6 form-group">
          <label for="pin">Pin code</label>
          <input type="text" class="form-control" id="pin" name="pin" value="<?php echo $addr_pin; ?>">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
          <button type="button" class="btn border-danger rounded-0"><a href="my_address.php" class="text-danger">Cancel</a></button>
          <button type="submit" name="submit" class="btn book-btn-medi">Save</button>
        </div>
      </div>
      <input type="hidden" name="type" value="<?php echo $type; ?>">
      <input type="hidden" name="addr_id" value="<?php echo $addr_id; ?>">
    </form>
  </div>
</div>
</div>
</div>
</main>

<?php
include("$ROOT" . "includes/footer.php");
?>