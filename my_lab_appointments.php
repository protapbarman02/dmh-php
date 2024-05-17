<?php $ROOT = "";
$page = 'lab_apps';
require("includes/profile_nav.php");
?>
<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
    <h3 class="text-center border-bottom border-info py-2">All Lab Appointments</h3>
    <div class="container-fluid d-flex flex-column">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Fees</th>
                    <th>Booked At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($con, "SELECT * FROM `lab_appointment` where p_id={$_SESSION['uid']} order by lab_app_date desc");
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <!-- <td><a href="my_lab_apps_details.php?lab_id=<?php // echo $row['lab_id']; ?>&type=<?php //echo $row['lab_type']; ?>">(View)</a></td> -->
                        <td><?php echo formatDate($row['lab_app_date']); ?></td>
                        <td>
                            <?php
                            if ($row['lab_app_time'] == '00:00' or $row['lab_app_time'] =='00:00:00' or $row['lab_app_time'] ==null or $row['lab_app_time'] =='') {
                                echo "processing";
                            } else {
                                echo convertTo12HourFormat($row['lab_app_time']);
                            } 
                            ?>
                        </td>
                        <td><?php echo $row['lab_fee']; ?> Rs/-</td>
                        <td><?php echo $row['lab_create_time']; ?></td>
                        <td><?php echo $row['lab_status']; ?></td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
        <div class="text-end">
            <p class="text-danger">
                Call for Cancellation
            </p>
            <p>
                <a href="tel:+918327507847" class="text-danger">+918327507847</a>
            </p>
        </div>
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