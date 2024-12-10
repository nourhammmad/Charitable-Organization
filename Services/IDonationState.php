<?php
interface IDonationState {
    public function canUndo(): bool;
    public function canRedo(): bool;
}