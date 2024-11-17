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
            else if (selectedType === "money") {
        
                if (document.getElementById("paymentType").value === "cash") {
                formData.append("paymentType", "cash");
                formData.append("amount", document.getElementById("cashAmount").value);
                formData.append("currency", document.getElementById("cashCurrency").value);
                }
   else if (document.getElementById("paymentType").value === "visa") {
                formData.append("paymentType", "visa");
                formData.append("amount", document.getElementById("visaAmount").value);
                formData.append("currency", document.getElementById("visaCurrency").value);
                formData.append("cardNumber", document.getElementById("cardNumber").value);
                }
                //add instapay
            } 
            else if (selectedType === "clothes") {
                formData.append("size", document.getElementById("size").value);
                formData.append("quantity", document.getElementById("clothesQuantity").value);
                formData.append("type", document.getElementById("clothesType").value);
                formData.append("color", document.getElementById("clothesColor").value);
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