<?php
require("../includes/db.inc.php");
if (isset($_POST['type']) && $_POST['type'] != null) {
  if ($_POST['type'] == 'smallT') {
    //for alltest page
    //show test components
    if (isset($_POST['id']) && $_POST['id'] != null) {
      $res = mysqli_query($con, "select tc_name from test_components where t_id={$_POST['id']}");
      $i = 1;
      while ($row = mysqli_fetch_assoc($res)) {
        echo "<li>" . $i . ". " . $row['tc_name'] . "</li>";
        $i++;
      }
    } else {
      echo "post a id asenai";
    }
  } else if ($_POST['type'] == 'smallAllT') {
    //for allpackage page
    //show tests +
    //show test components of corresponding tests
    if (isset($_POST['id']) && $_POST['id'] != null) {
      $res = mysqli_query($con, "select test.t_name,test_pack_joint.t_id from test inner join test_pack_joint on test_pack_joint.t_id=test.t_id where test_pack_joint.pk_id={$_POST['id']}");
      $i = 1.0;
      while ($row = mysqli_fetch_assoc($res)) {
        echo "<ul>" . $i . " " . $row['t_name'] . "</ul>";
        $res2 = mysqli_query($con, "select tc_name from test_components where t_id={$row['t_id']}");
        $j = 0.1;
        while ($row2 = mysqli_fetch_assoc($res2)) {
          echo "<li>&nbsp;&nbsp;&nbsp;" . $i + $j . ". " . $row2['tc_name'] . "</li>";
          $j += 0.1;
        }
        $i++;
      }
    } else {
      echo "post a id asenai";
    }
  }
}
