document.addEventListener("DOMContentLoaded", function() {
    // Creamos una función para hacer la solicitud AJAX
    function getEmployeeInfo() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parseamos la respuesta JSON
                var employeeInfo = JSON.parse(xhr.responseText);

                // Mostramos la información en el footer
                var userRoleElement = document.getElementById('user-role');
                userRoleElement.innerHTML = '<p><i class="fas fa-user-circle"></i> Empleado: ' + employeeInfo.name + ' - ' + employeeInfo.role + '</p>';
            }
        };

        // Hacemos la solicitud GET al script PHP
        xhr.open('GET', 'get_user_info.php', true);
        xhr.send();
    }

    // Llamamos a la función para obtener la información del empleado
    getEmployeeInfo();
});
