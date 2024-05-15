<?php $ROOT = "../";
require('includes/nav.php');
$id = '';
$mt_name = '';
$mt_descr = '';
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['mt_id']) && $_GET['mt_id'] != '') {
    $mt_id = $_GET['mt_id'];
    $res = mysqli_query($con, "select * from medicine_type where mt_id=$mt_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $mt_name = $row['mt_name'];
      $mt_descr = $row['mt_descr'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "medicine_type.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $mt_name = trim($_POST['mt_name']);
  $mt_descr = trim($_POST['mt_descr']);
  if (isset($_POST['mt_id']) && $_POST['mt_id'] != '') {
    $mt_id = $_POST['mt_id'];
    $stmt = $con->prepare("UPDATE medicine_type SET mt_name=?, mt_descr=? WHERE mt_id=$mt_id");
    $stmt->bind_param("ss", $mt_name, $mt_descr);
    $stmt->execute();
    $stmt->close();
    ?>
    <script>
      window.location.href = "medicine_type.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "medicine_type.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <h2>Medicine Type</h2>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Medicine Type</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form">
        <div class="form-group m-2">
          <label for="mt_name" class="form-control-label">Medicine Type Name</label>
          <input type="text" name="mt_name" class="form-control" required value="<?php echo $mt_name ?>">
        </div>
        <div class="form-group m-2">
          <label for="mt_descr" class=" form-control-label">Description</label>
          <input type="text" name="mt_descr" class="form-control" required value="<?php echo $mt_descr ?>">
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="medicine_type.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="mt_id" value="<?php echo $mt_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>