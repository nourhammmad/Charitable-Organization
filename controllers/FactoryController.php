<!-- // ModalConfigController.php
  <?php
require_once  $_SERVER['DOCUMENT_ROOT']."\models\configFactory.php";
if (isset($_GET['type'])) {
    try {
        $type = $_GET['type'];
        // $config = ModalConfigFactory::getConfig($type);
        echo json_encode($config);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
