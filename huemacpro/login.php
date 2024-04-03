<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "huemac";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT id_empleado, Nombre, Apellido_pat, Apellido_mat, contrasena, cargo FROM empleado WHERE nombreUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
       
        $row = $result->fetch_assoc();
        if ($contrasena == $row["contrasena"]) {
         

            $_SESSION['employee_id'] = $row['id_empleado'];

            
            $_SESSION['employee_name'] = $row['Nombre'] . ' ' . $row['Apellido_pat'] . ' ' . $row['Apellido_mat'];

       
            $_SESSION['employee_role'] = $row['cargo'];

           
            echo "ID del Empleado: " . $_SESSION['employee_id'] . "<br>";
            echo "Nombre del Empleado: " . $_SESSION['employee_name'] . "<br>";
            echo "Cargo del Empleado: " . $_SESSION['employee_role'] . "<br>";

        
            $cargo = $row["cargo"];
            if ($cargo == "jefe") {
                echo "Redirigiendo al Menú del Administrador...<br>";
                header("Location: menu-administrador.html");
                exit();
            } elseif ($cargo == "empleado") {
                echo "Redirigiendo al Menú del Empleado...<br>";
                header("Location: menu-empleado.html");
                exit();
            } else {
                echo "Inicio de sesión exitoso con un cargo no reconocido";
            }
        } else {
        
            echo "Inicio de sesión fallido. Contraseña incorrecta.";
        }
    } else {
     
        echo "Inicio de sesión fallido. Verifica tus credenciales.";
    }

    $stmt->close();
}

$conn->close();
?>