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

$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$apellido_pat = mysqli_real_escape_string($conn, $_POST['apellido_pat']);
$apellido_mat = mysqli_real_escape_string($conn, $_POST['apellido_mat']);
$pulserasData = mysqli_real_escape_string($conn, $_POST['pulseras']);

$conn->begin_transaction();

try {
    // Insertar cliente
    $sql_insert_cliente = "INSERT INTO Cliente (Nombre, Apellido_pat, Apellido_mat) VALUES ('$nombre', '$apellido_pat', '$apellido_mat')";
    if ($conn->query($sql_insert_cliente) === TRUE) {
        $cliente_id = $conn->insert_id;

        // Obtener el ID del empleado desde la sesión
        $id_empleado = $_SESSION['employee_id'];

        // Insertar detalles de la venta
        $sql_detalles_venta = "INSERT INTO Detalles_Venta (fecha_venta, total_venta, id_cliente, id_empleado) VALUES (NOW(), 0, $cliente_id, $id_empleado)";
        if ($conn->query($sql_detalles_venta) === TRUE) {
            $detalles_venta_id = $conn->insert_id;

            $totalVenta = 0;

            $pulserasArray = explode(",", $pulserasData);

            foreach ($pulserasArray as $pulsera) {
                list($codigo_qr, $cantidad) = explode(":", $pulsera);

                // Verificar la pulsera
                $sql_verificar_pulsera = "SELECT id_brazalete, id_tipo_brazalete FROM Brazalete WHERE codigo_Qr = $codigo_qr AND estado = 'Disponible' LIMIT 1";
                $result_verificar_pulsera = $conn->query($sql_verificar_pulsera);

                if ($result_verificar_pulsera !== false && $result_verificar_pulsera->num_rows > 0) {
                    $row_pulsera = $result_verificar_pulsera->fetch_assoc();
                    $brazalete_id = $row_pulsera['id_brazalete'];
                    $tipo_brazalete_id = $row_pulsera['id_tipo_brazalete'];

                    // Obtener el precio del tipo de brazalete
                    $precio_unitario = obtenerPrecioTipoBrazalete($conn, $tipo_brazalete_id);

                    $subtotal = $precio_unitario * $cantidad;
                    $totalVenta += $subtotal;

                    // Actualizar la pulsera
                    $sql_actualizar_pulsera = "UPDATE Brazalete SET estado = 'Vendido', id_cliente = $cliente_id WHERE id_brazalete = $brazalete_id";
                    if ($conn->query($sql_actualizar_pulsera) === TRUE) {
                        // Actualizar el stock del tipo de brazalete
                        $sql_actualizar_stock = "UPDATE Tipo_Brazalete SET stock = stock - $cantidad WHERE id_tipo_brazalete = $tipo_brazalete_id";
                        if ($conn->query($sql_actualizar_stock) === FALSE) {
                            throw new Exception("Error al actualizar el stock del tipo de brazalete: " . $conn->error);
                        }

                        // Insertar datos en la tabla Ventas
                        $sql_insert_ventas = "INSERT INTO Ventas (cantidad, precio_unitario, subtotal, id_brazalete, id_detalles_venta) VALUES ($cantidad, $precio_unitario, $subtotal, $brazalete_id, $detalles_venta_id)";
                        if ($conn->query($sql_insert_ventas) === FALSE) {
                            throw new Exception("Error al insertar datos en la tabla Ventas: " . $conn->error);
                        }
                    } else {
                        throw new Exception("Error al actualizar el estado de la pulsera: " . $conn->error);
                    }
                } else {
                    throw new Exception("Error: No se puede realizar la venta. La pulsera no existe o ya ha sido vendida.");
                }
            }

            // Actualizar el total de la venta
            $sql_actualizar_total = "UPDATE Detalles_Venta SET total_venta = $totalVenta WHERE id_detalles_venta = $detalles_venta_id";
            $conn->query($sql_actualizar_total);

            // Confirmar la transacción
            $conn->commit();

            // Obtener el nombre del empleado para el mensaje de éxito
            $nombreEmpleado = obtenerNombreEmpleado($conn, $id_empleado);

            // Mostrar mensaje de éxito
            echo "Venta realizada con éxito por el empleado $nombreEmpleado para el cliente $nombre. Monto total a pagar: $totalVenta.";
        } else {
            throw new Exception("Error al registrar los detalles de la venta: " . $conn->error);
        }
    } else {
        throw new Exception("Error al insertar el cliente: " . $conn->error);
    }
} catch (Exception $e) {
    // En caso de error, realizar un rollback y mostrar el mensaje de error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conn->close();

function obtenerPrecioTipoBrazalete($conn, $tipo_brazalete_id) {
    $sql = "SELECT precio FROM Tipo_Brazalete WHERE id_tipo_brazalete = $tipo_brazalete_id";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['precio'];
    } else {
        return 0;
    }
}

function obtenerNombreEmpleado($conn, $id_empleado) {
    $sql = "SELECT nombre FROM Empleado WHERE id_empleado = $id_empleado";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nombre'];
    } else {
        return "Empleado Desconocido";
    }
}
?>
