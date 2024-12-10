<?php 
class DeleteState implements IDonationState {
    public function canUndo(): bool {
        return false; // Cannot undo if state is "DELETE"
    }
    
    public function canRedo(): bool {
        return false;  // Can redo if state is "DELETE"
    }
}