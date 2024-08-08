<!DOCTYPE html>
<html>
<head>
    <title>Manage User Accounts</title>
    
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* cointainer /
        .container{
            / to make footer at bottom /
            flex-grow: 1;
        }
        / Table Styles */
        .user-accounts-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .user-accounts-table th,
        .user-accounts-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        
        .user-accounts-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .user-accounts-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Link Styles */
        .user-action-link {
            color: #337ab7;
            text-decoration: none;
        }
    
        .user-action-link:hover {
            text-decoration: underline;
        }
    </style>
    <link href="../css/admin.css" rel="stylesheet" type="text/css"  media="all" />

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
							<!-- <li><a href="change_password.php">Change Password</a></li> -->
							
							<li ><a href="dispcontact.php">Messages</a></li>
							<li class="active" ><a href="userdetail.php">User Details</a></li>
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
    <main class="container">
  <h1>Manage User Accounts</h1>
  <br/>
  <!-- Table to display user accounts -->
  <table class="user-accounts-table">
    <tr>
        <th>First Name</th>
        <th>last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <?php include 'get_user_accounts.php'; ?>
  </table>
    </main>
 
</body>
</html>