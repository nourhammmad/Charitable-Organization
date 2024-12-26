<?php $donorId = $_GET['donor_id']; ?>
<?php $userId = $_GET['user_id']; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charitable Organization - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #666;
        }
        .donation-options {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }
        .option {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px 20px;
            width: 160px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .option:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 1.2rem;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }
        .option-icon {
            font-size: 2.5rem;
            color: #4CAF50;
        }
        .user-info {
            margin-top: 20px;
            font-size: 1.1rem;
        }
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: relative;
        }
        .modal-content h2 {
            margin-top: 0;
        }
        .modal-content input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .modal-content button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Center the modal */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .close-button {
            color: #aaa;
            font-weight: bold;
            transition: color 0.3s;
        }
        .close-button:hover {
            color: black;
        }
        .history-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .history-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .history-list li {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .styled-button {
        background: linear-gradient(135deg, #4CAF50, #81C784); /* Gradient background */
        color: white; /* Text color */
        border: none; /* No border */
        border-radius: 25px; /* Rounded corners */
        padding: 10px 20px; /* Padding */
        font-size: 16px; /* Font size */
        font-weight: bold; /* Bold text */
        cursor: pointer; /* Pointer cursor on hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        transition: all 0.3s ease; /* Smooth transition */
    }
    
    .styled-button:hover {
        background: linear-gradient(135deg, #388E3C, #66BB6A); /* Darker gradient on hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Slightly deeper shadow */
        transform: translateY(-2px); /* Lift effect */
    }
    
    .styled-button:active {
        transform: translateY(0); /* Remove lift effect on click */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Return to original shadow */
    }


    </style>
</head>
<body>
    <h1>Make a Difference Today</h1>
    <p>Choose a type of donation to help those in need</p>

    <div class="donation-options">
        <div class="option" onclick="openModal('book')">
            <div class="option-icon">📚</div>
            <a>Donate Book</a>
        </div>
        <div class="option" onclick="openModal('money')">
            <div class="option-icon">💰</div>
            <a>Donate Money</a>
        </div>
        <div class="option" onclick="openModal('clothes')">
            <div class="option-icon">👕</div>
            <a>Donate Clothes</a>
        </div>
        <button id="view_notifications" onclick="viewNotifications()">View Notifications</button>

<!-- Modal for Notifications -->
<div id="notificationsModal" style="display: none; position: fixed; top: 20%; left: 30%; width: 40%; background: #fff; border: 1px solid #ccc; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); padding: 20px; z-index: 1000;">
<span class="close-button" style="position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 20px;">&times;</span>
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Notifications</h2>
        <ul id="notification-list">
            <!-- Notifications will be dynamically added here -->
        </ul>
    </div>
</div>
       <!--    <script>
         if (selectedType === "not"){
                let endpoint = "";
                endpoint = "../controllers/DonationController.php?action=getNotifications";
         
            }</script>  -->
<!--          
            <div class="option" id="show-notifications">
            <a href="#">Show Notifications</a>
            </div>
<script>
    document.getElementById("show-notifications").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Extract the user ID (donor ID) from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const donorId = urlParams.get('donor_id');
        if (!donorId) {
            alert("Donor ID is missing.");
            return;
        }

        // Include donorId as a parameter in the endpoint URL
           //header("Location: ./views/HomeView.php?donor_id=$donorId");
        const endpoint = `./controllers/DonationController.php?donor_id=${donorId}&action=getNotifications`;

        fetch(endpoint)
            .then(response => response.json())
            .then(notifications => {
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML = ''; // Clear any previous notifications

                if (notifications.length === 0) {
                    notificationList.innerHTML = '<li>No notifications available.</li>';
                } else {
                    notifications.forEach(notification => {
                        // Create a list item for each notification
                        const li = document.createElement('li');
                        li.textContent = notification.message || JSON.stringify(notification); // Adjust key as per structure
                        notificationList.appendChild(li);
                    });
                }

                // Show the popup and overlay
                document.getElementById('notification-popup').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                alert('Failed to fetch notifications.');
            });
    });

    function closePopup() {
        document.getElementById('notification-popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>
 -->


        
    </div>
    <div class="donation-history">
        <button class="styled-button" onclick="viewDonationHistory()">View Donation History</button>
    </div>
    <div id="donationHistory"></div>
    
    <div id="historyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeHistoryModal()">&times;</span>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button onclick="closeHistoryModal()">Close</button>
            </div>
        </div>
    </div>

<script>
function viewNotifications() {
    // Get donorId from the query string (URL)
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');
    if (!userId) {
        alert("user ID is missing.");
        return;
    }

    // Prepare form data to send to the controller
    const formData = new FormData();
    formData.append('action', 'view_notifications');
    formData.append('userId', userId);

    // Fetch notifications from the server
    fetch("../controllers/DonationController.php", {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())  // Get raw text response
    .then(rawData => {
        alert("Raw Data: " + rawData);  // Print raw data before parsing
        try {
            const data = JSON.parse(rawData);  // Parse JSON from raw data
            // Check if the response is successful
            if (data.success) {
                displayNotifications(data.notifications);  // Display notifications
            } else {
                alert(data.message || 'Error fetching notifications.');
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
            alert("Invalid JSON format.");
        }
    })
    .catch(error => {
        console.error('Error fetching notifications:', error);
        alert('An error occurred while fetching notifications.');
    });
}

function displayNotifications(notifications) {
    const notificationsModal = document.getElementById("notificationsModal");
    const notificationList = document.getElementById("notification-list");

    // Clear previous notifications
    notificationList.innerHTML = '';

    // If there are no notifications
    if (notifications && notifications.length > 0) {
        notifications.forEach(notification => {
            const li = document.createElement('li');
            
            // Create a string containing sender's name and the message
            li.textContent = `${notification.senderName}: ${notification.message  || 'No message available'} : ${notification.createdAt}`;
            
            notificationList.appendChild(li);
        });
    } else {
        const li = document.createElement('li');
        li.textContent = 'No notifications found.';
        notificationList.appendChild(li);
    }

    // Show the modal
    notificationsModal.style.display = 'block';

    // Close button functionality
    const closeButton = notificationsModal.querySelector(".close-button");
    if (closeButton) {
        console.log("Close button found"); // Debugging: Log if close button is found
        closeButton.addEventListener("click", () => {
            notificationsModal.style.display = 'none';
        });
    } else {
        console.error("Close button not found");
    }
}


</script>


    
    <script>
  

    function viewDonationHistory() {
        // Get donorId from the query string (URL)
        const urlParams = new URLSearchParams(window.location.search);
        const donorId = urlParams.get('donor_id');
        if (!donorId) {
        alert("Donor ID is missing.");
        return;
        }

        const formData = new FormData();
        formData.append('action', 'view_history');
        formData.append('donorId', donorId);

        fetch("../controllers/DonationController.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text()) 
            .then(data => {
                const parsedData = JSON.parse(data); 
                if (parsedData.success) {
                    displayDonationHistory(parsedData.donations);
                } else {
                    alert(parsedData.message || 'Error fetching donation history.');
                }
            })
            .catch(error => {
                console.error('Error fetching donation history:', error);
                alert('An error occurred while fetching donation history.');
            });
    }
    // Display Donation History with Undo/Redo buttons
    function displayDonationHistory(donations) {
    let historyContent = `
        <h2>Donation History</h2>
        <span class="close-button" style="position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 20px;">&times;</span>
    `;
    if (donations && donations.length > 0) {
        historyContent += "<ul>";
        donations.forEach(donation => {

            let donationType;
            switch (donation.donation_type_id) {
                case '1':
                    donationType = "Money";
                    break;
                case '2':
                    donationType = "Books";
                    break;
                case '3':
                    donationType = "Clothes";
                    break;
                default:
                    donationType = "Unknown";
            }

            const undoButtonDisabled = "DELETE";
            const redoButtonDisabled = "CREATE";

            historyContent += `
                <li>
                    ${donationType}: ${donation.description}
                    <button onclick="undoDonation(${donation.log_id})" ${undoButtonDisabled}>Undo</button>
                    <button onclick="redoDonation(${donation.log_id})" ${redoButtonDisabled}>Redo</button>
                    <hr>
                </li>
            `;
        });
        historyContent += "</ul>";
    } else {
        historyContent += "<p>No donations found.</p>";
    }

    // Display the donation history in the modal
    const historyModal = document.getElementById("historyModal");
    const modalContent = historyModal.querySelector(".modal-content");
    modalContent.innerHTML = historyContent;
    historyModal.style.display = "flex";

    // Close button functionality
    const closeButton = modalContent.querySelector(".close-button");
    closeButton.addEventListener("click", () => {
        historyModal.style.display = "none";
    });
    }


function undoDonation(logId) {
    const urlParams = new URLSearchParams(window.location.search);
    const donorId = urlParams.get('donor_id');

    if (!donorId) {
        alert("Donor ID is missing.");
        return;
    }


    const formData = new FormData();
    formData.append('action', 'undo');
    formData.append('log_id', logId);  
    formData.append('donorId', donorId);  

    fetch("../controllers/DonationController.php", {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
    try {
        const parsedData = JSON.parse(data);
        if (parsedData.success) {
            alert(parsedData.message || "Undo successful.");
            viewDonationHistory();
        } else {
            alert(parsedData.message || "Error undoing donation action.");
        }
    } catch (e) {
        console.error('Invalid JSON response:', data);
        alert('An unexpected error occurred.');
    }
})


}



function redoDonation(logId) {
    const urlParams = new URLSearchParams(window.location.search);
    const donorId = urlParams.get('donor_id');

    if (!donorId) {
        alert("Donor ID is missing.");
        return;
    }


    const formData = new FormData();
    formData.append('action', 'redo');
    formData.append('log_id', logId);  
    formData.append('donorId', donorId);  

    fetch("../controllers/DonationController.php", {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        try {
            const parsedData = JSON.parse(data);
            if (parsedData.success) {
                alert(parsedData.message || "Redo successful.");
                viewDonationHistory();
            } else {
                alert(parsedData.message || "Error undoing donation action.");
            }
        } catch (e) {
            console.error('Invalid JSON response:', data);
            alert('An unexpected error occurred.');
        }
    })
}


    function closeHistoryModal() {
        const historyModal = document.getElementById("historyModal");
        if (historyModal) {
            historyModal.style.display = "none";
        } else {
            console.error("Modal with id 'historyModal' not found in the DOM.");
        }
    }


    </script>




    <div class="user-info">
        <p id="user-id-display">Donor ID: <?php echo htmlspecialchars($_GET['donor_id'] ?? 'Not loaded'); ?></p>
    </div>

    <!-- Donation Modal -->
    <div id="donationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Donate</h2>
            <form id="donationForm">
            <input type="hidden" name="donorId" value="<?php echo htmlspecialchars($_GET['donor_id'] ?? ''); ?>">
                <!-- Book fields -->
                <div id="bookFields" style="display: none;">
                    <input type="text" id="bookTitle" placeholder="Book Title" required>
                    <input type="text" id="author" placeholder="Author" required>
                    <input type="number" id="publicationYear" placeholder="Publication Year" required>
                    <input type="number" id="quantity" placeholder="Quantity" required>
                </div>

               <!-- Clothes fields -->
                <div id="clothesFields" style="display: none;">
                    <input type="text" id="size" placeholder="Size (e.g., M, L)" required>
                    <input type="number" id="clothesQuantity" placeholder="Quantity" required>
                    <input type="text" id="clothesType" placeholder="Type of Clothes (e.g., Shirt, Jacket)" required>
                    <input type="text" id="clothesColor" placeholder="Color" required>
                </div>
                <div id="moneyFields" style="display: none;">
                    <select id="paymentType" onchange="updatePaymentFields()">
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="visa">Visa</option>
                        <option value="instapay">Instapay</option>
                    </select>
                    <div id="cashFields" style="display: none;">
                        <input type="number" id="cashAmount" placeholder="Amount" required>
                        <input type="text" id="cashCurrency" placeholder="Currency" required>
                    </div>
                    <div id="visaFields" style="display: none;">
                        <input type="number" id="visaAmount" placeholder="Amount" required>
<input type="text"   id="cardNumber" placeholder="Card Number" required>
                        <input type="text"   id="visaCurrency" placeholder="Currency" required>
                        <!-- <input type="text" id="cardHolderName" placeholder="Card Holder Name" required>
                        <input type="text" id="expiryDate" placeholder="Expiry Date (MM/YY)" required>
  <input type="number" id="cvv" placeholder="CVV" required> -->
                    </div>
                    <div id="instapayFields" style="display: none;">
                        <input type="number" id="instapayAmount" placeholder="Amount" required>
                        <input type="text" id="accountID" placeholder="Account ID" required>
                        <input type="text" id="accountHolderName" placeholder="Account Holder Name" required>
                        <input type="number" id="balance" placeholder="Balance" required>
                        <input type="number" id="transactionFee" placeholder="Transaction Fee" required>
                    </div>
                </div>


                <button type="button" onclick="submitDonationForm()">Donate</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(type) {
            document.getElementById("donationModal").style.display = "flex";
            document.getElementById("modalTitle").innerText = `Donate ${type.charAt(0).toUpperCase() + type.slice(1)}`;

            // Show only the fields relevant to the selected donation type
            document.getElementById("bookFields").style.display = type === 'book' ? "block" : "none";
            document.getElementById("moneyFields").style.display = type === 'money' ? "block" : "none";
            document.getElementById("clothesFields").style.display = type === 'clothes' ? "block" : "none";
        }

        function closeModal() {
            document.getElementById("donationModal").style.display = "none";
        }

        function updatePaymentFields() {
            const paymentType = document.getElementById("paymentType").value;
            document.getElementById("cashFields").style.display = paymentType === "cash" ? "block" : "none";
            document.getElementById("visaFields").style.display = paymentType === "visa" ? "block" : "none";
            document.getElementById("instapayFields").style.display = paymentType === "instapay" ? "block" : "none";
        }


        function submitDonationForm() {
            const formData = new URLSearchParams();
            const selectedType = document.getElementById("modalTitle").innerText.split(' ')[1].toLowerCase();
            formData.append("donorId", document.querySelector('input[name="donorId"]').value);
            formData.append("donationType", selectedType);

            if (selectedType === "book") {
                formData.append("bookTitle", document.getElementById("bookTitle").value);
                formData.append("author", document.getElementById("author").value);
                formData.append("publicationYear", document.getElementById("publicationYear").value);
                formData.append("quantity", document.getElementById("quantity").value);
            }
            else if (selectedType === "clothes") {
                formData.append("size", document.getElementById("size").value);
                formData.append("quantity", document.getElementById("clothesQuantity").value);
                formData.append("type", document.getElementById("clothesType").value);
                formData.append("color", document.getElementById("clothesColor").value);
            } else if (selectedType === "money") {
                const paymentType = document.getElementById("paymentType").value;
                formData.append("paymentType", paymentType);

                if (paymentType === "cash") {
                    formData.append("amount", document.getElementById("cashAmount").value);
                    formData.append("currency", document.getElementById("cashCurrency").value);
                } else if (paymentType === "visa") {
                    formData.append("amount", document.getElementById("visaAmount").value);
                    formData.append("cardNumber", document.getElementById("cardNumber").value);
                    formData.append("currency", document.getElementById("visaCurrency").value);
                } else if (paymentType === "instapay") {
                    formData.append("amount", document.getElementById("instapayAmount").value);
                    formData.append("accountID", document.getElementById("accountID").value);
                    formData.append("accountHolderName", document.getElementById("accountHolderName").value);
                    formData.append("balance", document.getElementById("balance").value);
                    formData.append("transactionFee", document.getElementById("transactionFee").value);
                }
            }

            fetch("../controllers/DonationController.php", {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                closeModal();
            })
            .catch(error => console.error('Error:', error));
        }


       

    </script>
</body>
</html>