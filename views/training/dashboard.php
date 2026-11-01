<?php
// Training Provider Course Management Dashboard Shell
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../controllers/ProviderController.php';

$providerCtrl = new ProviderController();
$providerCtrl->manageCourse();
