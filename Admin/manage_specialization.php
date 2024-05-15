<?php $ROOT = "../";
require('includes/nav.php');
$id = '';
$sp_name = '';
$health_concern = '';
$descr = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['sp_id']) && $_GET['sp_id'] != '') {
    $sp_id = $_GET['sp_id'];
    $res = mysqli_query($con, "select * from specialization where sp_id=$sp_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $sp_name = $row['sp_name'];
      $sp_descr = $row['sp_descr'];
      $health_concern = $row['health_concern'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "specialization.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $sp_name = trim($_POST['sp_name']);
  $sp_descr = trim($_POST['sp_descr']);
  $health_concern = trim($_POST['health_concern']);
  if (isset($_POST['sp_id']) && $_POST['sp_id'] != '') {
    $sp_id = $_POST['sp_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_SPECIALIZATION_LOC . $img);
        $stmt = $con->prepare("update specialization set sp_name=?, sp_descr=?, health_concern=?, sp_image='$img' where sp_id=$sp_id");
        $stmt->bind_param("sss", $sp_name, $sp_descr, $health_concern);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("update specialization set sp_name=?, sp_descr=?, health_concern=? where sp_id=$sp_id");
      $stmt->bind_param("sss", $sp_name, $sp_descr, $health_concern);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "specialization.php"
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "specialization.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), specialization update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>specialization</h2>
  <div class="admin-medicinespecialization-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Specialization</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="sp_name" class="form-control-label">Specialization Name</label>
          <input type="text" name="sp_name" class="form-control" required value="<?php echo $sp_name ?>">
        </div>
        <div class="form-group m-2">
          <label for="health_concern" class="form-control-label">Health Concern</label>
          <input type="text" name="health_concern" id="health_concern" value="<?php echo $health_concern ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="sp_descr" class=" form-control-label">Description</label>
          <input type="text" name="sp_descr" class="form-control" required value="<?php echo $sp_descr ?>">
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="specialization.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="sp_id" value="<?php echo $sp_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>