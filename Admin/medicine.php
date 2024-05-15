<?php $ROOT = "../";
require('includes/nav.php');
$isDelete = 0;
$isInvalidRequest = 0;
$isAdd = 0;
$isAlreadyExist = 0;
$isValidImage = 1;
if (isset($_GET['type']) && ($_GET['type'] != '')) {
  $type = trim($_GET['type']);
  $m_id = $_GET['m_id'];
  $check_sql = "select * from medicine where m_id='$m_id'";
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
      $update_status_sql = "update medicine set m_status=$status where m_id=$m_id";
      mysqli_query($con, $update_status_sql);
    } else if ($type == 'delete') {
      $delete_sql = "delete from medicine where m_id=$m_id";
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
  $m_name = get_safe_value($con, $_POST['m_name']);
  $sp_id = intval($_POST['sp_id']);
  $ct_id = intval($_POST['ct_id']);
  $m_sc_id = intval($_POST['m_sc_id']);
  $mt_id = intval($_POST['mt_id']);
  $m_compose = trim($_POST['m_compose']);
  $m_type = trim($_POST['m_type']);
  $m_short_descr = trim($_POST['m_short_descr']);
  $m_descr = trim($_POST['m_descr']);
  $m_direction = trim($_POST['m_direction']);
  $m_mfg_by = trim($_POST['m_mfg_by']);
  $m_mfg_date = trim($_POST['m_mfg_date']);
  $m_exp_date = trim($_POST['m_exp_date']);
  $m_mrp = intval($_POST['m_mrp']);
  $m_price = intval($_POST['m_price']);
  $m_qty = intval($_POST['m_qty']);
  $qty_per_unit = floatval($_POST['qty_per_unit']);
  $m_unit = trim($_POST['m_unit']);
  $m_gender_spec = trim($_POST['m_gender_spec']);
  $m_age_grp = trim($_POST['m_age_grp']);
  $m_side_effect = trim($_POST['m_side_effect']);
  $res = mysqli_query($con, "select * from medicine where m_name='$m_name'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $isAlreadyExist = 1;
  } else {
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_MEDICINE_LOC . $img);
        $stmt = $con->prepare("INSERT INTO medicine (m_name, sp_id,ct_id, m_sc_id,mt_id, m_type, m_compose, m_short_descr, m_descr, m_direction, m_mfg_by, m_mfg_date, m_exp_date, m_mrp, m_price, m_qty, m_gender_spec, m_age_grp,qty_per_unit,m_unit, m_side_effect, m_image) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, '$img')");
        $stmt->bind_param("siiiissssssssiiississ", $m_name, $sp_id, $ct_id, $m_sc_id, $mt_id, $m_type, $m_compose, $m_short_descr, $m_descr, $m_direction, $m_mfg_by, $m_mfg_date, $m_exp_date, $m_mrp, $m_price, $m_qty, $m_gender_spec, $m_age_grp, $qty_per_unit, $m_unit, $m_side_effect);
        $stmt->execute();
        $stmt->close();
        $isAdd = 1;
      }
    } else {
      $stmt = $con->prepare("INSERT INTO medicine (m_name, sp_id, ct_id, m_sc_id,mt_id, m_type, m_compose, m_short_descr, m_descr, m_direction, m_mfg_by, m_mfg_date, m_exp_date, m_mrp, m_price, m_qty, m_gender_spec, m_age_grp,qty_per_unit,m_unit, m_side_effect, m_image) VALUES (?, ?,?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, 'medicine.png')");
      $stmt->bind_param("siiiissssssssiiississ", $m_name, $sp_id, $ct_id, $m_sc_id, $mt_id, $m_type, $m_compose, $m_short_descr, $m_descr, $m_direction, $m_mfg_by, $m_mfg_date, $m_exp_date, $m_mrp, $m_price, $m_qty, $m_gender_spec, $m_age_grp, $qty_per_unit, $m_unit, $m_side_effect);
      $stmt->execute();
      $stmt->close();
      $isAdd = 1;
    }
  }
}
$res = mysqli_query($con, "SELECT medicine.*, specialization.health_concern, specialization.sp_id, medicine_type.mt_id, medicine_type.mt_name,category.ct_name,medicine_sub_category.m_sc_name FROM medicine INNER JOIN specialization ON medicine.sp_id = specialization.sp_id INNER JOIN medicine_type ON medicine_type.mt_id = medicine.mt_id INNER JOIN category ON medicine.ct_id = category.ct_id INNER JOIN medicine_sub_category ON medicine.m_sc_id = medicine_sub_category.m_sc_id ORDER BY medicine.m_name;");
?>
<section class="admin-right-panel">
  <div class="admin-panel-alert">
    <?php
    if ($isValidImage == 0) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Invalid image format(please use jpg/ jpeg/ png format picture), medicine add failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isAlreadyExist == 1) {
      echo "<div class='bg-warning admin-alert-dismiss-container'>
                    <strong>Warning!</strong> Medicine already exist
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    if ($isDelete == 1) {
      echo "<div class='bg-danger admin-alert-dismiss-container'>
                    <strong>Deleted!</strong> Medicine deleted successfully
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
            <strong>Success!</strong> Medicine added successfully
            <button type='button' class='admin-alert-dismiss-btn'>
                &times;
            </button>
        </div>";
    }
    ?>
  </div>
  <div class="admin-right-top-bar">
    <h2>Medicine</h2>
    <span class="admin-breadcump">
      <a href="index.php" class="right-top-link">Dashboard</a>
      <span> / </span>
      <a href="indexMedicine.php" class="right-top-link">Medicines</a>
      <span> / </span>
      <a href="medicine.php" class="right-top-link active">All Medicines</a>
      <span> / </span>
    </span>
  </div>
  <div class="admin-medicines-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block add-btn-dropdown m-2">Add Medicine</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form admin-add-dorpdown-form-hide" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="m_name" class="form-control-label">Medicine Name</label>
          <input type="text" id="m_name" name="m_name" placeholder="Enter medicine name" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="m_compose" class=" form-control-label">Composition</label>
          <textarea name="m_compose" id="m_compose" rows="3" class="form-control" placeholder="Enter Composition" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="m_short_descr" class="form-control-label">Short Description</label>
          <input type="text" id="m_short_descr" name="m_short_descr" placeholder="Enter Short Description" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="m_descr" class=" form-control-label">Description</label>
          <textarea name="m_descr" id="m_descr" rows="3" class="form-control" placeholder="Enter Description" required></textarea>
        </div>
        <div class="form-group m-2">
          <label for="m_direction" class="form-control-label">Usage Directions</label>
          <input type="text" id="m_direction" name="m_direction" placeholder="Enter Usage Directions" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" placeholder="" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="m_mfg_by" class=" form-control-label">Manufactured By</label>
          <input type="text" id="m_mfg_by" name="m_mfg_by" placeholder="Enter manufacturer's details" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="m_mfg_date" class="form-control-label">Manufacturing Date</label>
            <input type="date" id="m_mfg_date" name="m_mfg_date" placeholder="Enter Mfg-date" class="form-control" required>

          </div>
          <div class="col-6">
            <label for="m_exp_date" class=" form-control-label">Expiry Date</label>
            <input type="date" id="m_exp_date" name="m_exp_date" placeholder="Enter Expiry Date" class="form-control" required>

          </div>
        </div>
        <div class="row p-2">
          <div class="col-4">
            <label for="m_mrp" class="form-control-label">MRP</label>
            <input type="number" id="m_mrp" name="m_mrp" placeholder="Enter MRP" class="form-control" required>

          </div>
          <div class="col-4">
            <label for="m_price" class="form-control-label">Price</label>
            <input type="number" id="m_price" name="m_price" placeholder="Enter Price" class="form-control" required>

          </div>
          <div class="col-4">
            <label for="m_qty" class="form-control-label">Stock Quantity</label>
            <input type="number" id="m_qty" name="m_qty" placeholder="Enter Quantity" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <label for="qty_per_unit" class="form-control-label">Quantity Per Medicine</label>
            <input type="number" id="qty_per_unit" name="qty_per_unit" placeholder="Enter Quantity" class="form-control" required>
          </div>
          <div class="col-3">
            <label for="m_unit" class="form-control-label">Unit(Measured By)</label>
            <select name="m_unit" id="m_unit">
              <option value="unit">Unit</option>
              <option value="ml">ml</option>
              <option value="gm">gm</option>
              <option value="tablet">Tablets</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-3">
            <label for="m_gender_spec" class="form-control-label">Gender Specific</label>
            <select name="m_gender_spec" id="m_gender_spec">
              <option value="All">All</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="col-3">
            <label for="m_age_grp" class=" form-control-label">Age Group</label>
            <select name="m_age_grp" id="m_age_grp">
              <option value="All">All</option>
              <option value="3 months">3 months</option>
              <option value="6 months">6 months</option>
              <option value="12 months">12 months</option>
              <option value="0-2 years">0-2 y</option>
              <option value="2-5 years">2-5 y</option>
              <option value="5-12 years">5-12 y</option>
              <option value="12-18 years">12-18 y</option>
              <option value="Above 12 years">&gt;12 y</option>
              <option value="18-60 years">18-60 y</option>
              <option value="Above 18 years">&gt;18 y</option>
            </select>
          </div>
          <div class="col-3">
            <label for="m_type" class=" form-control-label">Dosage Type</label>
            <select name="m_type" id="m_type">
              <option value="Nil">Select</option>
              <option value="Tablet">Tablet</option>
              <option value="Syrup">Syrup</option>
              <option value="Capsule">Capsule</option>
              <option value="Drop">Drop</option>
              <option value="Lotion">Lotion</option>
              <option value="Inhaler">Inhaler</option>
              <option value="Injection">Injection</option>
              <option value="Patches">Patches</option>
              <option value="Sublingual">Sublingual</option>
              <option value="Oral">Oral</option>
              <option value="Others">Others</option>
            </select>
          </div>

        </div>
        <div class="row p-2">
          <div class="col-3">
            <label for="sp_id" class="form-control-label">Health Concern</label>
            <select name="sp_id" id="sp_id">
              <option value="1">Select</option>
              <?php
              $result = mysqli_query($con, "select sp_id, health_concern from specialization where sp_id !=1 and health_concern != '' order by sp_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['sp_id']; ?>"><?php echo $data['health_concern']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-3">
            <label for="ct_id" class="form-control-label">Category</label>
            <select name="ct_id" id="ct_id">
              <option value="1">Select</option>
              <?php
              $result = mysqli_query($con, "select ct_id, ct_name from category where ct_id !=1 order by ct_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['ct_id']; ?>"><?php echo $data['ct_name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-3">
            <label for="m_sc_id" class="form-control-label">Sub Category</label>
            <select name="m_sc_id" id="m_sc_id">
              <option value="1">Select</option>

            </select>
          </div>
          <div class="col-3">
            <label for="mt_id" class="form-control-label">Medicine Type</label>
            <select name="mt_id" id="mt_id">
              <option value="1">Select</option>
              <?php
              $result = mysqli_query($con, "select * from medicine_type where mt_id !=1 order by mt_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['mt_id']; ?>"><?php echo $data['mt_name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="m_side_effect" class="form-control-label">Side Effects</label>
          <textarea name="m_side_effect" id="m_side_effect" rows="3" class="form-control" placeholder="Enter Side Effects" required></textarea>
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
            <th>Medicine Name</th>
            <th>Health Concern</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Type</th>
            <th>Dosage Type</th>
            <th>Image</th>
            <th>MRP</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Expiry Date</th>
            <th>Gender Spec</th>
            <th>Age Group</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
              <td class="serial"><?php echo $i++ ?></td>
              <td><?php echo $row['m_name'] ?></td>
              <td><?php echo $row['health_concern'] ?></td>
              <td><?php echo $row['ct_name'] ?></td>
              <td><?php echo $row['m_sc_name'] ?></td>
              <td><?php echo $row['mt_name'] ?></td>
              <td><?php echo $row['m_type'] ?></td>
              <?php if ($row['m_image'] == '') { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_ICON_LOC; ?>unavailable.png" /></td>
              <?php } else { ?>
                <td class="admin-table-img-cont"><img class="admin-table-img" src="<?php echo SITE_IMAGE_MEDICINE_LOC . $row['m_image']; ?>" /></td>
              <?php } ?>
              <td><?php echo $row['m_mrp'] ?></td>
              <td><?php echo $row['m_price'] ?></td>
              <td><?php echo $row['m_qty'] ?></td>
              <td><?php echo $row['m_exp_date'] ?></td>
              <td><?php echo $row['m_gender_spec'] ?></td>
              <td><?php echo $row['m_age_grp'] ?></td>
              <td>
                <div class="admin-manage-td">
                  <?php
                  if ($row['m_status'] == 1) {
                    echo "<span class='btn btn-success'><a href='?type=status&operation=deactive&m_id=" . $row['m_id'] . "' class='manage-links'> Actived </a></span>&nbsp;";
                  } else {
                    echo "<span class='btn btn-danger'><a href='?type=status&operation=active&m_id=" . $row['m_id'] . "' class='manage-links'>Deactived</a></span>&nbsp;";
                  }
                  echo "<span class='btn btn-warning'><a href='manage_medicine.php?type=edit&m_id=" . $row['m_id'] . "' class='manage-links'>Edit</a></span>&nbsp;";
                  echo "<span class='btn btn-danger'><a href='?type=delete&m_id=" . $row['m_id'] . "' class='manage-links'>Delete</a></span>";
                  ?>
                </div>
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
  $(document).ready(() => {
    $(".add-btn-dropdown").click(() => {
      $(".field_error").html('');
      $(".admin-add-dorpdown-form").toggleClass("admin-add-dorpdown-form-hide");
    });
    $(".admin-alert-dismiss-btn").click(() => {
      $(".admin-alert-dismiss-container").css("display", "none");
    });

    $("#ct_id").on("change", () => {
      ct_id = $("#ct_id").val();
      $.ajax({
        url: "get_medicine_sub_cat.php",
        method: "post",
        data: "ct_id=" + ct_id,
        success: function(result) {
          $("#m_sc_id").html(result);
        }
      });
    })
  })
</script>
<?php
require('includes/footer.php');
?>