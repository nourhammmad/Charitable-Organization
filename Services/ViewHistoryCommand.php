<?php require_once $_SERVER['DOCUMENT_ROOT']."/Services/DonationLogIterable.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/donarLogFile.php";
require_once $_SERVER['DOCUMENT_ROOT']."/models/DonationModel.php";

class ViewHistoryCommand implements ActionCommand {
    private $donorId;
    private $action;

    public function __construct($donorId, $action) {
        $this->donorId = $donorId;
        $this->action = $action;
    }

    public function Execute() {
        try {
            // Fetch donations
            $donations = donarLogFile::getLogsByUserId($this->donorId);

            if (empty($donations)) {
                throw new Exception("No donations found for donor ID: " . $this->donorId);
            }

            // Apply filtering based on action type
            $donationLogIterable = new DonationLogIterable($donations);
            $iterator = $donationLogIterable->getIterator();

            if ($this->action === 'view_history_clothes') {
                $iterator->filterByType(3); // Filter for clothes
            } elseif ($this->action === 'view_history_books') {
                $iterator->filterByType(2); // Filter for books
            } elseif ($this->action === 'view_history_money') {
                $iterator->filterByType(1); // Filter for money
            } else {
                $iterator->filterByType(null); // No filter, all donations
            }

            $donationArray = [];
            foreach ($iterator as $donation) {
                $donationItemId = $donation->getLogitemId();
                $description = '';

                if ($donationItemId) {
                    $description = DonationModel::getDescriptionByitemId($donationItemId);
                }

                $donationArray[] = array_merge($donation->toArray(), ['description' => $description]);
            }

            // Clean output buffer and return JSON response
            ob_clean();  // Clean any previous output buffer
            $jsonResponse = json_encode(['success' => true, 'donations' => $donationArray]);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("JSON encoding error: " . json_last_error_msg());
                echo json_encode(['success' => false, 'message' => 'Error encoding JSON']);
            } else {
                echo $jsonResponse;
            }
            exit; // Prevent further output

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error fetching donations.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
