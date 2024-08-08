
<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | Reservation </title>
		<link href="../css/style.css" rel="stylesheet" type="text/css"  media="all" />
      <!-- <link href="../css/userprofile.css" rel="stylesheet" type="text/css"  media="all" /> -->
      <link href="../css/reservation.css" rel="stylesheet" type="text/css">
		<!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'> -->
	</head>
	<body>
		<!---start-Wrap--->
			<!---start-header--->
			<div class="header">
				<div class="wrap">
					<div classclass="header-top">
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
							<li ><a href="user_profile.php">Account Details</a></li>
                     <li><a href="../room_details.html">Room Details</a></li>
							<li class="active"><a href="reservation.php">Book Room</a></li>
							<li><a href="reservdetail.php">Booking Details</a></li>
							
                     <li class="logout-button"><a href="logout.php">Logout</a></li>
							
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
    <form id="bookingForm" action="process_booking.php" method="POST">
      <h4 align="left">Please fill up the form</h4>
      <div class="form-group">
         <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>
         </div>
         <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>
         </div>
         <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
         </div>
         <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" required>
         </div>
        
         
         <div class="form-group">
            <label for="roomType">Room Type:</label>
            <select id="roomType" name="roomType" class="form-control" onchange="updateRoomOptions()" required>
                <option value="-1">- Not selected -</option>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Suite">Suite</option>
                <option value="Executive">Executive</option>
                <!-- Add more options as needed -->
            </select>
         </div>
         <div class="form-group">
            <label for="roomNo">Room No:</label>
            <select id="roomNo" name="roomNo" class="form-control" required>
                <option value="-1">- Not selected -</option>
                
                <!-- Available room options will be dynamically populated here -->
            <!-- </select>
         </div>
         <a id="viewDetailsLink" href="../room_details.html" target="_blank">View Room Details</a>
         <script>
        function updateRoomOptions() {
            var roomTypeSelect = document.getElementById("roomType");
            var roomNoSelect = document.getElementById("roomNo");
            var selectedRoomType = roomTypeSelect.value;

            // Clear previous options
            roomNoSelect.innerHTML = "";

            if (selectedRoomType === "-1") {
                roomNoSelect.disabled = true;
                roomNoSelect.innerHTML = '<option value="-1">- Not selected -</option>';
            } else {
                roomNoSelect.disabled = false;
                var roomNumbers = getRoomNumbersForType(selectedRoomType);

                for (var i = 0; i < roomNumbers.length; i++) {
                    var option = document.createElement("option");
                    option.value = roomNumbers[i];
                    option.text = roomNumbers[i];
                    roomNoSelect.appendChild(option);
                }
            }
        }

        // Replace this with your logic to retrieve room numbers based on room type
        function getRoomNumbersForType(roomType) {
            var roomNumberData = {
                "Standard": ["101", "102", "103"],
                "Deluxe": ["201", "202", "203"],
                "Suite": ["301", "302", "303"],
                "Executive": ["401", "402", "403"]
            };

            return roomNumberData[roomType] || [];
        }

        function updateRoomDetails() {
            var roomTypeSelect = document.getElementById("roomType").value;
            var roomNoSelect = document.getElementById("roomNo").value;

            var viewDetailsLink = document.getElementById("viewDetailsLink");
            if (roomTypeSelect !== "-1" && roomNoSelect !== "-1") {
                viewDetailsLink.href = `../room_details.html?type=${roomTypeSelect}&number=${roomNoSelect}`;
            } else {
                viewDetailsLink.href = "../room_details.html";
            }
        }
    </script> -->
         <script>
function updateRoomOptions() {
    var roomTypeSelect = document.getElementById("roomType");
    var roomNoSelect = document.getElementById("roomNo");
    var roomType = roomTypeSelect.value;

    // Clear the existing options
    roomNoSelect.innerHTML = "";

    // Add the default option
    var defaultOption = document.createElement("option");
    defaultOption.value = "-1";
    defaultOption.text = "- Not selected -";
    roomNoSelect.appendChild(defaultOption);

    // Fetch the available room options based on the selected room type
    // Here, you would typically make an AJAX request to fetch the data from the server
    // In this example, we're manually adding some options for demonstration purposes
    if (roomType === "Standard") {
        addRoomOption("101");
        addRoomOption("201");
        addRoomOption("301");
        addRoomOption("401");
    } else if (roomType === "Deluxe") {
        addRoomOption("102");
        addRoomOption("202");
        addRoomOption("302");
        addRoomOption("402");
    } else if (roomType === "Suite") {
        addRoomOption("103");
        addRoomOption("203");
        addRoomOption("303");
        addRoomOption("403");
    } else if (roomType === "Executive") {
        addRoomOption("104");
        addRoomOption("204");
        addRoomOption("304");
        addRoomOption("404");
    }
}

function addRoomOption(roomNo) {
    var roomNoSelect = document.getElementById("roomNo");
    var option = document.createElement("option");
    option.value = roomNo;
    option.text = roomNo;
    roomNoSelect.appendChild(option);
}


// Call the function initially to populate the room options based on the default selected room type
updateRoomOptions();
</script>
         <div class="form-group">
            <label for="checkIn">Check-in Date:</label>
            <input type="date" id="checkIn" name="checkIn" required>
         </div>
         <div class="form-group">
            <label for="checkOut">Check-out Date:</label>
            <input type="date" id="checkOut" name="checkOut" required>
         </div>
       
      
         <div class="form-group">
            <label for="country">Country:</label>
            <select id="country" name="country" class="form-control" required>
                <option value="-1">- Not selected -</option>
                <option value="USA">USA</option>
                <option value="Canada">Canada</option>
                <option value="UK">UK</option>
                <option value="Nepal">Nepal</option>
                <option value="Germany">Germany</option>
                <option value="France">France</option>
                <option value="Australia">Australia</option>
                <option value="Japan">Japan</option>
                <option value="Brazil">Brazil</option>
                <option value="India">India</option>
                <option value="China">China</option>
                <!-- Add more options as needed -->
            </select>
         </div>
         <div class="form-group">
            <button type="submit">Submit</button>
         </div>
      </div>
   </form>
</body>
</html>
