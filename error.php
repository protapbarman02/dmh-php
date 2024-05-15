<?php 
require("includes/db.inc.php");
require("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/error.css">
    <title>Error</title>
</head>

<body>
    <section class="page_404">
        <div class="img-cont">
            <img src="<?php echo SITE_IMAGE_OTHERS_LOC;?>error.svg" alt="error 404">
        </div>
        <h1>Looks like you are lost</h1>
        <button><a href="index.php">Go to Homepage</a></button>
    </section>
</body>

</html>