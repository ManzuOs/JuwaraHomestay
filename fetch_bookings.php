<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "juwarahomestay1");
if ($conn->connect_error) {
    die(json_encode([]));
}

$sql = "SELECT fullname, check_in, check_out FROM bookings";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['fullname'],
        'start' => $row['check_in'],
        'end'   => date('Y-m-d', strtotime($row['check_out'] . ' +1 day')),
        'color' => '#198754'
    ];
}

echo json_encode($events);
$conn->close();
?>
