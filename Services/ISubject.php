<?php
// ISubject.php
interface ISubject {
    public function addObserver($observer);
    // public function removeObserver(Volunteer $observer);
    public function notifyObservers($message);
}
