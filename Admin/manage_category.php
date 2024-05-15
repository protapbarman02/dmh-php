<?php $ROOT = "../";
require('includes/nav.php');
$id = '';
$ct_name = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['ct_id']) && $_GET['ct_id'] != '') {
    $ct_id = $_GET['ct_id'];
    $res = mysqli_query($con, "select * from category where ct_id=$ct_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $ct_name = $row['ct_name'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "category.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $ct_name = trim($_POST['ct_name']);
  if (isset($_POST['ct_id']) && $_POST['ct_id'] != '') {
    $ct_id = $_POST['ct_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_CATEGORIES_LOC . $img);
        $stmt = $con->prepare("update category set ct_name=?, ct_image='$img' where ct_id=$ct_id");
        $stmt->bind_param("s", $ct_name);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("update category set ct_name=? where ct_id=$ct_id");
      $stmt->bind_param("s", $ct_name);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "category.php"
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "category.php";
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
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), category update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Category</h2>
  <div class="admin-medicinecategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Category</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="ct_name" class="form-control-label">Category Name</label>
          <input type="text" name="ct_name" class="form-control" required value="<?php echo $ct_name ?>">
        </div>

        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="category.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="ct_id" value="<?php echo $ct_id; ?>">
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>