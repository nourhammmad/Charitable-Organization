<?php

class StripeAPI {
    public function charge($amount, $currency, $cardNumber) {
        // Simulating a successful charge via Stripe API
        
        
        return true;
    }

    public function getTransactionDetails() {
        // Simulating getting transaction details
        return "Stripe Transaction: Amount charged successfully!";
    }
}