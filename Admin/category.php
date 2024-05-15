<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $ct_id = $_GET['ct_id'];
  $check_sql = "select * from category where ct_id='$ct_id'";
  $res = mysqli_query($con, $check_sql);
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    if ($type == 'status') {
      $operation = $_GET['operation'];
      if ($operation == 'active') {
        $status = '1';
      } else {
        $status = '0';
      }
      $update_status_sql = "update category set ct_status=$status where ct_id=$ct_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from category where ct_id=$ct_id";
      $res = mysqli_query($con, $delete_sql);
      if ($res) {
        $isDelete = 1;
      } else {
        //delete failed
      }
    }
  } else {
    $isInvalidRequest = 1;
  }
}

if (isset($_POST['submit']) && $_POST['submit'] != '') {
  $ct_name = trim($_POST['ct_name']);
  $res = mysqli_query($con, "select * from category where ct_name='$ct_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_CATEGORIES_LOC . $img);
        $stmt = $con->prepare("INSERT INTO category (ct_name,ct_image) VALUES (?, '$img')");
        $stmt->bind_param("s", $ct_name);
        $stmt->execute();
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO category (ct_name) VALUES (?)");
      $stmt->bind_param("s", $ct_name);
      $stmt->execute();
      $stmt->close();
      $isAdd = 1;
    }
  }
}
$sql = "select * from category where ct_id!=1 order by ct_name";
$res = mysqli_query($con, $sql);
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(use jpg/hpeg/png), category add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> category already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isInvalidRequest == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
            <strong>Warning!</strong> Invalid request, please go to dashboard and come back on this page
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> category deleted successfully
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }

    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> category added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Category</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexMedicine.php" class="right-top-link">Medicine</a>
      <span> / </span>
      <a href="category.php" class="right-top-link active">Category</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicinecategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Category</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="ct_name" class="form-control-label">Category Name</label>
          <input type="text" name="ct_name" id="ct_name" placeholder="Enter category name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="m-2">
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Add</button>
        </div>
      </form>
    </div>
    <div class="admin-table-container">
      <table class="table">
        <thead>
          <tr>
            <th class="serial">#</th>
            <th>Category Name</th>
            <th>Image</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['ct_name'] ?></td>
              <?php if ($row['ct_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC ?>unavailable.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_CATEGORIES_LOC . $row['ct_image']; ?>" /></td>
              <?php } ?>
              <td class="admin-manage-td">
                <?php
                if ($row['ct_status'] == 1) {
                  echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&ct_id=" . $row['ct_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                } else {
                  echo "<span class='btn btn-danger'><a href='?type=status&operation=active&ct_id=" . $row['ct_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                }
                echo "<span class='btn btn-warning'><a href='manage_category.php?type=edit&ct_id=" . $row['ct_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&ct_id=" . $row['ct_id'] . "' class='manage-links'>Delete</a></span>";
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</main>
<script>
  $(".add-btn-dropdown").click(() => {
    $(".field_error").html('');
    $(".admin-add-dorpdown-form").toggleClass("admin-add-dorpdown-form-hide");
  });
  $(".admin-alert-dismiss-btn").click(() => {
    $(".admin-alert-dismiss-container").css("display", "none");
  });
</script>
<?php
require('includes/footer.php');
?>