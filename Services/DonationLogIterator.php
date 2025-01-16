<?php 
 
require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationLog.php";

class DonationLogIterator implements Iterator {
    private $logs = [];
    private $position = 0;
    private $typeFilter = null;

    public function __construct(array $logs) {
        $this->logs = $logs;
        $this->position = 0;

    }

    // Iterator methods
    public function current():mixed {
        return $this->logs[$this->position];
    }

    public function key():mixed {
        return $this->position;
    }

    public function next():void{
        $this->position++;
        error_log("Advancing position to: " . $this->position);
    }
    

    public function rewind():void{
        $this->position = 0;
    }

    public function valid():bool{
        $isValid = $this->position < count($this->logs);
        error_log("Iterator valid(): " . ($isValid ? 'true' : 'false') . " at position: " . $this->position);
        return $isValid;
    }
    
    

    // Filter by donation type
    // Filter by donation type(s)
    public function filterByType($types) {
        $this->typeFilter = $types;
    
        // Debug: Log the types that are being filtered
        error_log("Filtering by types: " . print_r($this->typeFilter, true));
        
        // If no filter is provided (null), keep all logs, otherwise filter logs based on types
        if ($this->typeFilter === null) {
            // No filter applied, keep all logs
            $filteredLogs = $this->logs;
        } else {
            // Ensure $this->typeFilter is an array for proper comparison
            if (!is_array($this->typeFilter)) {
                $this->typeFilter = [$this->typeFilter]; // Convert single type to array if it's a single type
            }
    
            // Filter logs by the provided donation types
            $filteredLogs = array_filter($this->logs, function($log) {
                $logTypeId = $log->getLogtypeId(); // Get the donation type ID
                // Debug: Log the donation type ID for each log
                error_log("Checking log with donation_type_id: " . $logTypeId);
                return in_array($logTypeId, $this->typeFilter); // Check if the log's type matches the filter
            });
        }
    
        // Reset the keys of the filtered array to ensure proper iteration
        $this->logs = array_values($filteredLogs);
        error_log("Log After Filtering: " . print_r($this->logs, true));

        // Reset the iterator's position to the beginning after filtering
        $this->rewind();
    }
   
    
}