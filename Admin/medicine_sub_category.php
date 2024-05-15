<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $m_sc_id = $_GET['m_sc_id'];
  $check_sql = "select * from medicine_sub_category where m_sc_id='$m_sc_id'";
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
      $update_status_sql = "update medicine_sub_category set m_sc_status=$status where m_sc_id=$m_sc_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from medicine_sub_category where m_sc_id=$m_sc_id";
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
  $m_sc_name = trim($_POST['m_sc_name']);
  $ct_id = intval($_POST['ct_id']);
  $res = mysqli_query($con, "select * from medicine_sub_category where m_sc_name='$m_sc_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    $stmt = $con->prepare("INSERT INTO medicine_sub_category (m_sc_name,ct_id) VALUES (?,?)");
    $stmt->bind_param("si", $m_sc_name, $ct_id);
    $stmt->execute();
    $stmt->close();
    $isAdd = 1;
  }
}

$sql = "select medicine_sub_category.*,category.ct_name from medicine_sub_category inner join category on medicine_sub_category.ct_id=category.ct_id where medicine_sub_category.m_sc_id !=1 order by 'm_sc_name'";
$res = mysqli_query($con, $sql);
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> medicine_Sub Category already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Medicine Sub Category deleted successfully
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
            <strong>Success!</strong> Medicine Sub Category added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Medicine Sub Category</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexMedicine.php" class="right-top-link">Medicines</a>
      <span> / </span>
      <a href="medicine_sub_category.php" class="right-top-link active">Sub Categories</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Medicine Sub Category</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide">
        <!-- add Sub Category form -->
        <div class="row">
          <div class="col">
            <label for="m_sc_name" class="form-control-label">Medicine Sub Category Name</label>
            <input type="text" name="m_sc_name" id="m_sc_name" placeholder="Enter Sub Category name" class="form-control" required>
          </div>
          <div class="col">
            <label for="ct_id" class=" form-control-label">Category</label>
            <select name="ct_id" id="ct_id" class="form-control">
              <option value="1">Nil</option>
              <?php
              $result = mysqli_query($con, "select * from category where ct_id!=1 and ct_name != '' order by ct_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['ct_id']; ?>"><?php echo $data['ct_name']; ?></option>
              <?php } ?>
            </select>
          </div>
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
            <th>Sub Category Name</th>
            <th>Category</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $row['m_sc_id'] ?></td>
              <td><?php echo $row['m_sc_name'] ?></td>
              <td><?php echo $row['ct_name'] ?></td>
              <td class="admin-manage-td">
                <?php
                if ($row['m_sc_status'] == 1) {
                  echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&m_sc_id=" . $row['m_sc_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                } else {
                  echo "<span class='btn btn-danger'><a href='?type=status&operation=active&m_sc_id=" . $row['m_sc_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                }
                echo "<span class='btn btn-warning'><a href='manage_medicine_sub_category.php?type=edit&m_sc_id=" . $row['m_sc_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                echo "<span class='btn btn-danger'><a href='?type=delete&m_sc_id=" . $row['m_sc_id'] . "' class='manage-links'>Delete</a></span>";
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