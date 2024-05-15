<?php
$ROOT = "../";
require("nav.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  mysqli_query($con, "UPDATE doctor SET 
        d_name='{$_POST['name']}', 
        d_dob='{$_POST['dob']}', 
        d_gen='{$_POST['gen']}', 
        d_phn='{$_POST['phn']}',
        d_addr='{$_POST['addr']}',
        d_qualif='{$_POST['qualif']}',
        d_hospital='{$_POST['hospital']}',
        d_expernc='{$_POST['expernc']}'
        WHERE d_id=$d_id");
}


$res = mysqli_query($con, "select * from doctor where d_id=$d_id");
while ($row = mysqli_fetch_assoc($res)) {
  $d_name = $row['d_name'];
  $d_dob = $row['d_dob'];
  $d_email = $row['d_email'];
  $d_gen = $row['d_gen'];
  $d_addr = $row['d_addr'];
  $d_phn = $row['d_phn'];
  $d_pass = $row['d_pass'];
  $d_qualif = $row['d_qualif'];
  $d_hospital = $row['d_hospital'];
  $d_expernc = $row['d_expernc'];
  $d_online_fee = $row['d_online_fee'];
  $d_visit_fee = $row['d_visit_fee'];
}

$online = 0;
$offline = 0;
$res = mysqli_query($con, "select sc_shift_start,sc_shift_end from doc_schedule where d_id=$d_id and sc_shift_type='online'");
if (mysqli_num_rows($res) > 0) {
  $online = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $online_shift_start = $row['sc_shift_start'];
    $online_shift_end = $row['sc_shift_end'];
  }
}
$res = mysqli_query($con, "select sc_shift_start,sc_shift_end from doc_schedule where d_id=$d_id and sc_shift_type='offline'");
if (mysqli_num_rows($res) > 0) {
  $offline = 1;
  while ($row = mysqli_fetch_assoc($res)) {
    $offline_shift_start = $row['sc_shift_start'];
    $offline_shift_end = $row['sc_shift_end'];
  }
}

?>
<section class="admin-right-panel" style="background-color:white;">
  <div class="d-flex justify-content-between bg-light m-0 px-4 top-bar-doc">
    <p><a href="index.php" class="text-dark text-decoration-none">DASHBOARD</a> / <a href="" class="text-success text-decoration-none">MY PROFILE</a></p>
    <p><?php echo date('l, F jS Y'); ?></p>
  </div>
  <section class="container main-cart-type-container">
    <div class="row">
      <div class="d-flex justify-content-center main-cart-type">
        <button id="test_select">My Profile</button>
      </div>
    </div>
  </section>
  <div class="container pt-5 border">
    <div class="row px-xl-5">
      <div class="col-lg-12 mb-5" class="main-cart-content" id="test_cart">
        <form class="container-fluid d-flex flex-column" id="profile_form" method="post">
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Name : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="text" name="name" id="name" class="px-2" readonly value="<?php echo $d_name; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="name" id="name-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Date Of Birth : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="date" name="dob" id="dob" class="px-2" readonly value="<?php echo $d_dob; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="name" id="dob-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 doc-profile-title">Gender : </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <select name="gen" id="gen" name="gen" class="form-select" disabled>
                <option value="<?php echo $d_gen; ?>"><?php echo $d_gen; ?></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
              </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"><label for="gen" id="gen-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Phone No. : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="text" name="phn" id="phn" class="px-2" readonly value="<?php echo $d_phn; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="phn" id="phn-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Address : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="text" name="addr" id="addr" class="px-2" readonly value="<?php echo $d_addr; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="addr" id="addr-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Qualification : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="text" name="qualif" id="qualif" class="px-2" readonly value="<?php echo $d_qualif; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="qualif" id="qualif-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">I'm Working at : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="text" name="hospital" id="hospital" class="px-2" readonly value="<?php echo $d_hospital; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="hospital" id="hospital-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 doc-profile-title">Experience(Years) : </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><input type="number" name="expernc" id="expernc" class="px-2" readonly value="<?php echo $d_expernc; ?>"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"><label for="expernc" id="expernc-edit" class="text-primary edit-label">Edit</label></div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom align-items-center">
            <div class="col-lg-4 col-md-4 col-sm-4 doc-profile-title">My Fees : </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <?php
              if ($online == 1) {
              ?>
                <div><b>Online Consultation :</b> <?php echo $d_online_fee; ?> Rs/-</div>
              <?php
              }
              if ($offline == 1) {
              ?>
                <div><b>Chamber Visit :</b> <?php echo $d_visit_fee; ?> Rs/-</div>
              <?php }
              ?>
            </div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom align-items-center">
            <div class="col-lg-4 col-md-4 col-sm-4 doc-profile-title">My Schedule : </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <?php
              if ($online == 1) {
              ?>
                <div>
                  <p><b>Online Consultation :</b></p> <?php echo convertTo12HourFormat($online_shift_start); ?>--<?php echo convertTo12HourFormat($online_shift_end); ?>
                </div>
              <?php
              }
              if ($offline == 1) {
              ?>
                <div>
                  <p><b>Chamber Visit :</b></p> <?php echo convertTo12HourFormat($offline_shift_start); ?>-- <?php echo convertTo12HourFormat($offline_shift_end); ?>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="row d-flex m-2 p-2 border-bottom">
            <div class="col-lg-4 col-md-4 col-sm-4 doc-profile-title">Email : </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
              <p class="px-2"><?php echo $d_email; ?></p>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
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
        $("#profile_form").submit();
      }
    })
  </script>
</section>
</main>
<?php
require("$ROOT" . "admin/includes/footer.php");
?>

</div>
</div>
</main>