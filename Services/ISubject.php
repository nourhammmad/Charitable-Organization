<?php

interface ISubject {
    public function addObserver($observer);
    public function notifyObservers($message);
}
