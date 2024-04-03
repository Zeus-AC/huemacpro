<?php
session_start();

// Creamos un array para almacenar la información del usuario
$userInfo = array();

// Verificamos si hay una sesión activa
if (isset($_SESSION['employee_name']) && isset($_SESSION['employee_role'])) {
    // Si hay una sesión activa, almacenamos la información en el array
    $userInfo['name'] = $_SESSION['employee_name'];
    $userInfo['role'] = $_SESSION['employee_role'];
} else {
    // Si no hay una sesión activa, establecemos valores predeterminados
    $userInfo['name'] = 'Usuario no autenticado';
    $userInfo['role'] = '';
}

// Convertimos el array a formato JSON y lo imprimimos
echo json_encode($userInfo);
?>
