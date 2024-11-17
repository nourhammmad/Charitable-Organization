<?php

interface Notifier {
    
     
      string $recipient ;
      string $message ;
    
    public function send(string $recipient, string $message): void;
}
