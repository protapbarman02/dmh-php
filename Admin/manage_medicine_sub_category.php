<?php $ROOT = "../";
require('includes/nav.php');
$id = '';
$m_sc_name = '';
$ct_id = '';
$ct_name = '';
if (isset($_GET['type']) && $_GET['type'] == 'edit') {
  if (isset($_GET['m_sc_id']) && $_GET['m_sc_id'] != '') {
    $m_sc_id = $_GET['m_sc_id'];
    $res = mysqli_query($con, "select * from medicine_sub_category where m_sc_id=$m_sc_id");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $m_sc_name = $row['m_sc_name'];
      $ct_id = $row['ct_id'];
      $ct_name = mysqli_fetch_assoc(mysqli_query($con, "SELECT ct_name FROM category WHERE category.ct_id=$ct_id;"))['ct_name'];
    } else {
?>
      <script>
        alert("illegal command");
        window.location.href = "medicine_sub_category.php";
      </script>
    <?php
    }
  }
}

if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
  $m_sc_name = trim($_POST['m_sc_name']);
  if (isset($_POST['m_sc_id']) && $_POST['m_sc_id'] != '') {
    $m_sc_id = $_POST['m_sc_id'];
    $ct_id = intval($_POST['ct_id']);
    $stmt = $con->prepare("UPDATE medicine_sub_category SET m_sc_name=?, ct_id=? WHERE m_sc_id=$m_sc_id");
    $stmt->bind_param("si", $m_sc_name, $ct_id);
    $stmt->execute();
    $stmt->close();
    ?>
    <script>
      window.location.href = "medicine_sub_category.php";
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("some error occured");
      window.location.href = "medicine_sub_category.php";
    </script>
<?php
  }
}
?>
<section class="admin-right-panel">
  <h2>Medicine Sub Category</h2>
  <div class="admin-medicineCategory-main">
    <div class="admin-add-container p-2">
      <button class="btn btn-warning btn-lg btn-block m-2">Update Medicine Sub Category</button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-2 admin-add-dorpdown-form">
        <div class="row">
          <div class="col">
            <label for="m_sc_name" class="form-control-label">Medicine Sub Category Name</label>
            <input type="text" name="m_sc_name" id="m_sc_name" value="<?php echo $m_sc_name; ?>" class="form-control" required>
          </div>
          <div class="col">
            <label for="ct_id" class=" form-control-label">Category</label>
            <select name="ct_id" id="ct_id" class="form-control">
              <option value="<?php echo $ct_id; ?>"><?php echo $ct_name; ?></option>
              <?php
              $result = mysqli_query($con, "select * from category where ct_id !=1 and ct_name!='' order by ct_name;");
              while ($data = mysqli_fetch_assoc($result)) {
              ?>
                <option value="<?php echo $data['ct_id']; ?>"><?php echo $data['ct_name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <input type="hidden" name="m_sc_id" value="<?php echo $m_sc_id; ?>">
        <div class="m-2 update-bottom-menues">
          <button type="button" class="btn btn-danger admin-submit-btn"><a href="medicine_sub_category.php" class="text-decoration-none text-white">Cancel</a></button>
          <button name="submit" type="submit" value="submit" class="btn btn-success admin-submit-btn">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
</main>
<?php
require('includes/footer.php');
?>