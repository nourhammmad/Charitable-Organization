<?php
class UndoDonationCommand implements ICommand {
    private $donor;
    
    public function __construct($donor) {
        $this->donor = $donor;
    }

    public function execute() {
        // No need for execution in this case; we will call undo directly
        $this->undo();
    }

    public function undo() {
        // Implement the logic to undo the donation
        echo "Undoing donation action...";
        // Revert the donation state to DELETE in the Donation Log, for example
        $this->donor->setDonationState(new DeleteState());
    }

    public function redo() {
        // Implement the logic to redo the donation
        echo "Redoing donation action...";
        // Reapply the donation state to CREATE in the Donation Log, for example
        $this->donor->setDonationState(new CreateState());
    }
}
