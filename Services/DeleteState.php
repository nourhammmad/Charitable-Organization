<?php 
class DeleteState implements IDonationState {
    public function canUndo(): bool {
        return false; 
    }
    
    public function canRedo(): bool {
        return false;
    }
}