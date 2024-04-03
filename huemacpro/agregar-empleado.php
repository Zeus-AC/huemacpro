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
    $nombre = $_POST["nombre"];
    $apellidoPat = $_POST["apellidoPat"];
    $apellidoMat = $_POST["apellidoMat"];
    $cargo = $_POST["cargo"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); 

    // Consulta SQL para agregar un empleado
    $sql = "INSERT INTO Empleado (Nombre, Apellido_pat, Apellido_mat, cargo, nombreUsuario, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $apellidoPat, $apellidoMat, $cargo, $nombreUsuario, $contrasena);

    if ($stmt->execute()) {
        echo "Empleado agregado con éxito.";
    } else {
        echo "Error al agregar empleado: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
