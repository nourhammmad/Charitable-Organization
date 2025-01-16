<?php 
class AddDonationCommand implements ICommand {
    private $donorId;
    private $donationType;
    private $donationData;

    public function __construct($donorId, $donationType, $donationData) {
        $this->donorId = $donorId;
        $this->donationType = $donationType;
        $this->donationData = $donationData;
    }

    public function execute() {
        try {
            // Create the appropriate donation strategy based on the type
            $donationStrategy = null;

            switch ($this->donationType) {
                case 'book':
                    $donationStrategy =  BooksDonationFactory::createDonation($this->donationType,$this->donorId,null, null, null, $_POST['quantity'], $_POST['bookTitle'], $_POST['author'], $_POST['publicationYear'],null, null, null );

                    break;

                case 'clothes':
                    $donationStrategy =  ClothesDonationFactory::createDonation($this->donationType,$this->donorId, $_POST['type'],$_POST['size'],$_POST['color'],$_POST['quantity'], null, null, null, null, null, null);

                    break;

                case 'money':
                    // Handling different types of payments (cash, visa, stripe)
                    if ($this->donationData['paymentType'] == 'cash') {
                        $donationStrategy = FeesDonationFactory::createDonation(
                            'cash', 
                            $this->donorId, 
                            null, null, null, null, 
                            null, null, null, 
                            $this->donationData['amount'],
                            $this->donationData['currency'], 
                            null
                        );
                    } elseif ($this->donationData['paymentType'] == 'visa') {
                        $donationStrategy = FeesDonationFactory::createDonation(
                            'visa',
                            $this->donorId,
                            null, null, null, null,
                            null, null, null,
                            $this->donationData['amount'],
                            $this->donationData['currency'],
                            $this->donationData['cardNumber']
                        );
                    } elseif ($this->donationData['paymentType'] == 'stripe') {
                        $donationStrategy = FeesDonationFactory::createDonation(
                            'stripe',
                            $this->donorId,
                            null, null, null, null,
                            null, null, null,
                            $this->donationData['amount'],
                            $this->donationData['currency'],
                            null
                        );
                    }
                    break;

                default:
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid donation type.'
                    ]);
                    return;
            }

            // Execute the donation strategy (save to DB, etc.)
            if ($donationStrategy ) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Donation successfully added.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to process donation.'
                ]);
            }

        } catch (Exception $e) {
            // Handle exceptions
            echo json_encode([
                'success' => false,
                'message' => 'An error occurred while adding the donation.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
