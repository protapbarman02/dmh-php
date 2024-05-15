<?php $ROOT = "";
$page = 'lab_apps';
require("includes/profile_nav.php");
$appointments = [];
if (isset($_GET['lab_id'])) {
    $lab_id = get_safe_value($con, $_GET['lab_id']);
    $lab_type = get_safe_value($con, $_GET['type']);
    if ($lab_type == 'test') {
        $res = mysqli_query($con, "SELECT lab_app_details.lab_d_product_price,test.t_image,test.t_name FROM `lab_app_details` INNER JOIN test ON `lab_app_details`.lab_d_product_id=test.t_id WHERE lab_app_details.lab_id=$lab_id");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $appointments[] = $row;
            }
        }
    } else if ($lab_type = 'package') {
        $res = mysqli_query($con, "SELECT lab_app_details.lab_d_product_price,package.pk_image,package.pk_name FROM `lab_app_details` INNER JOIN package ON `lab_app_details`.lab_d_product_id=package.pk_id WHERE lab_app_details.lab_id=$lab_id");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $appointments[] = $row;
            }
        }
    } else {
?>
        <script>
            window.location.href = "my_lab_appointments.php";
        </script>
    <?php
    }
} else {
    ?>
    <script>
        window.location.href = "my_lab_appointments.php";
    </script>
<?php
}
?>

<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
    <h3 class="text-center border-bottom border-info py-2">Appointments</h3>
    <div class="container-fluid d-flex flex-column">
        <table class="table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Image</th>
                    <th>Test Name</th>
                    <th>Fees</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($lab_type == 'test') {
                    $i = 1;
                    $total = 0;
                    foreach ($appointments as $appointment) {
                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><img src="<?php echo SITE_IMAGE_TEST_LOC . $appointment['t_image']; ?>" alt="test" class="h-30"></td>
                            <td><?php echo $appointment['t_name']; ?></td>
                            <td><?php echo $appointment['lab_d_product_price']; ?> Rs/-</td>
                        </tr>
                    <?php
                        $total += $appointment['lab_d_product_price'];
                        $i++;
                    }
                } else {
                    $i = 1;
                    $total = 0;
                    foreach ($appointments as $appointment) {
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><img src="<?php echo SITE_IMAGE_PACKAGE_LOC . $appointment['pk_image']; ?>" alt="package" class="h-30"></td>
                            <td><?php echo $appointment['pk_name']; ?></td>
                            <td><?php echo $appointment['lab_d_product_price']; ?> Rs/-</td>
                        </tr>
                <?php
                        $total += $appointment['lab_d_product_price'];
                        $i++;
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="border-bottom border-dark">
                    <td colspan="3"><b>Total Amount</b></td>
                    <td><b><?php echo $total; ?></b> Rs/-</td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>
</div>
</div>
</main>
<script>

</script>
<?php
include("$ROOT" . "includes/footer.php");
?>