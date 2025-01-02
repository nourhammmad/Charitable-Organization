<?php
interface IObserver {
    public function update($eventId, $message);
}
