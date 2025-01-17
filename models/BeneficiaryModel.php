<?php 
require_once $_SERVER['DOCUMENT_ROOT']."\Database.php";

class Beneficiary {

    private $name;
    private $beneficiaryType;
    private $address;
    public function __construct($name, $beneficiaryType,$address) {
        $this->beneficiaryType = $beneficiaryType;
        $this->name = $name;
        $this->address = $address;

    }

    public static function createBeneficiary($name,$address,$beneficiaryType) {
        
        $query = "INSERT INTO Beneficiary (name,address, beneficiaryType) 
                  VALUES ( '$name', '$address', '$beneficiaryType')";
        $stmt = Database::run_query($query);
        return $stmt;
    }


    public static function getBeneficiaries() {
        $query = "SELECT * FROM Beneficiary";
        $result = Database::run_select_query($query);
    
        if ($result === false) {
            return [];
        }
    
        $beneficiaries = [];
       
        while ($row = $result->fetch_assoc()) {
            $address = Beneficiary::getBeneficiaryAddress($row['address']);
            $beneficiaries[] = [
                'address' => $address,
                'name' => $row['name'],
                'beneficiaryType'=> $row['beneficiaryType']
            ];
        }
    
        return $beneficiaries;
    }



    public static function getBeneficiaryAddressID($fullAddress) {
        //return Beneficiary::$addressid;

        $addressParts = explode(", ", $fullAddress);
        if (count($addressParts) !== 2) {
            return null;
        }
    
        $street = $addressParts[0];
        $city = $addressParts[1];
    
        $query = "SELECT addressId FROM Address WHERE   street= '$street' AND city= '$city'";
        $result = Database::run_select_query($query);
    
        // Check if there is a result
        if ($result && $row = $result->fetch_assoc()) {
            // Return the concatenated address
            return $row['addressId'];
        }
    
        // If no result is found, return an empty string or handle as needed
        return '';
    }
    public static function getBeneficiaryAddress($addressID) {
        $query = "SELECT CONCAT(street, ', ', city) AS full_address FROM Address WHERE addressId = $addressID";
        $result = Database::run_select_query($query);
    
        // Check if there is a result
        if ($result && $row = $result->fetch_assoc()) {
            // Return the concatenated address
            return $row['full_address'];
        }
    
        // If no result is found, return an empty string or handle as needed
        return '';
    }
    

    // public static function updateBeneficiary($id, $data) {
    //     $query = "UPDATE Beneficiary SET 
    //                 name = :name, 
    //                 address = :address, 
    //                 beneficiaryType = :beneficiaryType 
    //               WHERE id = '$id'";
    //     $stmt = Database::run_query($query, array_merge($data, ['id' => $id]));
    //     return $stmt;
    // }

    // public function deleteBeneficiary($id) {
    //     $query = "DELETE FROM Beneficiary WHERE id = :id";
    //     $stmt = $this->db->prepare($query);
    //     return $stmt->execute(['id' => $id]);
    // }

    // public function updateBeneficiary($id, $data) {
    //     $query = "UPDATE Beneficiary SET 
    //                 name = :name, 
    //                 email = :email, 
    //                 phone = :phone, 
    //                 address = :address, 
    //                 beneficiaryType = :beneficiaryType, 
    //                 status = :status 
    //               WHERE id = :id";
    //     $stmt = $this->db->prepare($query);
    //     $data['id'] = $id;
    //     return $stmt->execute($data);
    // }

    // public function deleteBeneficiary($id) {
    //     $query = "DELETE FROM Beneficiary WHERE id = :id";
    //     $stmt = $this->db->prepare($query);
    //     return $stmt->execute(['id' => $id]);
    // }
}
