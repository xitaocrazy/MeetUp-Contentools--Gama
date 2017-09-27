<?php 
/*
CREATE TABLE RESPOSTAS (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
	email VARCHAR(50)  NOT NULL,
	nota INT NOT NULL,
	creation_time DATETIME DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE RESPOSTAS (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nota INT NOT NULL,
	creation_time DATETIME DEFAULT CURRENT_TIMESTAMP
)
*/
header('Content-Type: application/json charset=utf-8');

if(!isset($_POST['nota']) || !is_numeric($_POST['nota']))
	die( json_encode(array('parametro'=>false)) );

$nota = $_POST['nota'];

//var_dump($nota);

$servername = "localhost:1234";
$username = "admin";
$password = "admin";
$database = "admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
	die (json_encode(array('conecton'=>false)) );
}


/* Prepared statement, stage 1: prepare */
if (!($stmt = $conn->prepare("INSERT INTO RESPOSTAS (nota) VALUES (?)"))) {
	//die ("Prepare failed: (" . $conn->errno . ") " . $conn->error);
	die (json_encode(array('prepare'=>false)) );
}
mysqli_stmt_bind_param($stmt, 'i', $nota);

/* execute prepared statement */
echo json_encode(array( 'result' => mysqli_stmt_execute($stmt) ));

/* close statement and connection */
mysqli_stmt_close($stmt);
mysqli_close($conn);