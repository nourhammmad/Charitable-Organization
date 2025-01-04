<?php
// Include necessary files and classes
require_once $_SERVER['DOCUMENT_ROOT'] .'/controllers/OrganizationController.php';

// Fetch addresses from the database
$addresses = EventModel::GetAddresses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            color: #333;
            margin: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            min-height: 100vh;
        }
        
        h1 {
            margin-bottom: 30px;
            font-size: 2.5rem;
            color: #2c3e50;
        }
        .action-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            margin-bottom: 30px;
        }
        .option {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px 25px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 150px;
        }
        .option:hover {
            background-color: #eaf2f8;
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        button[type="submit"] {
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }
        button[type="submit"]:hover {
            background-color: #c9302c;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px 25px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-width: 150px;
        }
        .option:hover {
            background-color: #eaf2f8;
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        button[type="submit"] {
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }
        button[type="submit"]:hover {
            background-color: #c9302c;
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
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            text-align: center;
        }
        .modal-content h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        .modal-content input,
        .modal-content select,
        .modal-content textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .modal-content button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .modal-content button:hover {
            background-color: #45a049;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            color: #aaa;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .close-btn:hover {
            color: #000;
        }

    </style>
</head>
<body>
    <h1>Organization Management</h1>
    <div class="action-options">
        <div class="option" onclick="openModal('organization')">Get Organization</div>
        <div class="option" onclick="openModal('donors')">Get Donors</div>
        <div class="option" onclick="openModal('clothes')">Track Clothes</div>
        <div class="option" onclick="openModal('money')">Track Money</div>
        <div class="option" onclick="openModal('sendAll')">Send Notification</div>
        <div class="option" onclick="openModal('addResource')">Add Resource</div>
        <div class="option" onclick="openModal('addPlan')">Add Plan</div>
        <div class="option" onclick="openModal('createTask')">Create Task</div>
        <div class="option" onclick="openModal('createEvent')">Create Event</div>
        <!-- <div class="option" onclick="openModal('ExecuteTravelPlan')"> Execute Plan</div>  -->
        <div class="option" onclick="openModal('viewtravelplans')">View Travel Plans</div>
        <div class="option" onclick="openModal('addBeneficiary')"> Add Beneficiary</div>
        <div class="option" onclick="openModal('getBeneficiary')"> Get all beneficiaries</div>
        <div class="option" onclick="openModal('update_event')">Update Event</div>
    </div>
    <form action="/controllers/OrganizationController.php?action=logout" method="POST">
        <button type="submit">Logout</button>
    </form>
   

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
            const modal = document.getElementById("actionModal");
            const title = document.getElementById("modalTitle");
            const fields = document.getElementById("dynamicFields");

            // Reset fields
            fields.innerHTML = "";
            if(type=="getBeneficiary"){
                title.textContent = "Get Beneficiary";
                fields.innerHTML = `
                    <table border="1" style="width:100%; border-collapse:collapse; text-align:center;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="beneficiaryTableBody">
                            <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                `;
            
            }
            if(type=="addBeneficiary"){
                title.textContent = "addBeneficiary";
                fields.innerHTML=`<label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>                 
                    <label for="address">Event Address:</label>
                   <select name="address" id="address" required>
                    <option value="" disabled selected>Select an address</option>
                    <?php foreach ($addresses as $address): ?>
                    <option value="<?php echo htmlspecialchars($address['addressId']); ?>">
                    <?php echo htmlspecialchars($address['fullAddress']); ?>
                    </option>
                    <?php endforeach; ?>
                    </select>

                    
                    <label for="beneficiaryType">Type:</label>
                    <select id="beneficiaryType" name="beneficiaryType">
                    <option value="Individual">Individual</option>
                    <option value="Group">Group</option>
                    </select>
                    `;
            }
            if (type === "addPlan") {
                title.textContent = "Add Plan";
                fields.innerHTML = `
                    <label for="planType">Select Plan Type:</label>
                    <select id="planType" name="planType" onchange="updatePlanFields()" required>
                        <option value="">Choose...</option>
                        <option value="resource_delivery">Resource Delivery</option>
                        <option value="beneficiary_travel">Beneficiary Travel</option>
                    </select>
                    <div id="planDetails"></div>
                `;
            }
            if (type === "addResource") {
                title.textContent = "Add Resource";
                fields.innerHTML = `
                    <input type="text" name="resourceName" placeholder="Resource Name" required>
                `;
            }
            else if (type === "organization") {
                title.textContent = "Retrieve Organization";
            } 

            else if (type=="ExecuteTravelPlan")
            {
                title.textContent = "Execute the plan";

            }
            else if (type === "viewtravelplans") {
                title.textContent = "View All Plans";
            }
            else if (type === "donors") {
                title.textContent = "Retrieve Donors";
            } 
            else if(type === 'books'){
                title.textContent = "Track Book Donations";
            }
            else if(type === 'clothes'){
                title.textContent = "Track Clothes Donations";
            }
            else if(type === 'money'){
                title.textContent = "Track Money Donations";
            }
           
            else if(type === 'sendAll'){
                title.textContent = "Send Notification";
                fields.innerHTML = `
                    <input type="text" name="mail" placeholder="Email Name" required>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <input type="text" name="body" placeholder="Body" required>
                    <input type="text" name="phone" placeholder="phone" required>    
                `;
            }
            else if (type === "createEvent") {
                title.textContent = "Create New Event";
                fields.innerHTML = `
                    <input type="text" name="name" placeholder="Event Name" required>
                    <input type="text" name="date" placeholder="Event Date" required>

                   <label for="address">Event Address:</label>
                   <select name="address" id="address" required>
                    <option value="" disabled selected>Select an address</option>
                    <?php foreach ($addresses as $address): ?>
                    <option value="<?php echo htmlspecialchars($address['addressId']); ?>">
                    <?php echo htmlspecialchars($address['fullAddress']); ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                    <input type="number" name="capacity" placeholder="Capacity" required>
                    <input type="number" name="tickets" placeholder="Tickets" required>

                    
                    <label for="service">Service:</label>
                    <select name="service" id="service">
                        <option value="educationalCenter">Educational Center</option>
                        <option value="foodBank">Food Bank</option>
                        <option value="familyShelter">Family Shelter</option>
                    </select>
                    <br>

                    <label for="signLang">Sign Language Interpretation:</label>
                    <input type="checkbox" name="signLang" id="signLang">
                    <br>

                    <label for="wheelchair">Wheelchair Access:</label>
                    <input type="checkbox" name="wheelchair" id="wheelchair">
                    <br>
                `;
            }
            else if(type=="createTask"){
                title.textContent = "Create New Task";
                fields.innerHTML = `
                    <input type="text" name="name" placeholder="Task Name" required>
                    <textarea name="description" placeholder="Task Description" rows="3" required></textarea>
                    <input type="text" name="requiredSkill" placeholder="Required Skill" required>
                    <input type="text" name="timeSlot" placeholder="Time Slot" required>
                    <input type="text" name="location" placeholder="Location" required>
                `;

            }
 if(type=="update_event"){   
        title.textContent = "Update Event";
        fields.innerHTML = `
            <table border="1" style="width:100%; border-collapse:collapse; text-align:center;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="eventTableBody">
                    <!-- Event rows will be populated dynamically -->
                </tbody>
            </table>
        `;
        // Fetch the events data
        fetch('../controllers/EventManagementController.php?action=getEvents',{method: 'GET'})  // Adjust the URL to your API
            .then(response => response.json())
            .then(data => {
                const events = data.events;
                // console.log(data.events);
                const eventTableBody = document.getElementById('eventTableBody');
                eventTableBody.innerHTML = '';  // Clear any existing rows
                
                events.forEach(event => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>${event.eventId}</td>
                        <td>${event.eventName}</td>
                        <td>${event.date}</td>
                        <td><button onclick="editEvent(${event.eventId})">Edit</button></td>
                    `;
                    
                    eventTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching events:', error));       
}

            modal.style.display = "flex";
        }

        function editEvent(eventId) {
          fetch(`../controllers/EventManagementController.php?action=getEventDetails&eventId=${eventId}`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            const event = data.event;
            if (event) {
                showEditModal(event); // This already sets the modal display
            } else {
                console.error('No event found.');
            }
        })
        .catch(error => console.error('Error fetching event details:', error));
}


// Function to open the modal
function showEditModal(event) {
    const section = document.getElementById("editEventSection");
    const title = document.getElementById("editSectionTitle");
    const fields = document.getElementById("editEventFields");

    // Reset fields and show the section
    section.style.display = "block";

    title.textContent = "Edit Event";

    // Populate the section with event details
    fields.innerHTML = `
        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" value="${event.eventName}" required>

        <label for="date">Event Date:</label>
        <input type="date" id="date" value="${event.date}" required>

        <label for="capacity">Attendance Capacity:</label>
        <input type="number" id="capacity" value="${event.EventAttendanceCapacity}" required>

        <label for="tickets">Tickets:</label>
        <input type="number" id="tickets" value="${event.tickets}" required>

        <button id="saveChangesButton" onclick="saveEventChanges(${event.eventId})">Save Changes</button>
        <button onclick="closeEditSection()">Cancel</button>
    `;
}

// Function to hide the section after saving or canceling
function closeEditSection() {
    document.getElementById("editEventSection").style.display = "none";
}

// Ensure saveEventChanges keeps the modal open until changes are saved
function saveEventChanges(eventId) {
    const updatedEvent = {
        eventId: eventId,
        eventName: document.getElementById("eventName").value,
        date: document.getElementById("date").value,
        EventAttendanceCapacity: document.getElementById("capacity").value,
        tickets: document.getElementById("tickets").value,
    };

    fetch('../controllers/EventManagementController.php?action=updateEvent', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(updatedEvent),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Event updated successfully.");
                closeModal();  // Close only after success
            } else {
                alert("Failed to update event. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error updating event:", error);
            alert("An error occurred while updating the event.");
});
}

        function executePlan(planId) {
                const endpoint = `../controllers/OrganizationController.php?action=Executeplan`;

                fetch(endpoint, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ planId: planId }),
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Display success or error message
                    })
                    .catch(error => {
                        console.error("Error executing travel plan:", error);
                    });
            }

        function updatePlanFields() {
            const planType = document.getElementById("planType").value;
            const planDetails = document.getElementById("planDetails");

            if (planType === "resource_delivery") {
                console.log("IN THE RESOURCE");
            planDetails.innerHTML = `
            <style>
                .form-group {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                input, select {
                    width: 100%;
                    padding: 8px;
                    box-sizing: border-box;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                select {
                    height: 100px;
                }
            </style>
            <div class="form-group">
                <label for="destination">Destination:</label>
                <select name="destination" id="destination" required>
                    <option value="" disabled selected>Select a destination</option>
                    <?php foreach ($addresses as $address): ?>
                    <option value="<?php echo htmlspecialchars($address['addressId']); ?>">
                    <?php echo htmlspecialchars($address['fullAddress']); ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
            </div>
            <div class="form-group">
                <label for="numOfVechile">Number of Vehicles:</label>
                <input type="number" id="numOfVechile" name="numOfVechile" required>
            </div>
            <div class="form-group">
                <label for="typeOfTruck">Type of Vechile:</label>
                <input type="text" id="typeOfTruck" name="typeOfTruck" required>
            </div>
            <div class="form-group">
                <label for="resources">Select Resources:</label>
                <select id="resources" name="resources" multiple required>
                    <!-- Dynamically populated options -->
                </select>
            </div>
        `;

        // Fetch resources from the database
        fetch("../controllers/OrganizationController.php?action=getResources")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                const resourcesDropdown = document.getElementById("resources");
                resourcesDropdown.innerHTML = ""; // Clear previous options

                data.forEach(resource => {
                    const option = document.createElement("option");
                    option.value = resource.id;
                    option.textContent = resource.name;
                    resourcesDropdown.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching resources:", error));

        }
        else if (planType === "beneficiary_travel") {
        planDetails.innerHTML = `
            <style>
                .form-group {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }
                input, select {
                    width: 100%;
                    padding: 8px;
                    box-sizing: border-box;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
            </style>
            <div class="form-group">
                <label for="beneficiaries">Select Beneficiary:</label>
                <select id="beneficiaries" name="beneficiaries" required>
                  
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" readonly>
            </div>
            <div class="form-group">
                <label for="numOfVechile">Number of Vehicles:</label>
                <input type="number" id="numOfVechile" name="numOfVechile" required>
            </div>
            <div class="form-group">
                <label for="typeOfTruck">Type of Vehicle:</label>
                <input type="text" id="typeOfTruck" name="typeOfTruck" required>
            </div>
        `;

        // Fetch beneficiaries from the database
        fetch("../controllers/OrganizationController.php?action=getBeneficiary")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                const beneficiariesDropdown = document.getElementById("beneficiaries");
                beneficiariesDropdown.innerHTML = ""; 

                data.forEach(beneficiary => {
                    console.log(beneficiary.name);
                    const option = document.createElement("option");
                    option.value = beneficiary.id;
                    option.textContent = beneficiary.name;
                    option.dataset.address = beneficiary.address; 
                    beneficiariesDropdown.appendChild(option);
                });

                beneficiariesDropdown.addEventListener("change", function () {
                    const selectedOption = beneficiariesDropdown.options[beneficiariesDropdown.selectedIndex];
                    const addressField = document.getElementById("address");
                    addressField.value = selectedOption.dataset.address || "";
                });
            })
            .catch(error => console.error("Error fetching beneficiaries:", error));
        }
        else {
            planDetails.innerHTML = "";
        }

        }
        
        function getBeneficiaries() 
        {
        
            const endpoint = "../controllers/OrganizationController.php?action=getBeneficiary";

            fetch(endpoint)
                .then(response => response.json())
                .then(beneficiaries => {
                    console.log(beneficiaries);
                    const beneficiaryTable = document.getElementById("beneficiaryTableBody");
                    beneficiaryTable.innerHTML = ""; // Clear previous data
                    
                    beneficiaries.forEach((beneficiary, index) => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${beneficiary.name}</td>
                            <td>${beneficiary.address}</td>
                            <td>${beneficiary.beneficiaryType}</td>
                        `;

                        beneficiaryTable.appendChild(row);
                    });
                })
                .catch(error => console.error("Error fetching beneficiaries:", error));
        }



        function closeModal() {
            document.getElementById("actionModal").style.display = "none";
        }


        function submitForm() {
            const form = new URLSearchParams(new FormData(document.getElementById("actionForm")));
            const modalTitle = document.getElementById("modalTitle").textContent;

            let endpoint = "";

            if (modalTitle.includes("Add Resource")) {
                endpoint = "../controllers/OrganizationController.php?action=createResource";
            } else if (modalTitle.includes("Retrieve Organization")) {
                endpoint = "../controllers/OrganizationController.php?action=getOrganizations";
            } 
            else if (modalTitle.includes("Donors")) {
                endpoint = "../controllers/OrganizationController.php?action=getDonors";
            } 
            else if (modalTitle.includes("Track Clothes Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackClothes";
            }
             else if (modalTitle.includes("Track Money Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackMoney";
            } 
            else if (modalTitle.includes("Create New Task")) {
                endpoint = "../controllers/OrganizationController.php?action=createTask";
            } 
            else if (modalTitle.includes("Create New Event")) {
                endpoint = "../controllers/OrganizationController.php?action=createEvent";
            } 
            else if (modalTitle.includes("Track Book Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackBooks";
            } 
            else if (modalTitle.includes("Send Notification")) {
                endpoint = "../controllers/OrganizationController.php?action=sendAll";
            }
            else if (modalTitle.includes("View All Plans")) {
                    endpoint = "../controllers/OrganizationController.php?action=viewtravelplans";

                    // Fetch travel plans and render them
                    fetch(endpoint, {
                        method: "GET", 
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Failed to fetch travel plans.");
                            }
                            return response.json(); 
                        })
                        .then(data => {
                            const fields = document.getElementById("dynamicFields");
                           

                            
                            fields.innerHTML = ""; // Clear previous content
                           // console.log ()


                            if (data.length === 0) {
                                fields.innerHTML = "<p>No travel plans found.</p>";
                            } else {
                                // Create a scrollable container for the plans
                                const scrollableContainer = document.createElement("div");
                                scrollableContainer.style.maxHeight = "300px";
                                scrollableContainer.style.overflowY = "auto";
                                scrollableContainer.style.border = "1px solid #ddd";
                                scrollableContainer.style.padding = "10px";
                                scrollableContainer.style.borderRadius = "5px";

                                // Populate the plans
                                data.forEach(plan => {
                                    const planCard = document.createElement("div");
                                    planCard.style.border = "1px solid #ddd";
                                    planCard.style.marginBottom = "10px";
                                    planCard.style.padding = "10px";
                                    planCard.style.borderRadius = "5px";
                                    console.log("this is no json");
                                    console.log(plan.attributes);
                                    console.log("this is json");
                                    console.log(JSON.stringify(plan.attributes, null, 2));

                                    planCard.innerHTML = `
                                        <strong>Plan ID:</strong> ${plan.id} <br>
                                        <strong>Type:</strong> ${plan.type} <br>
                                        <strong>Destination:</strong> ${plan.destination} <br>
                                        <strong>Attributes:</strong> ${JSON.stringify(plan.attributes, null, 2)} <br>
                                        <button onclick="executePlan(${plan.id})">Execute Plan</button>
                                    `;
                                    scrollableContainer.appendChild(planCard);
                                });

                                fields.appendChild(scrollableContainer);
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching travel plans:", error);
                            const fields = document.getElementById("dynamicFields");
                            fields.innerHTML = "<p>Error loading travel plans.</p>";
                        });

                    return;
               
            }

            else if (modalTitle.includes("Add Plan")) {
                endpoint = "../controllers/OrganizationController.php?action=addPlan";
      
                const planType = document.getElementById("planType").value;
                if(planType=='resource_delivery'){
                
                const attributes = {
                    numOfVechile: form.get("numOfVechile"),
                    typeOfTruck: form.get("typeOfTruck"),
                    resources: Array.from(form.getAll("resources")), 
                };

                body = new URLSearchParams({
                    type: planType,
                    destination: form.get("destination"),
                    attributes:JSON.stringify(attributes),
                });
            }
            else if (planType === 'beneficiary_travel') {
                const attributes = {
                    numOfVechile: form.get("numOfVechile"),
                    typeOfTruck: form.get("typeOfTruck"),
                };
                console.log(attributes.toString());
                console.log(attributes);
                console.log( JSON.stringify(attributes));

                body = new URLSearchParams({
                    type: planType,
                    destination: document.getElementById("address").value.toString(),
                    attributes: JSON.stringify(attributes),
                });
            }

            fetch(endpoint, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: body.toString(),
            })
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error("Error:", error));

            closeModal();
            return; 
            }


            else if(modalTitle.includes("addBeneficiary")){
                endpoint = "../controllers/OrganizationController.php?action=addBeneficiary";
                fetch(endpoint, {
                    method: "POST",
                    body: new URLSearchParams(form),
                })
                .then(response => response.text())
                .then(data => alert("Beneficiary added successfully!"))
                .catch(error => console.error("Error:", error));
                closeModal();
                return; 
            }
            else if(modalTitle.includes("Get Beneficiary")){
                getBeneficiaries();
                 return; 
            }


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
