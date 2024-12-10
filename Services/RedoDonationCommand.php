<?php
class RedoDonationCommand implements ICommand {
    private $donor;

    public function __construct($donor) {
        $this->donor = $donor;
    }

    public function execute() {
        $this->redo();
    }

    public function undo() {
        // Not needed for RedoCommand
    }

    public function redo() {
        // Redo the donation action
        echo "Redoing donation action...";
        $this->donor->setDonationState(new CreateState());
    }
}