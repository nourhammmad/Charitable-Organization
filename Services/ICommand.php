<?php
interface ICommand {
    public function execute();
    public function undo();
}