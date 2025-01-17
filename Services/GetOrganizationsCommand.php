<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Services/ActionCommand.php";
require_once $_SERVER['DOCUMENT_ROOT']."/controllers/OrganizationController.php";

class GetOrganizationsCommand implements ActionCommand {
    public function execute() {
        $controller=new OrganizationController();
        $controller->handleGetOrganizations();
    }
}
?>
