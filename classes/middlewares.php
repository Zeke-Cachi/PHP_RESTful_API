<?php 

class Middlewares {

  public static function checkNoEmpty($nombre, $apellido, $edad, $carrera) {
    if (empty($nombre) || empty($apellido) || $edad < 18 || empty($carrera)) {
      http_response_code(400);
      return ['success'=> false, 'message' => "All fields required"];
    }
    return ['success' => true];
  }

  public static function checkInputType($nombre, $apellido, $edad, $carrera) {
    if (!is_string($nombre) || !is_string($apellido) || !is_numeric($edad) || !is_string($carrera)) {
      http_response_code(400);
      return ['success'=> false, 'message' => "edad must be a number, all other variables must be words"];
    }
    return ['success' => true];
  }
}



?>