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
        <div class="option" onclick="openModal('clothes')">Track Clothes</div>
        <div class="option" onclick="openModal('money')">Track Money</div>
        <div class="option" onclick="openModal('sendAll')">Send Notification</div>
        <div class="option" onclick="openModal('addResource')">Add Resource</div>
        <div class="option" onclick="openModal('addPlan')">Add Plan</div>
        <div class="option" onclick="openModal('createTask')">Create Task</div>
        <div class="option" onclick="openModal('createEvent')">Create Event</div>
        <div class="option" onclick="openModal('ExecuteTravelPlan')"> Execute Plan</div>
    
       
        
    </div>
    </div>
    <form action="/controllers/OrganizationController.php?action=logout" method="POST">
    <button type="submit">Logout</button>
</form>

  

    <!---style--->
    <style>
    .action-options {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .option {
        background-color: #f1f1f1;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px 20px;
        text-align: center;
        cursor: pointer;
        min-width: 120px;
    }

  
</style>

    <!-- Modal -->
    <div id="actionModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <form id="actionForm">
                <!-- Dynamic fields -->
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
            if (type === "addPlan") {
                title.textContent = "Add Plan";
                fields.innerHTML = `
                    <label for="planType">Select Plan Type:</label>
                    <select id="planType" name="planType" onchange="updatePlanFields()" required>
                        <option value="">Choose...</option>
                        <option value="resource_delivery">Resource Delivery</option>
                        <option value="volunteer_travel">Volunteer Travel</option>
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
            
            else if (type === "donors") {
                title.textContent = "Retrieve Donors";
            } else if(type === 'books'){
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
                    <input type="text" name="address" placeholder="Event Address" required>
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

            modal.style.display = "flex";
        }

        function updatePlanFields() {
            const planType = document.getElementById("planType").value;
            const planDetails = document.getElementById("planDetails");

            if (planType === "resource_delivery") {
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
                <input type="text" id="destination" name="destination" required>
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
            // } else if (planType === "volunteer_travel") {
            //     planDetails.innerHTML = `
            //         <label for="travelDetails">Travel Details:</label>
            //         <textarea id="travelDetails" name="travelDetails" rows="3" required></textarea>
            //     `;
            // } else {
            //     planDetails.innerHTML = "";
            // }
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
            } else if (modalTitle.includes("Donors")) {
                endpoint = "../controllers/OrganizationController.php?action=getDonors";
            } else if (modalTitle.includes("Track Clothes Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackClothes";
            } else if (modalTitle.includes("Track Money Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackMoney";
            } else if (modalTitle.includes("Create New Task")) {
                endpoint = "../controllers/OrganizationController.php?action=createTask";
            } else if (modalTitle.includes("Create New Event")) {
                endpoint = "../controllers/OrganizationController.php?action=createEvent";
            } else if (modalTitle.includes("Track Book Donations")) {
                endpoint = "../controllers/OrganizationController.php?action=trackBooks";
            } else if (modalTitle.includes("Send Notification")) {
                endpoint = "../controllers/OrganizationController.php?action=sendAll";
            } else if (modalTitle.includes("Add Plan")) {
                endpoint = "../controllers/OrganizationController.php?action=addPlan";

                // Handle custom logic for "Add Plan"
                const planType = document.getElementById("planType").value;
                const attributes = {
                    numOfVechile: form.get("numOfVechile"),
                    typeOfTruck: form.get("typeOfTruck"),
                    resources: Array.from(form.getAll("resources")), // Handles multiple selected options
                };

                const body = new URLSearchParams({
                    type: planType,
                    destination: form.get("destination"),
                    attributes: JSON.stringify(attributes),
                });

                fetch(endpoint, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: body.toString(),
                })
                    .then(response => response.text())
                    .then(data => alert(data))
                    .catch(error => console.error("Error:", error));

                closeModal();
                return; // Prevent further execution for "Add Plan"
            }
            else if (type == "ExecuteTravelPlan") {
                title.textContent = "Execute the plan";
                fields.innerHTML = `
                    <label for="planId">Plan ID:</label>
                    <input type="number" name="planId" id="planId" required>
                `;
            }


            // General fetch logic for other modal actions
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
