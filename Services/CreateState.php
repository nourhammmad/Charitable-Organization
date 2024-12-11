<?php
require_once $_SERVER['DOCUMENT_ROOT']."\Services\IDonationState.php";
class CreateState implements IDonationState {
    public function canUndo(): bool {
        return true;  
    }
    
    public function canRedo(): bool {
        return true; 
    }
}