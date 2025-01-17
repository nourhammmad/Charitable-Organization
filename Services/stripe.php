<?php

class StripeAPI {
        private $apiKey;
        private $baseUrl;
    
        public function __construct($apiKey) {
            $this->apiKey = $apiKey;
            $this->baseUrl = "https://api.stripe.com/v1/";
        }
        
        public function getApikey(){
            return $this->apiKey;
        }
    
        public function charge($amount, $currency,$source) {
            $url = $this->baseUrl . "charges";
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                "amount" => $amount,
                "currency" => $currency, 
                "source" => $source, 
            
            ]));

            // Add the API key to the request headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $this->apiKey
            ]);

    
            // Execute the request
            $response = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
            curl_close($ch);
    
            // Handle the response
            if ($httpStatus === 200) {
                return true; 
            } else {
                $error = json_decode($response, true);
                throw new Exception("Stripe Charge Error: " . $error['error']['message']);
            }
        }

    
        public function getTransactionDetails() {

            return "Stripe Transaction: $this->apiKey charged successfully!";
        }
}