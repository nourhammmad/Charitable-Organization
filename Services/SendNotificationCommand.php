<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/Services/CommunicationFacade.php";

class SendNotificationCommand implements ActionCommand {
    public function execute() {
        $controller=new OrganizationController();
        $controller->SendNotification();
    }
}
?>
