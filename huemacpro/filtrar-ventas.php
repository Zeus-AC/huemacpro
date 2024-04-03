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

// Obtener los parámetros del filtro
$mes = $_GET['mes'];
$empleado = $_GET['empleado'];

// Consulta para obtener las ventas filtradas
$sql = "SELECT V.*, DV.fecha_venta, B.codigo_Qr
        FROM Ventas V
        INNER JOIN Detalles_Venta DV ON V.id_detalles_venta = DV.id_detalles_venta
        INNER JOIN Brazalete B ON V.id_brazalete = B.id_brazalete
        WHERE DATE_FORMAT(DV.fecha_venta, '%Y-%m') = '$mes' AND DV.id_empleado = '$empleado'";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Crear un string para almacenar los resultados y el total
$resultados = "";
$totalVentas = 0;

// Verificar si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $resultados .= "Venta " . $row['id_ventas'] . ": $" . $row['subtotal'] . "<br>";
        $resultados .= "Fecha de Venta: " . $row['fecha_venta'] . "<br>";
        $resultados .= "Código QR: " . $row['codigo_Qr'] . "<br><br>";

        // Sumar al total de ventas
        $totalVentas += $row['subtotal'];
    }
    // Mostrar el total al final del historial
    $resultados .= "Total de Ventas: $" . $totalVentas;
} else {
    $resultados = "No hay ventas para el mes y empleado seleccionados.";
}

// Devolver los resultados
echo $resultados;

$conn->close();
?>
