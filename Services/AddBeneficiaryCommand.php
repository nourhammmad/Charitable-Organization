<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/models/BeneficiaryModel.php";

class AddBeneficiaryCommand {
    public function execute($request) {
        $name = $request['name'] ?? null;
        $address = $request['address'] ?? null;
        $beneficiaryType = $request['beneficiaryType'] ?? null;

        if (!$name || !$address || !$beneficiaryType) {
            echo "Missing required fields: name, address, and beneficiary type are mandatory.";
            return;
        }

        $res = Beneficiary::createBeneficiary($name, $address, $beneficiaryType);
        
        if ($res) {
            echo "Beneficiary created successfully!";
        } else {
            echo "Error creating beneficiary.";
        }
    }
}
