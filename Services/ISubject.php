<?php
// ISubject.php
interface ISubject {
    public function addObserver(Volunteer $observer);
    public function removeObserver(Volunteer $observer);
    public function notifyObservers($message,Volunteer $volunteer);
}
