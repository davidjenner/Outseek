<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Outlook Simulator</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .email-client-container {
      border: 20px solid blue;
      border-radius: 10px;
      border-image: url('https://archive.org/download/win10-backgrounds/Win10%20DBs/img0_3840x2160.jpg') 30 round;
      background-size: cover;
      background-position: center;
      max-height: 600px; /* Add max-height to the email client container */
      overflow: auto; /* Add overflow property to enable scrolling */
    }
    .email-client {
      padding: 0;
    }
    .email-preview.bold {
      font-weight: bold;
    }
    .navbar {
      height: 50px;
    }
    .outseek-logo {
      color: white;
      font-weight: bold;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 60%;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    .bottom-navbar {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #333;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .bottom-navbar i {
      color: white;
      font-size: 20px;
      margin-right: 10px;
    }
    .search-box {
      background-color: black;
      color: white;
      border: none;
      padding: 8px 10px;
      border-radius: 5px;
      width: 200px;
      outline: none;
    }
    .current-time {
      color: white;
      font-size: 16px;
    }
    /* Lock screen overlay styles */
    .lock-screen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .lock-screen-form {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      text-align: center;
    }
    .lock-screen-form input[type="text"],
    .lock-screen-form input[type="password"] {
      width: 100%;
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .lock-screen-form button {
      background-color: #333;
      color: white;
      border: none;
      padding: 8px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="email-client-container">
    <div class="email-client flex flex-col h-screen">
      <nav class="bg-blue-500 p-4 navbar flex justify-between items-center">
        <ul class="flex space-x-4 items-center">
          <li><h1 class="outseek-logo p-1">Outseek</h1></li>
        </ul>
        <div class="flex items-center justify-center flex-grow">
          <input type="text" placeholder="Search" class="w-full max-w-lg rounded-l-md px-4 py-2 border-2 border-blue-300 focus:outline-none focus:border-blue-500">
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">Search</button>
        </div>
        <img src="thumbnail.jpg" alt="User Thumbnail" class="w-10 h-10 rounded-full ml-4">
      </nav>
      <nav class="bg-gray-200 p-2 flex justify-between items-center">
        <ul class="flex space-x-4 items-center">
          <li><a href="#" class="text-gray-800">Home</a></li>
          <li><a href="#" class="text-gray-800">View</a></li>
          <li><a href="#" class="text-gray-800">Help</a></li>
        </ul>
      </nav>
      <nav class="bg-white p-2 flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <button id="newEmailButton" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-md">
            <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4l8 4-8 4-8-4zM20 12v3m0 0v3m0-3h3m-3 0h-3"></path>
            </svg>
            New Email
          </button>

          <button class="text-gray-800"><i class="far fa-trash-alt"></i></button>
          <button class="text-gray-800"><i class="fas fa-exclamation-triangle"></i></button>
          <button class="text-gray-800"><i class="fas fa-thumbtack"></i></button>
          <button class="text-gray-800"><i class="far fa-envelope-open"></i></button>
          <button class="text-gray-800"><i class="fas fa-print"></i></button>
        </div>
      </nav>
      <div class="flex flex-grow">
        <div class="sidebar w-1/4 bg-white p-4 border-r border-gray-300">
          <h2 class="font-bold text-lg mb-4">Navigation</h2>
          <ul id="emails" class="space-y-2">
            <!-- Emails will be dynamically added here -->
          </ul>
        </div>
        <div class="email-content w-3/4 flex flex-col">
          <div class="email-preview bg-white p-4 border-b border-gray-300">
            <h2 class="font-bold text-lg mb-4">Email</h2>
            <div id="email-header" class="mb-4"></div>
            <div id="email-body-content"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for composing a new email -->
  <div id="composeModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="text-xl font-bold mb-4">Compose New Email</h2>
      <div class="mb-4">
        <label for="to">To:</label>
        <input type="text" id="to" name="to" class="w-full border rounded-md p-2">
      </div>
      <div class="mb-4">
        <label for="cc">CC:</label>
        <input type="text" id="cc" name="cc" class="w-full border rounded-md p-2">
      </div>
      <div class="mb-4">
        <label for="bcc">BCC:</label>
        <input type="text" id="bcc" name="bcc" class="w-full border rounded-md p-2">
      </div>
      <div class="mb-4">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" class="w-full border rounded-md p-2">
      </div>
      <div class="mb-4">
        <label for="emailBody">Body:</label>
        <textarea id="emailBody" rows="5" class="w-full border rounded-md p-2"></textarea>
      </div>
      <button id="sendButton" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md">Send</button>
    </div>
  </div>

 <!-- Lock screen overlay -->
<div id="lockScreen" class="lock-screen">
  <img src="https://cdn.wccftech.com/wp-content/uploads/2020/05/premium-theme.jpeg" alt="Windows 10 Login" class="w-full h-full object-cover fixed inset-0" style="filter: blur(4px);">
  <div class="absolute inset-0 flex justify-center items-center flex-col"> <!-- Center the content -->
    <h2 class="text-6xl font-semibold mb-8">Signed Out</h2> <!-- Increase the font size -->
    <div class="w-1/4 p-6 rounded-md shadow-md">
      <input id="username" type="text" placeholder="Username" class="mb-2 w-full px-4 py-2 border border-gray-300 rounded-md">
      <input id="password" type="password" placeholder="Password" class="mb-2 w-full px-4 py-2 border border-gray-300 rounded-md">
      <button onclick="unlockScreen()" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full">Log In</button>
    </div>
  </div>
</div> 
  





  <div class="bottom-navbar">
    <i class="fab fa-windows"></i>
    <div class="flex items-center justify-center flex-grow"> <!-- Center the search box -->
      <input type="text" class="search-box" placeholder="Search">
    </div>
    <div id="musicPlayer" class="flex items-right"> <!-- Adjusted music player position -->
      <button id="playButton" class="text-white mr-2 focus:outline-none"> <!-- Adjusted margin and alignment -->
        <i id="playIcon" class="fas fa-play"></i>
      </button>
      <div class="current-time" id="current-time"></div>
    </div>
  </div>

  <script src="script.js"></script>
<script>
  function unlockScreen() {
    document.getElementById('lockScreen').style.display = 'none';
  }
</script>
  <script>
    function updateTimeAndStatus() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
      document.getElementById('current-time').textContent = timeString;

      var weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      var dayOfWeek = weekdays[now.getDay()];
      var statusElement = document.getElementById('status');

      if (hours >= 9 && hours < 17 && weekdays >= 1 && weekdays <= 5) { // Check if it's a weekday between 9am and 5pm
        var statuses = ['Busy', 'In a Meeting', 'Available'];
        var randomIndex = Math.floor(Math.random() * statuses.length);
        statusElement.textContent = statuses[randomIndex];
      } else {
        statusElement.textContent = 'Out of Office';
        document.getElementById('lockScreen').style.display = 'flex'; // Show the lock screen overlay
      }
    }

    updateTimeAndStatus();
    setInterval(updateTimeAndStatus, 3600000); // Update time and status every hour

    function unlockScreen() {
      // Authenticate user and unlock the screen if successful
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;

      // Dummy authentication for demonstration
      if (username === 'admin' && password === 'password') {
        document.getElementById('lockScreen').style.display = 'none'; // Hide the lock screen overlay
      } else {
        alert('Invalid username or password');
      }
    }
  </script>
  <script>
    // Get the modal
    var modal = document.getElementById("composeModal");

    // Get the button that opens the modal
    var btn = document.getElementById("newEmailButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    // Function to send the email and close the modal
    function sendEmail() {
      // Get input values
      var to = document.getElementById("to").value;
      var cc = document.getElementById("cc").value;
      var bcc = document.getElementById("bcc").value;
      var subject = document.getElementById("subject").value;
      var body = document.getElementById("emailBody").value;

      // Close the modal
      modal.style.display = "none";
      // Here you can send the email using the provided values
      console.log("To:", to);
      console.log("CC:", cc);
      console.log("BCC:", bcc);
      console.log("Subject:", subject);
      console.log("Body:", body);
    }

    // Attach click event listener to the send button
    document.getElementById("sendButton").addEventListener("click", sendEmail);

    // Function to update current time every second
    function updateTime() {
      var currentTime = new Date();
      var hours = currentTime.getHours();
      var minutes = currentTime.getMinutes();
      var seconds = currentTime.getSeconds();

      // Add leading zero if minutes or seconds is less than 10
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      // Format the time as HH:MM:SS
      var formattedTime = hours + ':' + minutes + ':' + seconds;

      // Update the current time in the bottom bar
      document.getElementById('current-time').innerText = formattedTime;
    }

    // Update time initially and then every second
    updateTime();
    setInterval(updateTime, 1000);

    document.addEventListener("DOMContentLoaded", function() {
    const emailsContainer = document.getElementById('emails');
    const emailBodyContent = document.getElementById('email-body-content');

    // Function to generate a random email
    function generateRandomEmail() {
        const companyNames = ["Acme Corporation", "Globex Corporation", "Initech", "Wayne Enterprises", "Stark Industries"];
        const senders = [
            { name: "John Doe", email: "john.doe@" + companyNames[Math.floor(Math.random() * companyNames.length)].replace(/\s+/g, '').toLowerCase() + ".com" },
            { name: "Jane Smith", email: "jane.smith@" + companyNames[Math.floor(Math.random() * companyNames.length)].replace(/\s+/g, '').toLowerCase() + ".com" },
            { name: "Michael Johnson", email: "michael.johnson@" + companyNames[Math.floor(Math.random() * companyNames.length)].replace(/\s+/g, '').toLowerCase() + ".com" },
            { name: "Emily Davis", email: "emily.davis@" + companyNames[Math.floor(Math.random() * companyNames.length)].replace(/\s+/g, '').toLowerCase() + ".com" }
        ];

        const scenarios = ["Normal", "Reply", "Forward", "Group", "Calendar Invitation", "Zoom Meeting Invitation"];
        const randomScenario = scenarios[Math.floor(Math.random() * scenarios.length)];

        let subject;
        let body;

        switch (randomScenario) {
            case "Reply":
                subject = "Re: Job Opportunity";
                body = "Hi,\n\nThank you for reaching out to me regarding the job opportunity. I am definitely interested in discussing this further.\n\nBest regards,\nJohn Doe";
                break;
            case "Forward":
                subject = "Fwd: Important Information";
                body = "Hi Team,\n\nPlease find below the forwarded email with important information.\n\nBest,\nJane Smith\n\n---------- Forwarded message ---------\nFrom: sender@example.com\nDate: Wed, Mar 9, 2024 at 10:00 AM\nSubject: Important Information\nTo: recipient@example.com\n\n...";
                break;
            case "Group":
                subject = "Team Meeting";
                body = "Hi all,\n\nJust a reminder of our team meeting scheduled for tomorrow at 10:00 AM. Attached is the agenda.\n\nBest regards,\nMichael Johnson";
                break;
            case "Calendar Invitation":
                subject = "Calendar Invitation: Project Kickoff Meeting";
                body = "Hi team,\n\nYou are invited to attend the kickoff meeting for the new project. Please see the attached calendar invite for details.\n\nBest,\nEmily Davis";
                break;
            case "Zoom Meeting Invitation":
                subject = "Zoom Meeting Invitation: Weekly Status Update";
                body = "Hi team,\n\nYou're invited to join the weekly status update meeting via Zoom. Click on the link below to join:\n\nhttps://zoom.us/j/123456789\n\nBest regards,\nJohn Doe";
                break;
            default:
                subject = "Job Opportunity";
                body = "Hi,\n\nWe have an exciting job opportunity available. Please let me know if you're interested.\n\nBest,\nJane Smith";
        }

        const randomSender = senders[Math.floor(Math.random() * senders.length)];
        return {
            sender: `${randomSender.name} <${randomSender.email}>`,
            subject: subject,
            body: body
        };
    }

    // Function to generate and add a new email to the inbox
    function addNewEmail() {
        const email = generateRandomEmail();
        const emailItem = document.createElement('div');
        emailItem.classList.add('email', 'border-b', 'border-gray-200', 'py-4', 'font-semibold', 'cursor-pointer'); // Added cursor-pointer to make it clear that email previews are clickable
        emailItem.innerHTML = `
            <h3 class="font-semibold">${email.sender}</h3>
            <p class="text-gray-600">${email.subject}</p>
        `;
        emailItem.addEventListener('click', () => {
            // Remove bold font weight from all email previews
            const allEmails = document.querySelectorAll('.email');
            allEmails.forEach(item => {
                item.classList.remove('bold');
                item.style.backgroundColor = 'transparent'; // Reset background color
            });

            // Set background color of selected email preview
            emailItem.classList.add('bold'); // Add bold font weight
            emailItem.style.backgroundColor = '#f3f4f6'; // Light gray background

            // Remove bold font weight after 10 seconds
            setTimeout(() => {
                emailItem.classList.remove('bold');
                emailItem.style.backgroundColor = 'transparent'; // Reset background color
            }, 10000);

            showEmail(email);
        });
        emailsContainer.insertBefore(emailItem, emailsContainer.firstChild);
    }

    // Function to update the inbox with new emails
    function updateInbox() {
        setInterval(addNewEmail, 6000); // Add a new email every 6 seconds
    }

    // Function to display the selected email
    function showEmail(email) {
        emailBodyContent.innerHTML = `
            <h3 class="font-semibold">${email.subject}</h3>
            <p class="text-gray-600">${email.body}</p>
        `;
    }

    // Start updating the inbox
    updateInbox();
});
  </script>
</body>
</html>
