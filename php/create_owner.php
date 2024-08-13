<!DOCTYPE html>
<html>
<head>
    <title>Manage Hotel Owners</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="../css/admin.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
        .form-container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="email"],
        .form-container input[type="tel"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
        .owner-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .owner-table th,
        .owner-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .owner-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .owner-table .actions {
            text-align: center;
        }
        .owner-table .actions button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        .owner-table .actions button.edit {
            background-color: #ffc107;
        }
        .owner-table .actions button.delete {
            background-color: #dc3545;
        }
        .owner-table .actions button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="wrap">
            <div class="header-top">
                <div class="logo">
                    <a href="index.html"><img src="../images/logo2.png" title="logo" /></a>
                </div>
                <div class="contact-info">
                    <p class="phone">Call us : <a href="#">9808147755,9840602765</a></p>
                    <p class="gpa">Gps : <a href="https://www.google.com/maps/place/New+Hotel+Elite+(P)+Ltd/@27.7117484,85.3104502,17z/data=!3m1!4b1!4m9!3m8!1s0x39eb18fdefffffff:0xcf6b523c8d383f44!5m2!4m1!1i2!8m2!3d27.7117484!4d85.3130251!16s%2Fg%2F11b6dq98s8?entry=ttu">View map</a></p>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="header-top-nav">
            <div class="wrap">
                <ul>
                    <li ><a href="admin_profile.php">Booking Details</a></li>
                    <li><a href="all-hotel.php">Our Hotels</a></li>
                    <li class="active"><a href="create_owner.php">Owner Accounts</a></li>
                    <li><a href="dispcontact.php">Messages</a></li>
                    <li><a href="userdetail.php">User Details</a></li>
                    <li class="logout-button"><a href="logout.php">Logout</a></li>
                    <div class="clear"> </div>
                </ul>
            </div>
        </div>
    </div>

    <!-- Display Existing Owners -->
    <h2>Existing Hotel Owners</h2>
    <table class="owner-table">
        <thead>
            <tr>
                <th>Owner Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Hotel Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'connection.php';
            $query = "SELECT o.id, o.owner_name, o.owner_email,o.owner_phone, h.name AS hotel_name 
                      FROM hotel_owners o
                      JOIN hotel h ON o.hotel_id = h.id";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['owner_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['owner_email']) . "</td>";
               echo "<td>" . htmlspecialchars($row['owner_phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hotel_name']) . "</td>";
                echo "<td class='actions'>";
                echo "<a href='edit_owner.php?id=" . htmlspecialchars($row['id']) . "'><button class='edit'>Edit</button></a>";
                echo "<button class='delete' onclick=\"confirmDelete(" . htmlspecialchars($row['id']) . ")\">Delete</button>";
                echo "</td>";
                echo "</tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <!-- Create Owner Account Form -->
    <div class="form-container">
        <h2>Create Hotel Owner Account</h2>
        <form method="post" action="create_owner_action.php">
            <label for="hotel_name">Select Hotel:</label>
            <select id="hotel_name" name="hotel_id" class="select2">
                <option value="">-- Select Hotel --</option>
                <?php
                require 'connection.php';
                $query = "SELECT id, name FROM hotel";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
                ?>
            </select>
            
            <label for="owner_name">Owner Name:</label>
            <input type="text" name="owner_name" id="owner_name" required>
            
            <label for="owner_email">Email:</label>
            <input type="email" name="owner_email" id="owner_email" required>

            <label for="owner_phone">Phone Number:</label>
            <input type="tel" name="owner_phone" id="owner_phone" required minlength="10">
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <input type="submit" value="Create Account">
        </form>
    </div>

    <script>
        // Initialize Select2 for the hotel dropdown
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Search and select a hotel",
                allowClear: true
            });
        });

        // Function to confirm deletion
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this owner?")) {
                window.location.href = 'delete_owner.php?id=' + id;
            }
        }
    </script>
</body>
</html>
