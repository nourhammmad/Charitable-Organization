<?php 

require_once 'TravelPlanTemplate.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/BeneficiaryModel.php";

class BeneficiaryTravel extends TravelPlanTemplate {

    // Validate the plan details
    protected function validatePlan($details) {
        // $resources = $details['resources'] ?? [];
        // $beneficiaries = $details['beneficiaries'] ?? [];

        if (empty($details['beneficiaries'])) {
            throw new Exception("Validation failed: No beneficiaries specified.");
        }
        if (empty($details['resources'])) {
            throw new Exception("Validation failed: No resources specified.");
        }

        echo "Validation successful: " . count($details['beneficiaries']) . " beneficiaries and " . count($details['resources']) . " resources.\n";
    }

    // Allocate resources to beneficiaries
    protected function allocateMeans($details) {
        $resources = $details['resources'] ?? [];
        $beneficiaries = $details['beneficiaries'] ?? [];

        echo "Allocating resources...\n";
        foreach ($beneficiaries as $beneficiary) {
            echo "Allocated resources to beneficiary: " . $beneficiary['name'] . " at " . $beneficiary['address'] . ".\n";
        }
    }

    // Execute the delivery
    protected function executeTravel($details) {
        $beneficiaries = $details['beneficiaries'] ?? [];

        echo "Executing delivery to beneficiaries...\n";
        foreach ($beneficiaries as $beneficiary) {
            echo "Delivering resources to " . $beneficiary['name'] . " at " . $beneficiary['address'] . ".\n";
        }
    }
}
