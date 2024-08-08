<?php


// Include the database connection file
include "connection.php";

// Retrieve all bookings from the database
$query = "SELECT * FROM bookings";
$result = mysqli_query($conn, $query);

// Handle cancel and confirm actions
if (isset($_POST['action']) && isset($_POST['booking_id'])) {
  $action = $_POST['action'];
  $booking_id = $_POST['booking_id'];

  if ($action === 'cancel') {
    // Update the booking status to 'Cancelled'
    $updateQuery = "UPDATE bookings SET status = 'Cancelled' WHERE id = $booking_id";
    mysqli_query($conn, $updateQuery);
  } elseif ($action === 'confirm') {
    // Update the booking status to 'Confirmed'
    $updateQuery = "UPDATE bookings SET status = 'Confirmed' WHERE id = $booking_id";
    mysqli_query($conn, $updateQuery);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <!-- Add your CSS styling here -->
  <link href="../css/admin.css" rel="stylesheet" type="text/css"  media="all" />
</head>
<body>
  <h1>Welcome, Admin!</h1>
  
  <h2>Bookings</h2>
  <table>
    <tr>
      <th>Id</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>ID Type</th>
      <th>ID Number</th>
      <th>Room Type</th>
      <th>Check-In Date</th>
      <th>Check-Out Date</th>
      <th>Adults</th>
      <th>Children</th>
      <th>Country</th>
      <th>Special Requests</th>
      <th>Subscribe</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['id_type']; ?></td>
        <td><?php echo $row['id_number']; ?></td>
        <td><?php echo $row['room_type']; ?></td>
        <td><?php echo $row['check_in_date']; ?></td>
        <td><?php echo $row['check_out_date']; ?></td>
        <td><?php echo $row['adults']; ?></td>
        <td><?php echo $row['children']; ?></td>
        <td><?php echo $row['country']; ?></td>
        <td><?php echo $row['special_requests']; ?></td>
        <td><?php echo $row['subscribe']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
          <?php if ($row['status'] === 'Pending') { ?>
            <form method="post">
              <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="action" value="cancel">Cancel</button>
              <button type="submit" name="action" value="confirm">Confirm</button>
            </form>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
  
  <a href="logout.php">Logout</a> <!-- Replace 'logout.php' with your logout script -->

</body>
</html>