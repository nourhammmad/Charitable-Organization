
<?php 

require_once 'TravelPlanTemplate.php';
require_once 'Beneficiary.php';

class BeneficiaryDeliveryTravel extends TravelPlanTemplate {
    // Validate the plan details
    protected function validatePlan($details) {
        if (empty($details['beneficiaries'])) {
            throw new Exception("Validation failed: No beneficiaries specified.");
        }
        if (empty($details['resources'])) {
            throw new Exception("Validation failed: No resources specified.");
        }
        echo "Validated beneficiary delivery plan for " . count($details['beneficiaries']) . " beneficiaries.\n";
    }

    // Allocate resources to beneficiaries
    protected function allocateMeans($details) {
        echo "Allocating " . count($details['resources']) . " resources to " . count($details['beneficiaries']) . " beneficiaries.\n";

        foreach ($details['beneficiaries'] as $beneficiary) {
            echo "Allocated resources to beneficiary: " . $beneficiary['name'] . " at " . $beneficiary['address'] . ".\n";
        }
    }

    // Execute the delivery of resources
    protected function executeTravel($details) {
        echo "Dispatching resources to beneficiaries...\n";
        foreach ($details['beneficiaries'] as $beneficiary) {
            echo "Delivering resources to " . $beneficiary['name'] . " at " . $beneficiary['address'] . ".\n";
        }
    }
}
