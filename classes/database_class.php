<?php 

class Database {
  private $pdo;

  public function __construct() {
    $config = require '../config.php';

    $host = $config['host'];
    $username = $config['username'];
    $password = $config['password'];
    $database = $config['database'];


    try{
      $this->pdo = new PDO("mysql:host=$host; dbname=$database", $username, $password);
      $this->pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
    } catch (PDOException $error){
      die("Connection failed: " . $error->getMessage());
    } 
  }

//----------------------------------------------------------------------------------------------------------------------------------------------------
  public function getPdo() {
    return $this->pdo;
  }

//----------------------------------------------------------------------------------------------------------------------------------------------------
  public function getAll() {
    $query = 'SELECT * FROM alumnos_data';
    try {
      $statement = $this->pdo->prepare($query);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
      die('Query execution failed' . $error->getMessage());
    }
  }

//----------------------------------------------------------------------------------------------------------------------------------------------------
  public function createStudent($nombre, $apellido, $edad, $carrera) {
    $query = 'INSERT INTO alumnos_data (nombre, apellido, edad, carrera) VALUES (?, ?, ?, ?);';
    try {
      $statement = $this->pdo->prepare($query);
      $statement->bindParam(1, $nombre, PDO::PARAM_STR);
      $statement->bindParam(2, $apellido, PDO::PARAM_STR);
      $statement->bindParam(3, $edad, PDO::PARAM_INT);
      $statement->bindParam(4, $carrera, PDO::PARAM_STR);
      $statement->execute();
    } catch (PDOException $error) {
      die('error in creating student: '. $error->getMessage());
    }
  }

//----------------------------------------------------------------------------------------------------------------------------------------------------
  public function editStudent($id, $nombre, $apellido, $edad, $carrera) {
    $query = 'UPDATE alumnos_data SET nombre = ?, apellido = ?, edad = ?, carrera = ? WHERE id = ?';
    try {
      $statement = $this->pdo->prepare($query);
      $statement->bindParam(1, $nombre, PDO::PARAM_STR);
      $statement->bindParam(2, $apellido, PDO::PARAM_STR);
      $statement->bindParam(3, $edad, PDO::PARAM_INT);
      $statement->bindParam(4, $carrera, PDO::PARAM_STR);
      $statement->bindParam(5, $id, PDO::PARAM_INT);
      $statement->execute();
    } catch (PDOException $error) {
      die('error in editing student: '. $error->getMessage());
    }
  }

//----------------------------------------------------------------------------------------------------------------------------------------------------
  public function deleteStudent($id) {
    $query = 'DELETE FROM alumnos_data WHERE id = ?';
    try {
      $statement = $this->pdo->prepare($query);
      $statement->bindParam(1, $id, PDO::PARAM_INT);
      $statement->execute();
    } catch (PDOException $error) {
      die('error in deleting student: '. $error->getMessage());
    }
  }
}
?>