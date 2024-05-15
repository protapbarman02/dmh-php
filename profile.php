<?php $ROOT = "";
$page = 'profile';
require("includes/profile_nav.php");
if (isset($_POST['name']) || isset($_POST['gen']) || isset($_POST['phn']) || isset($_POST['dob'])) {
  mysqli_query($con, "UPDATE patient SET 
        p_name='{$_POST['name']}', 
        p_dob='{$_POST['dob']}', 
        p_gen='{$_POST['gen']}', 
        p_phn='{$_POST['phn']}' 
        WHERE p_id=$uid");
?>
  <script>
    window.location.href = "profile.php";
  </script>
<?php
}
$res = mysqli_query($con, "select * from patient where p_id={$_SESSION['uid']}");
while ($row = mysqli_fetch_assoc($res)) {
  $p_name = $row['p_name'];
  $p_image = $row['p_image'];
  $p_dob = $row['p_dob'];
  $p_gen = $row['p_gen'];
  $p_email = $row['p_email'];
  $p_phn = $row['p_phn'];
}
?>

<div class="col-lg-8 col-md-7 col-sm-12 text-dark shadow-lg rounded m-2">
  <h3 class="text-center border-bottom border-info py-2">Profile Settings</h3>
  <form class="container-fluid d-flex flex-column" id="myForm" method="post">
    <div class="d-flex justify-content-between m-2 p-2 border-bottom">
      <div>Name : </div>
      <div><input type="text" name="name" id="name" class="px-2" readonly value="<?php echo $p_name; ?>"></div>
      <div><label for="name" id="name-edit" class="text-primary edit-label">Edit</label></div>
    </div>
    <div class="d-flex justify-content-between m-2 p-2 border-bottom">
      <div>Date Of Birth : </div>
      <div><input type="date" name="dob" id="dob" class="px-2" readonly value="<?php echo $p_dob; ?>"></div>
      <div><label for="name" id="dob-edit" class="text-primary edit-label">Edit</label></div>
    </div>
    <div class="d-flex justify-content-between m-2 p-2 border-bottom">
      <div class="">Gender : </div>
      <div class="">
        <select name="gen" id="gen" name="gen" class="form-select" disabled>
          <option value="<?php echo $p_gen; ?>"><?php echo $p_gen; ?></option>
          <option value="Female">Female</option>
          <option value="Others">Others</option>
        </select>
      </div>
      <div class=""><label for="gen" id="gen-edit" class="text-primary edit-label">Edit</label></div>
    </div>
    <div class="d-flex justify-content-between m-2 p-2 border-bottom">
      <div>Phone No. : </div>
      <div><input type="text" name="phn" id="phn" class="px-2" readonly value="<?php echo $p_phn; ?>"></div>
    </div>
    <div class="d-flex justify-content-between m-2 p-2 border-bottom">
      <div>Email : </div>
      <div>
        <p class="px-2"><?php echo $p_email; ?></p>
      </div>
    </div>

  </form>
</div>
</div>
</main>
<script>
  $(document).ready(function() {
    $("input").css("border", "none");
    $(".edit-label").click(function() {
      var button = $(this);
      var fieldId = button.attr("id").replace("-edit", "");

      if (button.text() === "Edit") {
        $("#" + fieldId).removeAttr("readonly disabled").focus();
        $("#" + fieldId).css("border-bottom", "1px solid #339999");
        button.text("Save");
      } else {
        $("#" + fieldId).attr("readonly", true);
        button.text("Edit");
        submitForm();
      }
    });

    function submitForm() {
      $("select[disabled]").removeAttr("disabled");
      $("#myForm").submit();
    }
  });
</script>
<?php
include("$ROOT" . "includes/footer.php");
?>