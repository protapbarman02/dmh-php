<?php function currentPage()
{
  $currentPage = $_SERVER['PHP_SELF'];
  return $currentPage;
}
function age($dob)
{
  $date = new DateTime($dob);
  $now = new DateTime();
  $diff = $now->diff($date);
  $age = $diff->y;
  return $age;
}
function getId($con)
{
  $i = 0;
  $sql = "SELECT s_id from staff";
  $res = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_assoc($res)) {
    $i = $row['s_id'];
  }
  return ($i + 5);
}
function get_safe_value($con, $str)
{
  if ($str != '') {
    $str = trim($str);
    return mysqli_real_escape_string($con, $str);
  }
}

class ProductModule
{
  private $table;
  private $searchColumn;
  private $resultsPerPage;
  private $con;

  public function __construct($table, $searchColumn, $resultsPerPage, $con)
  {
    $this->table = $table;
    $this->searchColumn = $searchColumn;
    $this->resultsPerPage = $resultsPerPage;
    $this->con = $con;
  }

  public function searchWithPagination($currentPage, $searchTerm, $status)
  {
    $startFrom = ($currentPage - 1) * $this->resultsPerPage;

    $searchTerm = get_safe_value($this->con, $searchTerm);

    $sql = "SELECT * FROM {$this->table} WHERE $status!=0";

    if ($searchTerm != '') {
      $sql .= " AND {$this->searchColumn} LIKE '%$searchTerm%' ";
    }
    $sql .= " LIMIT $startFrom, {$this->resultsPerPage}";
    $result = $this->con->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    return $data;
  }

  public function getTotalPages($searchTerm)
  {
    $searchTerm = mysqli_real_escape_string($this->con, $searchTerm);

    $sql = "SELECT COUNT(*) as total FROM {$this->table}";

    if (!empty($searchTerm)) {
      $sql .= " WHERE {$this->searchColumn} LIKE '%$searchTerm%'";
    }

    $result = $this->con->query($sql);
    $row = $result->fetch_assoc();
    $totalPages = ceil($row['total'] / $this->resultsPerPage);

    return $totalPages;
  }
}
// Function to retrieve filtered and paginated medicines
function getFilteredMedicines($con, $category, $sub_category, $type, $specialization, $dosage_type, $search_query, $sort_by, $page, $limit)
{
  $where_clause = '';
  if ($category != '') {
    $where_clause .= " AND medicine.ct_id = $category";
  }
  if ($sub_category != '') {
    $where_clause .= " AND medicine.m_sc_id = $sub_category";
  }
  if ($type != '') {
    $where_clause .= " AND medicine.mt_id = $type";
  }
  if ($specialization != '') {
    $where_clause .= " AND medicine.sp_id = $specialization";
  }
  if ($dosage_type != '') {
    $where_clause .= " AND medicine.m_type = '$dosage_type'";
  }

  $where_clause .= " AND (category.ct_status = 1 AND medicine_sub_category.m_sc_status = 1 AND medicine_type.mt_status = 1 AND specialization.sp_status = 1)";

  $search_clause = '';
  if ($search_query != '') {
    $search_clause .= " AND (medicine.m_name LIKE '%$search_query%' OR medicine.m_descr LIKE '%$search_query%' OR medicine.m_short_descr LIKE '%$search_query%')";
  }

  $start = ($page - 1) * $limit;

  $sql = "SELECT * FROM medicine
            INNER JOIN category ON medicine.ct_id = category.ct_id
            INNER JOIN medicine_sub_category ON medicine.m_sc_id = medicine_sub_category.m_sc_id
            INNER JOIN medicine_type ON medicine.mt_id = medicine_type.mt_id
            INNER JOIN specialization ON medicine.sp_id = specialization.sp_id
            WHERE 1=1 $where_clause $search_clause
            ORDER BY $sort_by  LIMIT $start, $limit";
  $result = $con->query($sql);

  $medicines = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $medicines[] = $row;
    }
  }
  $sql_count = "SELECT COUNT(*) AS total FROM medicine
    INNER JOIN category ON medicine.ct_id = category.ct_id
    INNER JOIN medicine_sub_category ON medicine.m_sc_id = medicine_sub_category.m_sc_id
    INNER JOIN medicine_type ON medicine.mt_id = medicine_type.mt_id
    INNER JOIN specialization ON medicine.sp_id = specialization.sp_id
    WHERE 1=1 $where_clause $search_clause";

  $result_count = $con->query($sql_count);

  if ($result_count->num_rows > 0) {
    $row = $result_count->fetch_assoc();
    $total_items = $row['total'];
  } else {
    $total_items = 0;
  }

  // Calculate the total number of pages
  $total_pages = ceil($total_items / $limit);
  if ($page > $total_pages) {
    $page = 1;
  }

  return array('medicines' => $medicines, 'total_pages' => $total_pages, 'current_page' => $page);
}

function replaceLastY($string)
{
  $lastYPosition = strrpos($string, 'y');
  if ($lastYPosition !== false) {
    $string = substr_replace($string, 'ist', $lastYPosition, 1);
  }
  return $string;
}
function calculateTotalTime($startTime, $endTime)
{
  $start = new DateTime($startTime);
  $end = new DateTime($endTime);
  if ($end < $start) {
    $end->add(new DateInterval('P1D'));
  }
  $interval = $start->diff($end);
  return $interval->format('%H:%I:%S');
}
function calculatePatients($totalTime, $timePerPatient)
{
  sscanf($totalTime, "%d:%d:%d", $hours, $minutes, $seconds);
  $totalMinutes = ($hours * 60) + $minutes + ($seconds / 60);
  $patients = floor($totalMinutes / $timePerPatient);
  return $patients;
}
function convertTo12HourFormat($time)
{
  $twelve_hour_format = date("g:i A", strtotime($time));
  return $twelve_hour_format;
}
function addMinutesToTime($inputTime, $minutesToAdd)
{
  // Convert the input time to a DateTime object
  $timeObject = DateTime::createFromFormat('H:i:s', $inputTime);

  // Add minutes to the time
  $timeObject->add(new DateInterval('PT' . $minutesToAdd . 'M'));

  // Format the resulting time as HH:MM:SS
  $formattedTime = $timeObject->format('H:i:s');

  return $formattedTime;
}
function formatDate($dateString)
{
  $timestamp = strtotime($dateString); // Convert the date string to a Unix timestamp
  $readableDate = date("l, F j, Y", $timestamp); // Convert the Unix timestamp to a readable format
  return $readableDate;
}
