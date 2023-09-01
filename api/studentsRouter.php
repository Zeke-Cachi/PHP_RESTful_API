<?php 

require_once __DIR__ .'../classes/database_class.php';
require_once __DIR__ .'../classes/middlewares.php';

$db = new Database();
$pdo = $db->getPdo();

header("Content-Type: application/json");
switch($_SERVER['REQUEST_METHOD']) {

//------------------------------------------------------------------------------------------------------------------ 
  case 'GET':
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $userById = $db->getById($id);
      echo json_encode($userById);
    } else {
      $users = $db->getAll();
      echo json_encode($users);
    }
    break;


//------------------------------------------------------------------------------------------------------------------  
  case 'POST':
    $_POST = json_decode(file_get_contents('php://input'), true);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $carrera = $_POST['carrera'];

    $validateEmpty = Middlewares::checkNoEmpty($nombre, $apellido, $edad, $carrera);
    $validateType = Middlewares::checkInputType($nombre, $apellido, $edad, $carrera);

    $allowedCarreras = ["Ingeniería", "Medicina", "Arquitectura"];

    if (!$validateEmpty['success']) {
      echo $validateEmpty['message'];
      exit;
    }
    if (!$validateType['success']) {
      echo $validateType['message'];
      exit;
    }
    if (in_array($carrera, $allowedCarreras)) {
        $db->createStudent($nombre, $apellido, $edad, $carrera);
        http_response_code(201);
        $response = ['message' => 'Student created successfully'];
        echo json_encode($response);
    } else {
        http_response_code(400);
        $response = ['message' => 'Invalid carrera value'];
        echo json_encode($response);
    }
    break;

//------------------------------------------------------------------------------------------------------------------ 
  case 'PUT':
    $_PUT = json_decode(file_get_contents('php://input'), true);
    $id = $_PUT['id'];
    $nombre = $_PUT['nombre'];
    $apellido = $_PUT['apellido'];
    $edad = $_PUT['edad'];
    $carrera = $_PUT['carrera'];
    $allowedCarreras = ["Ingeniería", "Medicina", "Arquitectura"];

    $validationResult = Middlewares::checkNoEmpty($nombre, $apellido, $edad, $carrera);
    
    if (in_array($carrera, $allowedCarreras) && $validationResult['success']) {
      $db->editStudent($id, $nombre, $apellido, $edad, $carrera);
      http_response_code(201);
      $response = ['message' => 'Student edited successfully'];
        echo json_encode($response);
    } else {
      http_response_code(400);
      $response = ['message' => 'Invalid values'];
      echo json_encode($response);
    }
    break;


//------------------------------------------------------------------------------------------------------------------ 
  case 'DELETE':
    $id = $_GET['id'];
    try {
      $db->deleteStudent($id);
      http_response_code(200);
      $response = ['message' => 'Student deleted successfully'];
        echo json_encode($response);
    } catch (PDOException $error) {
      http_response_code(400);
      $response = ['message' => 'Invalid carrera value'];
      echo json_encode($response);
    }
    

    break;
}

?>