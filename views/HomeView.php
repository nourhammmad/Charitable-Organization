<?php $donorId = $_GET['donor_id']; ?>

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
        
    </div>
    <div class="donation-history">
        <button onclick="viewDonationHistory()">View Donation History</button>
    </div>
    <div id="donationHistory"></div>
    
    <div id="historyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeHistoryModal()">&times;</span>
            <div class="modal-body">
                <!-- Donation History content will be injected here -->
            </div>
            <div class="modal-footer">
                <button onclick="closeHistoryModal()">Close</button>
            </div>
        </div>
    </div>


    
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
    function displayDonationHistory(donations) {
        const historyModal = document.getElementById("historyModal");
        if (!historyModal) {
            console.error("Modal with id 'historyModal' not found in the DOM.");
            return;
        }

        const modalContent = historyModal.querySelector(".modal-content");
        if (!modalContent) {
            console.error("Element with class 'modal-content' not found inside #historyModal.");
            return;
        }

        let historyContent = "<h2>Donation History</h2>";
        if (donations && donations.length > 0) {
            historyContent += "<ul>";
            donations.forEach(donation => {
                historyContent += `<li>${donation.donation_item_id}: ${donation.action}</li>`;
            });
            historyContent += "</ul>";
        } else {
            historyContent += "<p>No donations found.</p>";
        }

        modalContent.innerHTML = historyContent;
        historyModal.style.display = "flex";
    }

    function closeHistoryModal() {
        const historyModal = document.getElementById("historyModal");
        if (historyModal) {
            historyModal.style.display = "none";
        } else {
            console.error("Modal with id 'historyModal' not found in the DOM.");
        }
    }

    // function displayDonationHistory(donations) {
    //     let historyContent = "<h2>Donation History</h2>";
    //     if (donations && donations.length > 0) {
    //         historyContent += "<ul>";
    //         donations.forEach(donation => {
    //             historyContent += `<li>${donation.donation_item_id}: ${donation.action}</li>`;
    //         });
    //         historyContent += "</ul>";
    //     } else {
    //         historyContent += "<p>No donations found.</p>";
    //     }

    //     // Display the donation history in a modal or a dedicated section
    //     const historyModal = document.getElementById("historyModal");
    //     historyModal.querySelector(".modal-content").innerHTML = historyContent;
    //     historyModal.style.display = "flex";

    // }

    // function closeHistoryModal() {
    //     document.getElementById("historyModal").style.display="none";
    // }


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
            } else if (selectedType === "clothes") {
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