<?php $ROOT = "../";
require('includes/nav.php');
$m_id = '';
$m_name = '';
$sp_id = '';
$m_sc_name = '';
$mt_id = '';
$health_concern = '';
$ct_name = '';
$m_compose = '';
$m_type = '';
$m_short_descr = '';
$m_descr = '';
$m_direction = '';
$m_mfg_by = '';
$m_mfg_date = '';
$m_exp_date = '';
$m_mrp = '';
$m_price = '';
$m_qty = '';
$m_unit = '';
$qty_per_unit = '';
$m_gender_spec = '';
$m_age_grp = '';
$m_side_effect = '';
$isValidImage = 1;
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['m_id']) && $_GET['m_id'] != '') {
    $m_id = $_GET['m_id'];
    $res = mysqli_query($con, "select * from medicine where m_id=$m_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $m_name = $row['m_name'];
      $ct_id = $row['ct_id'];
      $sp_id = $row['sp_id'];
      $m_sc_id = $row['m_sc_id'];
      $mt_id = $row['mt_id'];
      $m_compose = $row['m_compose'];
      $m_type = $row['m_type'];
      $m_short_descr = $row['m_short_descr'];
      $m_descr = $row['m_descr'];
      $m_direction = $row['m_direction'];
      $m_mfg_by = $row['m_mfg_by'];
      $m_mfg_date = $row['m_mfg_date'];
      $m_exp_date = $row['m_exp_date'];
      $m_mrp = $row['m_mrp'];
      $m_price = $row['m_price'];
      $m_qty = $row['m_qty'];
      $qty_per_unit = $row['qty_per_unit'];
      $m_unit = $row['m_unit'];
      $m_gender_spec = $row['m_gender_spec'];
      $m_age_grp = $row['m_age_grp'];
      $m_side_effect = $row['m_side_effect'];
      $health_concern = mysqli_fetch_assoc(mysqli_query($con, "SELECT health_concern FROM specialization WHERE specialization.sp_id=$sp_id;"))['health_concern'];
      $ct_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT ct_name FROM category WHERE category.ct_id=$ct_id;"))['ct_name'];
      $mt_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT mt_name FROM medicine_type WHERE medicine_type.mt_id=$mt_id;"))['mt_name'];
      $m_sc_name = mysqli_fetch_assoc(mysqli_query($con, "select m_sc_name from medicine_sub_category where m_sc_id=$m_sc_id"))['m_sc_name'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "medicine.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $m_name = trim($_POST['m_name']);
  $ct_id = intval($_POST['ct_id']);
  $sp_id = intval($_POST['sp_id']);
  $m_sc_id = intval($_POST['m_sc_id']);
  $mt_id = intval($_POST['mt_id']);
  $sp_id = intval($_POST['sp_id']);
  $m_sc_id = intval($_POST['m_sc_id']);
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

  if (isset($_POST['m_id']) && $_POST['m_id'] != '') {
    $m_id = $_POST['m_id'];
    if ($_FILES['image']['name'] != '') {
      if ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg') {
        $isValidImage = 0;
      } else {
        $img = rand(1111, 9999) . '' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_IMAGE_MEDICINE_LOC . $img);
        $stmt = $con->prepare("UPDATE medicine SET m_name=?, ct_id=?, sp_id=?, m_sc_id=?, mt_id=?, m_type=?, m_compose=?, m_short_descr=?, m_descr=?, m_direction=?, m_mfg_by=?, m_mfg_date=?, m_exp_date=?, m_mrp=?, m_price=?, m_qty=?, qty_per_unit=?,m_unit=?, m_gender_spec=?, m_age_grp=?, m_side_effect=?, m_image='$img' WHERE m_id=$m_id");
        $stmt->bind_param("siiiissssssssiiiissss", $m_name, $ct_id, $sp_id, $m_sc_id, $mt_id, $m_type, $m_compose, $m_short_descr, $m_descr, $m_direction, $m_mfg_by, $m_mfg_date, $m_exp_date, $m_mrp, $m_price, $m_qty, $qty_per_unit, $m_unit, $m_gender_spec, $m_age_grp, $m_side_effect);
        $stmt->execute();
        $stmt->close();
      }
    } else {
      $stmt = $con->prepare("UPDATE medicine SET m_name=?, ct_id=?, sp_id=?, m_sc_id=?, mt_id=?, m_type=?, m_compose=?, m_short_descr=?, m_descr=?, m_direction=?, m_mfg_by=?, m_mfg_date=?, m_exp_date=?, m_mrp=?, m_price=?, m_qty=?,qty_per_unit=?,m_unit=?, m_gender_spec=?, m_age_grp=?, m_side_effect=? WHERE m_id=$m_id");
      $stmt->bind_param("siiiissssssssiiiissss", $m_name, $ct_id, $sp_id, $m_sc_id, $mt_id, $m_type, $m_compose, $m_short_descr, $m_descr, $m_direction, $m_mfg_by, $m_mfg_date, $m_exp_date, $m_mrp, $m_price, $m_qty, $qty_per_unit, $m_unit, $m_gender_spec, $m_age_grp, $m_side_effect);
      $stmt->execute();
      $stmt->close();
    }
    ?>
    <script>
      window.location.href = "medicine.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "medicine.php";
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
                    <strong>Warning!</strong> Invalid image format, medicine update failed
                    <button type='button' class='admin-alert-dismiss-btn'>&times;</button>
                </div>";
    }
    ?>
  </div>
  <h2>Medicine</h2>
  <div class="admin-medicines-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Medicine Details</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form" enctype="multipart/form-data">
        <div class="form-group m-2">
          <label for="m_name" class="form-control-label">Medicine Name</label>
          <input type="text" id="m_name" name="m_name" value="<?php echo $m_name; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="m_compose" class=" form-control-label">Composition</label>
          <textarea name="m_compose" id="m_compose" rows="3" class="form-control" required><?php echo $m_compose; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="m_short_descr" class="form-control-label">Short Description</label>
          <input type="text" id="m_short_descr" name="m_short_descr" value="<?php echo $m_short_descr; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="m_descr" class=" form-control-label">Description</label>
          <textarea name="m_descr" id="m_descr" rows="3" class="form-control" required><?php echo $m_descr; ?></textarea>
        </div>
        <div class="form-group m-2">
          <label for="m_direction" class="form-control-label">Usage Directions</label>
          <input type="text" id="m_direction" name="m_direction" value="<?php echo $m_direction; ?>" class="form-control" required>
        </div>
        <div class="form-group m-2">
          <label for="image" class="form-control-label">Choose Image(please use jpg/ jpeg/ png format picture)</label>
          <input type="file" id="image" name="image" class="form-control">
        </div>
        <div class="form-group m-2">
          <label for="m_mfg_by" class=" form-control-label">Manufactured By</label>
          <input type="text" id="m_mfg_by" name="m_mfg_by" value="<?php echo $m_mfg_by; ?>" class="form-control" required>
        </div>
        <div class="row p-2">
          <div class="col-6">
            <label for="m_mfg_date" class="form-control-label">Manufacturing Date</label>
            <input type="date" id="m_mfg_date" name="m_mfg_date" value="<?php echo $m_mfg_date; ?>" class="form-control" required>

          </div>
          <div class="col-6">
            <label for="m_exp_date" class=" form-control-label">Expiry Date</label>
            <input type="date" id="m_exp_date" name="m_exp_date" value="<?php echo $m_exp_date; ?>" class="form-control" required>

          </div>
        </div>
        <div class="row p-2">
          <div class="col-4">
            <label for="m_mrp" class="form-control-label">MRP</label>
            <input type="number" id="m_mrp" name="m_mrp" value="<?php echo $m_mrp; ?>" class="form-control" required>

          </div>
          <div class="col-4">
            <label for="m_price" class="form-control-label">Price</label>
            <input type="number" id="m_price" name="m_price" value="<?php echo $m_price; ?>" class="form-control" required>

          </div>
          <div class="col-4">
            <label for="m_qty" class="form-control-label">Quantity</label>
            <input type="number" id="m_qty" name="m_qty" value="<?php echo $m_qty; ?>" class="form-control" required>

          </div>
        </div>
        <div class="row">
          <div class="col-3">
            <label for="qty_per_unit" class="form-control-label">Quantity Per Medicine</label>
            <input type="number" id="qty_per_unit" name="qty_per_unit" value="<?php echo $qty_per_unit; ?>" class="form-control" required>
          </div>
          <div class="col-3">
            <label for="m_unit" class="form-control-label">Unit(Measured By)</label>
            <select name="m_unit" id="m_unit">
              <option value="<?php echo $m_unit; ?>"><?php echo $m_unit; ?></option>
              <option value="unit">Unit</option>
              <option value="ml">ml</option>
              <option value="gm">gm</option>
              <option value="tablet">Tablets</option>
            </select>
          </div>
        </div>
        <div class="row p-2">
          <div class="col-4">
            <label for="m_gender_spec" class="form-control-label">Gender Specific</label>
            <select name="m_gender_spec" id="m_gender_spec">
              <option value="<?php echo $m_gender_spec; ?>"><?php echo $m_gender_spec; ?></option>
              <option value="All">All</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="col-4">
            <label for="m_age_grp" class=" form-control-label">Age Group</label>
            <select name="m_age_grp" id="m_age_grp">
              <option value="<?php echo $m_age_grp; ?>"><?php echo $m_age_grp; ?></option>
              <option value="All">All</option>
              <option value="3 months">3 months</option>
              <option value="6 months">6 months</option>
              <option value="12 months">12 months</option>
              <option value="0-2 years">0-2 y</option>
              <option value="2-5 years">2-5 y</option>
              <option value="5-12 years">5-12 y</option>
              <option value="12-18 years">12-18 y</option>
              <option value="18-60 years">18-60 y</option>
              <option value="Above 60 years">&gt;60 y</option>
            </select>
          </div>
          <div class="col-4">
            <label for="m_type" class=" form-control-label">Dosage Type</label>
            <select name="m_type" id="m_type">
              <option value="<?php echo $m_type; ?>"><?php echo $m_type; ?></option>
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
              <option value="<?php echo $sp_id; ?>"><?php echo $health_concern; ?></option>
              <?php
              $result = mysqli_query($con, "select * from specialization where sp_id !=1 and health_concern != '' order by health_concern;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['sp_id']; ?>"><?php echo $data['health_concern']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-3">
            <label for="ct_id" class="form-control-label">Category</label>
            <select name="ct_id" id="ct_id">
              <option value="<?php echo $ct_id; ?>"><?php echo $ct_name; ?></option>
              <?php
              $resultCat = mysqli_query($con, "select * from category where ct_id !=1 order by ct_name;");
              while ($data = mysqli_fetch_assoc($resultCat)) {
              ?>
                <option value="<?php echo $data['ct_id']; ?>"><?php echo $data['ct_name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-3">
            <label for="m_sc_id" class="form-control-label">Sub Category</label>
            <select name="m_sc_id" id="m_sc_id">
              <option value="<?php echo $m_sc_id; ?>"><?php echo $m_sc_name; ?></option>

            </select>
          </div>
          <div class="col-3">
            <label for="mt_id" class="form-control-label">Medicine Type</label>
            <select name="mt_id" id="mt_id">
              <option value="<?php echo $mt_id; ?>"><?php echo $mt_name; ?></option>
              <?php
              $result2 = mysqli_query($con, "select * from medicine_type where mt_id !=1 order by mt_name;");
              while ($data2 = mysqli_fetch_assoc($result2)) {
              ?>
                <option value="<?php echo $data2['mt_id']; ?>"><?php echo $data2['mt_name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="m_side_effect" class="form-control-label">Safety Information</label>
          <textarea name="m_side_effect" id="m_side_effect" rows="3" class="form-control" required><?php echo $m_side_effect; ?></textarea>
        </div>
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="medicine.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
        <input type="hidden" name="m_id" value="<?php echo $m_id; ?>">
      </form>
    </div>
  </div>
</section>
<script>
  $(document).ready(() => {

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
</main>
<?php
require('includes/footer.php');
?>