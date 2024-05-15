<?php
$ROOT = '../';
require($ROOT . "includes/db.inc.php");
require($ROOT . "includes/config.php");
require($ROOT . "includes/functions.php");

if (!isset($_POST['d_id']) || !isset($_POST['date'])) {
  echo '<p>Something went wrong</p>';
  exit();
} else {

  $d_id = $_POST['d_id'];
  $res = mysqli_query($con, "select d_online_fee,d_visit_fee from doctor where d_id=$d_id");
  while ($row = mysqli_fetch_assoc($res)) {
    $d_online_fee = $row['d_online_fee'];
    $d_visit_fee = $row['d_visit_fee'];
  }
  $date = $_POST['date'];
  $estimate_time = '';
  $schedules = [];
  $res = mysqli_query($con, "select * from doc_schedule where d_id=$d_id and sc_status!=0");
  while ($row = mysqli_fetch_assoc($res)) {
    $schedules[] = $row;
  }
  if (empty($schedules)) {
    echo '</div>
            <p>Sorry No Schedule available right now</p>
            <p>or you can call us at <a href="tel:+918327507847">+918327507847</a>
            </div>';
    exit();
  } else {
    foreach ($schedules as $schedule) {
      $isScheduleAvailable = false;
      $calculateTotalTime = calculateTotalTime($schedule['sc_shift_start'], $schedule['sc_shift_end']);
      $total_doc_appointment = mysqli_query($con, "select doc_a_id from doc_appointment where d_id=$d_id and doc_a_mode='{$schedule["sc_shift_type"]}' and d_shift_time='{$schedule["sc_shift_start"]}' and doc_a_date='$date' and doc_a_status='confirmed'");
      if (mysqli_num_rows($total_doc_appointment) == 0) {
        $sno = 1;
        $estimate_time_unformatted = addMinutesToTime($schedule["sc_shift_start"], $schedule['sc_patient_duration'] * ($sno - 1));
        $estimate_time = convertTo12HourFormat($estimate_time_unformatted);
        $isScheduleAvailable = true;
      } else if (mysqli_num_rows($total_doc_appointment) > 0) {
        $patient_eligib_count = calculatePatients(calculateTotalTime($schedule['sc_shift_start'], $schedule['sc_shift_end']), $schedule['sc_patient_duration']);
        if (mysqli_num_rows($total_doc_appointment) == $patient_eligib_count) {
          $isScheduleAvailable = false;
        } else {
          $sno = mysqli_num_rows($total_doc_appointment) + 1;
          $estimate_time_unformatted = addMinutesToTime($schedule["sc_shift_start"], $schedule['sc_patient_duration'] * ($sno - 1));
          $estimate_time = convertTo12HourFormat($estimate_time_unformatted);
          $isScheduleAvailable = true;
        }
      }
      if ($schedule["sc_shift_type"] == 'online') {
        $shift = "Online Consult";
      } else if ($schedule["sc_shift_type"] == 'offline') {
        $shift = "Chamber Visit";
      }

      echo '
                        <div class="border shadow rounded p-2">
                            <div class="p-2">
                                <p class="theme-color">' . $shift . '</p>';
      if ($isScheduleAvailable) {
        echo '<input type="radio" name="time" class="time-box" id="' . $schedule["sc_shift_type"] . '" value="' . $schedule["sc_shift_start"] . '">
                                <label for="' . $schedule["sc_shift_type"] . '" class="time-label"><button type="button" class="time-picker" onclick="time_picker_style_event(' . $d_id . ', \'' . $date . '\', this, \'' . $schedule["sc_shift_start"] . '\', \'' . $schedule["sc_shift_type"] . '\')
                                ">' . convertTo12HourFormat($schedule["sc_shift_start"]) . '</button></label>
                                <input type="hidden" name="schedule_available" value="yes">';
      } else if (!$isScheduleAvailable) {
        echo '<input disabled type="radio" name="time" class="time-box" id="' . $schedule["sc_shift_type"] . '" value="' . $schedule["sc_shift_start"] . '">
                                <label for="' . $schedule["sc_shift_type"] . '" class="time-label"><button type="button" class="time-picker" disabled>' . convertTo12HourFormat($schedule["sc_shift_start"]) . '</button></label>
                                <input type="hidden" name="schedule_available" value="yes">';
      }
      echo '</div>';

      if ($schedule["sc_shift_type"] == 'online') {
        echo '<div><p><b>Fee : </b><span class="text-success">' . $d_online_fee . '</span> Rs/-</p></div>';
      } else if ($schedule["sc_shift_type"] == 'offline') {
        echo '<div><p><b>Fee : </b><span class="text-success">' . $d_visit_fee . '</span> Rs/-</p></div>';
      }

      if ($isScheduleAvailable) {
        echo '<div><p>You are at Number ' . $sno . '</p></div>
                        <div><p class="theme-color">Your appointment\'s estimated time is ' . $estimate_time . '</p></div>';
      } else if (!$isScheduleAvailable) {
        echo '<div><p>Sorry appointment list is full, plese check on next Date</p></div>
                      <div><p>or you can call us at <a href="tel:+918327507847">+918327507847</a></p></div>';
      }
      echo '</div>';
    }
  }
}
