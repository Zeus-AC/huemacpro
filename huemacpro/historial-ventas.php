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

// Consulta para obtener el historial de ventas detallado
$sql = "SELECT V.id_ventas, V.cantidad, V.precio_unitario, V.subtotal, DV.fecha_venta, B.codigo_Qr, E.nombre AS empleado, C.Nombre AS cliente
        FROM Ventas V
        INNER JOIN Detalles_Venta DV ON V.id_detalles_venta = DV.id_detalles_venta
        INNER JOIN Brazalete B ON V.id_brazalete = B.id_brazalete
        INNER JOIN Empleado E ON DV.id_empleado = E.id_empleado
        INNER JOIN Cliente C ON DV.id_cliente = C.id_cliente";

$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Crear una tabla para mostrar los resultados
echo "<table border='1'>
        <tr>
            <th>ID de Venta</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Fecha de Venta</th>
            <th>Código QR</th>
            <th>Empleado</th>
            <th>Cliente</th>
        </tr>";

// Mostrar los resultados en la tabla
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id_ventas ']}</td>
            <td>{$row['cantidad']}</td>
            <td>{$row['precio_unitario']}</td>
            <td>{$row['subtotal']}</td>
            <td>{$row['fecha_venta']}</td>
            <td>{$row['codigo_Qr']}</td>
            <td>{$row['empleado']}</td>
            <td>{$row['cliente']}</td>
        </tr>";
}

echo "</table>";

$conn->close();
?>
