<?php
// Carrega manualmente as classes necessárias
require_once __DIR__ . '/api/utils/Database.php';
require_once __DIR__ . '/api/utils/ResponseHandler.php';
require_once __DIR__ . '/api/models/User.php';
require_once __DIR__ . '/api/repositories/UserRepository.php';
require_once __DIR__ . '/api/services/UserService.php';
require_once __DIR__ . '/api/controllers/UserController.php';

error_reporting(E_ALL); 
ini_set('display_errors', 1);

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$method = $_SERVER['REQUEST_METHOD'];
$id = null;

if (isset($uri[1]) && $uri[1] === 'api') {
    array_shift($uri); 
}

if ($uri[1] !== 'users') {
    ResponseHandler::sendResponse(404, ['error' => 'Not found']);
    return;
}

if (isset($uri[2]) && is_numeric($uri[2])) {
    $id = intval($uri[2]);
}

$dbConnection = \Api\Utils\Database::getConnection();
$userService = new \Api\Services\UserService(new \Api\Repositories\UserRepository());
$userController = new \Api\Controllers\UserController($userService);

switch ($method) {
    case 'GET':
        // Chamada para o UserController
        $response = $id ? $userController->getUser($id) : $userController->getAllUsers();
        break;
    case 'POST':
        // Chamada para o UserController
        $response = $userController->createUser(file_get_contents('php://input'));
        break;
    case 'PUT':
        if ($id) {
            // Chamada para o UserController
            $response = $userController->updateUser($id, file_get_contents('php://input'));
        } else {
            ResponseHandler::sendResponse(400, ['error' => 'No ID provided']);
            return;
        }
        break;
    default:
        ResponseHandler::sendResponse(405, ['error' => 'Method Not Allowed']);
        return;
}

ResponseHandler::sendResponse($response['status'] ?? 200, $response['data'] ?? []);
