<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "huemac";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEmpleado = $_POST["idEmpleado"];

    // Consulta SQL para eliminar un empleado por ID
    $sql = "DELETE FROM Empleado WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEmpleado);

    if ($stmt->execute()) {
        echo "Empleado eliminado con éxito.";
    } else {
        echo "Error al eliminar empleado: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
