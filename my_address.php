<?php $ROOT = "";
$page = 'address';
require("includes/profile_nav.php");
if (isset($_GET['type'])) {
  $type = get_safe_value($con, $_GET['type']);
  $addr_id = get_safe_value($con, $_GET['addr_id']);
  if ($type == "delete") {
    $addr_status = mysqli_fetch_assoc(mysqli_query($con, "SELECT addr_status FROM addr WHERE addr_id=$addr_id"))['addr_status'];
    if ($addr_status == 0) {
      mysqli_query($con, "DELETE FROM addr WHERE addr_id=$addr_id");
    } else {
      mysqli_query($con, "DELETE FROM addr WHERE addr_id=$addr_id");
      $next_addr_id_result = mysqli_query($con, "SELECT addr_id FROM addr WHERE user_type='patient' AND user_id={$_SESSION['uid']} LIMIT 1");
      if (mysqli_num_rows($next_addr_id_result) > 0) {
        $next_addr_id = mysqli_fetch_assoc($next_addr_id_result)['addr_id'];
        mysqli_query($con, "UPDATE addr SET addr_status=1 WHERE addr_id=$next_addr_id");
      }
    }
  } else if ($type == "set_default") {
    mysqli_query($con, "update addr set addr_status=0 where user_id={$_SESSION['uid']} and user_type='patient'");
    mysqli_query($con, "update addr set addr_status=1 where addr_id=$addr_id");
  }
?>
  <script>
    window.location.href = "my_address.php";
  </script>
<?php
}

$addresses = [];
$addr_res = mysqli_query($con, "select * from addr where user_type='patient' and user_id={$_SESSION['uid']} order by addr_status desc");
if (mysqli_num_rows($addr_res) > 0) {
  while ($addr_row = mysqli_fetch_assoc($addr_res)) {
    $addresses[] = $addr_row;
  }
} else {
  $_SESSION['noAddress'] = true;
}
?>
<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
  <h3 class="text-center border-bottom border-info py-2">Addresses</h3>
  <div class="container-fluid d-flex flex-column">
    <div class="row m-2 p-2">
      <div class="col-12 p-2 m-2 border">
        <a href="manage_address.php?type=add"><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>address.png" alt="" class="h-30"> Add New Address</a>
      </div>
      <?php
      foreach ($addresses as $address) {
      ?>
        <div class="col-12 m-2 p-2 border">
          <div class="row">
            <div class="col-12 d-flex justify-content-between">
              <div>
                <?php
                if ($address['addr_status'] == 1) {
                  echo "<span class='p-1 bg-secondary rounded text-light'>Default</span>";
                }
                ?>
              </div>
              <div class="position-relative">
                <button class="dot-menu" onclick="addr_menu(<?php echo $address['addr_id']; ?>)"><img src="<?php echo SITE_IMAGE_ICON_LOC; ?>dots.png" alt=""></button>
                <div class="card addr_card position-absolute end-50" id="addr_list_<?php echo $address['addr_id']; ?>">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item py-0"><a href="manage_address.php?type=edit&addr_id=<?php echo $address['addr_id']; ?>">Edit</a></li>
                    <li class="list-group-item py-0"><a href="?type=delete&addr_id=<?php echo $address['addr_id']; ?>">Delete</a></li>
                    <?php
                    if ($address['addr_status'] == 0) {
                      echo "<li class='list-group-item py-0'><a href='?type=set_default&addr_id={$address['addr_id']}'>Set As Default</a></li>";
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12">
              <p class="mb-0"><span><?php echo $address['user_name']; ?></span> , <span><b><?php echo $address['addr_phn']; ?></span></b></p>
              <p class="mb-0"><?php echo $address['addr_email']; ?></p>
              <p class="mb-0">Near <?php echo $address['addr_landmark']; ?>, <?php echo $address['addr_line']; ?>, <?php echo $address['addr_city']; ?>, <?php echo $address['addr_state']; ?>, <?php echo $address['addr_district']; ?>, <?php echo $address['addr_pin']; ?></p>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>


  </div>
</div>
</div>
</div>
</main>
<script>
  $(document).ready(function() {});

  function addr_menu(addr_id) {
    $("#addr_list_" + addr_id).toggle("addr_card");
  }
</script>
<?php
include("$ROOT" . "includes/footer.php");
?>