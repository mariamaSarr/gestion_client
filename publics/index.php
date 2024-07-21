<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Client.php';
require_once __DIR__ . '/../app/controllers/ClientController.php';


$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;
$format = $_GET['format'] ?? null;

$controller = new ClientController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->destroy($id);
        break;
    case 'export':
        $controller->export($format);
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
?>
