<?php
require_once $_SERVER['DOCUMENT_ROOT']."./Services/IDonationState.php";
class CreateState implements IDonationState {
    public function canUndo(): bool {
        return true;  // Can undo if state is "CREATE"
    }
    
    public function canRedo(): bool {
        return true; // Cannot redo if state is "CREATE"
    }
}