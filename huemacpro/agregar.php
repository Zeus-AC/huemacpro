<?php
// Código de conexión a la base de datos aquí (no proporcionado en este ejemplo)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $codigo_Qr = $_POST["codigo_Qr"];
    $id_tipo_brazalete = $_POST["id_tipo_brazalete"];

    // Código de conexión a la base de datos (sustituir con tu propia implementación)
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "huemac";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Establecer el modo de error de PDO a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si ya existe un brazalete del mismo tipo con el mismo código QR
        $stmt_check = $conn->prepare("SELECT COUNT(*) FROM Brazalete WHERE codigo_Qr = :codigo_Qr AND id_tipo_brazalete = :id_tipo_brazalete");
        $stmt_check->bindParam(':codigo_Qr', $codigo_Qr);
        $stmt_check->bindParam(':id_tipo_brazalete', $id_tipo_brazalete);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            echo "Error: Ya existe un brazalete del mismo tipo con este código QR. Ingresa un código QR único o elige un tipo diferente.";
        } else {
            // Inserción en la tabla Brazalete
            $stmt_insert = $conn->prepare("INSERT INTO Brazalete (codigo_Qr, estado, id_tipo_brazalete) VALUES (:codigo_Qr, 'disponible', :id_tipo_brazalete)");
            $stmt_insert->bindParam(':codigo_Qr', $codigo_Qr);
            $stmt_insert->bindParam(':id_tipo_brazalete', $id_tipo_brazalete);
            $stmt_insert->execute();

            // Actualizar el stock en la tabla Tipo_Brazalete
            $stmt_stock = $conn->prepare("UPDATE Tipo_Brazalete SET stock = stock + 1 WHERE id_tipo_brazalete = :id_tipo_brazalete");
            $stmt_stock->bindParam(':id_tipo_brazalete', $id_tipo_brazalete);
            $stmt_stock->execute();

            echo "Brazalete agregado con éxito.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión a la base de datos
    $conn = null;
}
?>
