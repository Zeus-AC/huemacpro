<?php
// Configuración de la conexión a la base de datos

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "huemac";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener la lista de empleados
$sql = "SELECT id_empleado, nombre, apellido_pat, apellido_mat FROM Empleado";
$result = $conn->query($sql);

// Crear un array para almacenar los empleados
$empleados = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}

// Devolver la lista de empleados como JSON
echo json_encode($empleados);

$conn->close();
?>
