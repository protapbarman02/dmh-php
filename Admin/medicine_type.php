<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $mt_id = $_GET['mt_id'];
  $check_sql = "select * from medicine_type where mt_id='$mt_id'";
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
      $update_status_sql = "update medicine_type set mt_status=$status where mt_id=$mt_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from medicine_type where mt_id=$mt_id";
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
  $mt_name = trim($_POST['mt_name']);
  $mt_descr = trim($_POST['mt_descr']);
  $res = mysqli_query($con, "select * from medicine_type where mt_name='$mt_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    $stmt = $con->prepare("INSERT INTO medicine_type (mt_name, mt_descr) VALUES (?, ?)");
    $stmt->bind_param("ss", $mt_name, $mt_descr);
    $stmt->execute();
    $stmt->close();
    $isAdd = 1;
  }
}

$sql = "select * from medicine_type order by mt_name";
$res = mysqli_query($con, $sql);
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> medicine_type already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Medicine Type deleted successfully
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

    if ($isAdd == 1) {
      echo "<div class='bg-success admin-alert-dismiss-container'>
            <strong>Success!</strong> Medicine Type added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Medicine Types</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexMedicine.php" class="right-top-link">Medicines</a>
      <span> / </span>
      <a href="medicine_type.php" class="right-top-link active">Types</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Medicine Type</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide">
        <!-- add Type form -->
        <div class="form-group m-2">
          <label for="mt_name" class="form-control-label">Medicine Type Name</label>
          <input type="text" name="mt_name" id="mt_name" placeholder="Enter Type name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="mt_descr" class=" form-control-label">Description</label>
          <input type="text" name="mt_descr" id="mt_descr" placeholder="Enter Type Description" class="form-control" required>
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
            <th>Type Name</th>
            <th>Description</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['mt_name'] ?></td>
              <td class="truncated-text" style="max-width: 300px;"><?php echo $row['mt_descr'] ?></td>
              <td class="admin-manage-td">
                <?php
                if ($row['mt_status'] == 1) {
                  echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&mt_id=" . $row['mt_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                } else {
                  echo "<span class='btn btn-danger'><a href='?type=status&operation=active&mt_id=" . $row['mt_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                }
                echo "<span class='btn btn-warning'><a href='manage_medicine_type.php?type=edit&mt_id=" . $row['mt_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&mt_id=" . $row['mt_id'] . "' class='manage-links'>Delete</a></span>";
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