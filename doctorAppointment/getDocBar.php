<?php $ROOT = '../';
require($ROOT . "includes/db.inc.php");
require($ROOT . "includes/config.php");
require($ROOT . "includes/functions.php");

if (!isset($_POST['d_id'])) {
  echo '<p>Something went wrong</p>';
  exit();
} else {
  $d_id = $_POST['d_id'];
  $sp_name = $_POST['sp_name'];
  $res = mysqli_query($con, "select d_image,d_name,d_visit_fee,d_online_fee,d_hospital from doctor where d_id=$d_id");
  if (mysqli_num_rows($res) <= 0) {
    echo "<p>Something Went Wrong !!! </p>";
    exit();
  } else {
    while ($row = mysqli_fetch_assoc($res)) {
      $d_image = $row['d_image'];
      $d_name = $row['d_name'];
      $d_hospital = $row['d_hospital'];
    }
    echo '<style>
        .date-box,.time-box {
            display:none;
        }
        
        .date-label,.time-label {
            display: inline-block;
            width: 150px;
            border: 1px solid #000;
            margin: 10px;
            text-align: center;
            cursor: pointer;
        }
        .time-label{
            height:50px;
        }
        #dates-container {
            display: flex;
            flex-direction: row;
        }
        .date-picker,.time-picker{
            width:100%;
            background-color:transparent;
            border:none;
            height:100%;
        }
        .date-picker{
            padding:4px 0px;
            font-size:14px;
            word-wrap: break-word;
        }
        .time-box:checked+.time-label {
            background-color: #339999;
            color: white;
        }
        </style>
        <div>
            <div class="border p-4 d-flex" id="doc-side-profile">
                <div class="single-doc-thumb-cont">
                    <img src="' . SITE_IMAGE_DOCTOR_LOC . $d_image . '" alt="" class="rounded-circle">
                </div>
                <div class="ms-2">
                    <p class="theme-color"><b>' . $d_name . '</b></p>
                    <p class="text-success">' . replaceLastY($sp_name) . '</p>
                    <p class="text-success">' . $d_hospital . '</p>
                </div>
            </div>';

    echo '<div>
                <form id="appointment-form" action="doc_appointment_book.php" method="post">
                    <div id="dates-container">';
    $dates = array();
    for ($i = 1; $i < 4; $i++) {
      $date = date('Y-m-d', strtotime("+$i days"));
      echo '<input type="radio" name="date" id="date' . ($i + 1) . '" class="date-box" value="' . $date . '">';
      echo '<label for="date' . ($i + 1) . '" class="date-label"><button type="button" class="date-picker" onclick="viewSchedule(' . $d_id . ',\'' . $date . '\',this)">' . date('l, F j', strtotime($date)) . '</button></label>';
    }
    echo '</div>';
    echo '<div id="schedule-container"></div>';
    echo '<div id="error-message" class="error-message text-danger"></div>
                    <div class="text-center p-2">
                        <button type="button" class="btn btn-danger" onclick="cancel_schedule_bar()">Cancel</button>
                    </div>
            </form>
        </div>
        ';
    exit();
  }
}
