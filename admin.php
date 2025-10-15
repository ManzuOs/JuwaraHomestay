<?php
// admin.php — Juwara Homestay Admin Dashboard (Auto-detect DB Columns)

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "juwarahomestay1";

// Connect
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("❌ Connection failed: " . $conn->connect_error);

// Helper function to render a table dynamically
function renderTable($conn, $query, $title, $colorClass) {
    $result = $conn->query($query);
    echo "<div class='mb-5'><div class='card p-3'>";
    echo "<h2>$title</h2><div class='table-responsive'>";
    if ($result && $result->num_rows > 0) {
        echo "<table class='table table-striped table-bordered align-middle'>";
        echo "<thead class='$colorClass text-center'><tr>";
        // Print headers dynamically
        while ($field = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        echo "</tr></thead><tbody>";
        // Print data
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $col => $val) {
                echo "<td>" . htmlspecialchars($val) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='text-center text-muted'>No records found.</p>";
    }
    echo "</div></div></div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>JUWARA HOMESTAY | Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: #f5f7fa;
  font-family: 'Poppins', sans-serif;
}

/* Sidebar */
.sidebar {
  width: 230px;
  height: 100vh;
  position: fixed;
  background: linear-gradient(180deg,#0d47a1,#1976d2);
  color: white;
  padding: 20px;
  border-right: 5px solid #0d47a1;
}
.sidebar h4 {
  margin-bottom: 20px;
  text-align: center;
  font-weight: bold;
}
.sidebar a {
  color: white;
  text-decoration: none;
  display: block;
  padding: 10px;
  border-radius: 8px;
  transition: 0.3s;
  border: 1px solid transparent;
}
.sidebar a:hover {
  background: rgba(255,255,255,0.15);
  border: 1px solid #fff;
}

/* Main content */
.content {
  margin-left: 250px;
  padding: 25px;
}

/* Cards */
.card {
  border-radius: 12px;
  border: 2px solid #d1d9e6;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: 0.3s;
}
.card:hover {
  border-color: #1976d2;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Table */
.table {
  border: 2px solid #dee2e6;
}
.table th, .table td {
  border: 1px solid #dee2e6;
}
.table tr:hover {
  background-color: #f1f9ff;
}

/* Titles */
h2 {
  color: #0d47a1;
  margin-bottom: 15px;
  border-bottom: 3px solid #0d47a1;
  display: inline-block;
  padding-bottom: 4px;
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4>🏠 JUWARA HOMESTAY</h4>
  <a href="#users">👥 Users</a>
  <a href="#bookings">📅 Bookings</a>
  <a href="#devices">💡 Devices</a>
  <a href="#logs">📜 Device Logs</a>
  <a href="logout.php" class="text-danger fw-bold mt-3">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="content">
  <div class="container-fluid">

    <div id="users">
      <?php renderTable($conn, "SELECT * FROM users ORDER BY id DESC", "👥 Users", "table-primary"); ?>
    </div>

    <div id="bookings">
      <?php renderTable($conn, "SELECT * FROM bookings ORDER BY id DESC", "📅 Bookings", "table-success"); ?>
    </div>

    <div id="devices">
      <?php renderTable($conn, "SELECT * FROM devices ORDER BY id DESC", "💡 Devices", "table-warning"); ?>
    </div>

    <div id="logs">
      <?php renderTable($conn, "SELECT * FROM device_logs ORDER BY id DESC", "📜 Device Logs", "table-info"); ?>
    </div>

  </div>
</div>

</body>
</html>
