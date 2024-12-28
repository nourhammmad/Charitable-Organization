<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Management</title>
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
        h1, h2 {
            margin-bottom: 20px;
        }
        .action-options {
            display: flex;
            gap: 20px;
        }
        .option {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .option:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
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
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: relative;
        }
        .modal-content button {
            margin-top: 10px;
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
    <h1>Organization Management</h1>

    <div class="action-options">
        <div class="option" onclick="openModal('organization')">Get Organization</div>
        <div class="option" onclick="openModal('donors')">Get Donors</div>
        <div class="option" onclick="openModal('createEvent')">Create Event</div>
        <div class="option" onclick="openModal('createTask')">Create Task</div>
        <div class="option" onclick="openModal('books')">Track Books</div>
        <div class="option" onclick="openModal('clothes')">Track Clothes</div>
        <div class="option" onclick="openModal('money')">Track Money</div>
        <div class="option" onclick="openModal('sendAll')">Send Notification</div>
    </div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <button type="submit" name="logout" class="organization-button">Logout</button>
    </form>

    <!-- Modal -->
    <div id="actionModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <form id="actionForm">
                <div id="dynamicFields"></div>
                <button type="button" onclick="submitForm()">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(type) {
            fetch('../controllers/OrganizationController.php?action=getModalContent', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `type=${type}`
            })
            .then(response => response.json())
            .then(data => {
                const modal = document.getElementById("actionModal");
                const title = document.getElementById("modalTitle");
                const fields = document.getElementById("dynamicFields");

                title.textContent = data.title;
                fields.innerHTML = "";

                data.fields.forEach(field => {
                    if (field.type === "text" || field.type === "number") {
                        fields.innerHTML += `<input type="${field.type}" name="${field.name}" placeholder="${field.placeholder}" required>`;
                    } else if (field.type === "textarea") {
                        fields.innerHTML += `<textarea name="${field.name}" placeholder="${field.placeholder}" rows="3" required></textarea>`;
                    } else if (field.type === "checkbox") {
                        fields.innerHTML += `<label><input type="checkbox" name="${field.name}"> ${field.label}</label><br>`;
                    } else if (field.type === "select") {
                        let options = field.options.map(opt => `<option value="${opt}">${opt}</option>`).join("");
                        fields.innerHTML += `<label>${field.name}:</label><select name="${field.name}">${options}</select><br>`;
                    }
                });

                modal.style.display = "flex";
            })
            .catch(error => {
                console.error("Error occurred:", error);
                alert("An error occurred while loading the modal content. Please try again.");
            });
        }

        function closeModal() {
            document.getElementById("actionModal").style.display = "none";
        }

        function submitForm() {
            const form = new URLSearchParams(new FormData(document.getElementById("actionForm")));
            const modalTitle = document.getElementById("modalTitle").textContent;
           
            let endpoint = "";
            if (modalTitle.includes("Retrieve Organization")) endpoint = "../controllers/OrganizationController.php?action=getOrganizations";
            if (modalTitle.includes("Donors")) endpoint = "../controllers/OrganizationController.php?action=getDonors";
            if (modalTitle.includes("Track Clothes Donations")) endpoint = "../controllers/OrganizationController.php?action=trackClothes";
            if (modalTitle.includes("Track Money Donations")) endpoint = "../controllers/OrganizationController.php?action=trackMoney";
            if (modalTitle.includes("Event")) endpoint = "../controllers/OrganizationController.php?action=createEvent";
            if (modalTitle.includes("Task")) endpoint = "../controllers/OrganizationController.php?action=createTask";
            if (modalTitle.includes("Track Book Donations")) endpoint = "../controllers/OrganizationController.php?action=trackBooks";
            if (modalTitle.includes("Send Notification")) endpoint = "../controllers/OrganizationController.php?action=sendAll";

            fetch(endpoint, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: form.toString(),
            })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error("Error:", error));

            closeModal();
        }
    </script>
</body>
</html>
