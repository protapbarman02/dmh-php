<?php $ROOT = "";
$page = 'order';
require("includes/profile_nav.php");
if (isset($_GET['mo_id'])) {
    $mo_id = get_safe_value($con, $_GET['mo_id']);
    $res = mysqli_query($con, "select * from medicine_order where mo_id=$mo_id");
    while ($row = mysqli_fetch_assoc($res)) {
        $name = $row['ship_p_name'];
        $phone = $row['mo_phn'];
        $email = $row['mo_email'];
        $addr = $row['mo_addr'];
        $shipping = $row['mo_shipping'];
        $invoice = $row['mo_invoice'];
        $file_name = $row['mo_invoice_file'];
        $total_price_all_combined = $row['total_price_all_combined'];
    }
} else {
?>
    <script>
        window.location.href = "my_orders.php";
    </script>
<?php
}
?>

<div class="col-lg-8 col-md-12 col-sm-12 text-dark shadow-lg rounded m-2">
    <h3 class="text-center border-bottom border-info py-2">Medicine Orders</h3>
    <div class="container-fluid d-flex flex-column">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Medicine Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // $subtotal
                $res = mysqli_query($con, "select * from medicine_order_details where mo_id=$mo_id");
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <?php
                        $medicine_res = mysqli_query($con, "select m_name,m_image from medicine where m_id={$row['m_id']}");
                        while ($medicine_row = mysqli_fetch_assoc($medicine_res)) {
                        ?>
                            <td><img src="<?php echo SITE_IMAGE_MEDICINE_LOC . $medicine_row['m_image']; ?>" alt="medicine" class="h-30"></td>
                            <td><a href="medicine/medicine.php?m_id=<?php echo $row['m_id']; ?>"><?php echo $medicine_row['m_name']; ?></a></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $row['mod_price']; ?> Rs/-</td>
                        <td>x<?php echo $row['mod_qty']; ?></td>
                        <td><?php echo $row['mod_price'] * $row['mod_qty']; ?> Rs/-</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>


                <tr>
                    <td colspan="4">Shipping Charges</td>
                    <td><?php echo $shipping; ?> Rs/-</td>
                </tr>
                <tr>
                    <td colspan="4">Convenience Charges</td>
                    <td><?php echo $invoice; ?> Rs/-</td>
                </tr>

                <tr class="border-bottom border-dark">
                    <td colspan="4"><b>Total Amount</b></td>
                    <td><b><?php echo $total_price_all_combined; ?></b> Rs/-</td>
                </tr>

            </tfoot>
        </table>
        <div class="row py-4">
            <div class="col">
                <h5>Shipping Address:</h5>
                <div>
                    <p class="mb-0"><b><?php echo $name; ?></b></p>
                    <p class="mb-0"><?php echo $addr; ?></p>
                    <p class="mb-0"><?php echo $email; ?></p>
                    <p class="mb-0"><?php echo $phone; ?></p>
                </div>
            </div>
        </div>
        <div class="row py-4">
            <div class="col">
                <h5>Invoice :</h5>
                <div>
                    
                    <?php if (!empty($file_name)) : ?>
                        
                        <!-- If file name is available, create a download button -->
                        <a href="<?php echo SITE_INVOICE_LOC . $file_name; ?>" class="btn btn-primary" download>Download Invoice</a>
                    <?php else : ?>
                        <!-- If file name is not available, display a message -->
                        <p>No invoice available</p>
                    <?php endif; ?>
                </div>
            </div>
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