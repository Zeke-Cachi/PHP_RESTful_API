<?php 

class Middlewares {

  public static function checkNoEmpty($nombre, $apellido, $edad, $carrera) {
    if (empty($nombre) || empty($apellido) || $edad < 18 || empty($carrera)) {
      http_response_code(400);
      return ['success'=> false, 'message' => "All fields required"];
    }
    return ['success' => true];
  }
}



?>