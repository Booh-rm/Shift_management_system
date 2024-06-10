window.onload = function () {
    $.post("../../../Backend/php/gets/getUserInfo.php", function (data) {
        var obj = JSON.parse(data);
        if (obj.type === 'success') {
            document.getElementById("userName").innerText = obj.user_name + ' ' + obj.user_lastname;
            document.getElementById("dependencia").innerText = " " + obj.dependencia;
        } else {
            console.error("Error: " + obj.message);
            // Redirige a la página de inicio de sesión si no está logeado
            window.location.href = "../../UI/users/users.html";
        }
    });
};

function loadDependenciaTurnos() {
    fetch('../../../Backend/php/gets/getShiftsA.php')
        .then(response => response.json())
        .then(data => {
            const verTurnoSpan = document.getElementById('turnoInfo');
            const shiftsTableBody = document.getElementById('shifts-table-body');
            // Limpiar cualquier contenido existente
            verTurnoSpan.innerHTML = '';

            if (data.length > 0) {
                const primerTurno = data[0];


                // Mostrar el primer turno en el encabezado
                document.getElementById('verTurno').textContent = primerTurno.id_turno;
                document.getElementById('verCaja').textContent = primerTurno.descripcion;

                // Crear el texto con la información del primer turno
                const turnoText = document.createTextNode(primerTurno.id_turno + ":\n " + "Atendiendo a usuario " + primerTurno.nombre_usuario + ", con numero de identificación: " + primerTurno.id_usuario);

                // Agregar el texto al elemento span
                verTurnoSpan.appendChild(turnoText);

                // Crear una fila en la tabla para mostrar el primer turno
                const primerTurnoRow = document.createElement('tr');
                const primerTurnoCell = document.createElement('td');
                const dependenciaCell = document.createElement('td');
                primerTurnoCell.textContent = primerTurno.id_turno;
                dependenciaCell.textContent = primerTurno.dependencia;
                dependenciaCell.colSpan = 2;

                primerTurnoRow.appendChild(primerTurnoCell);
                primerTurnoRow.appendChild(dependenciaCell);
                shiftsTableBody.appendChild(primerTurnoRow);

                // Mostrar los siguientes cuatro turnos en la tabla
                for (let i = 1; i < Math.min(data.length, 5); i++) {
                    const turno = data[i];
                    const row = document.createElement('tr');
                    const turnoCell = document.createElement('td');
                    turnoCell.textContent = turno.id_turno;
                    const dependenciaCell = document.createElement('td');
                    dependenciaCell.textContent = turno.dependencia;
                    dependenciaCell.colSpan = 2;

                    row.appendChild(turnoCell);
                    row.appendChild(dependenciaCell);
                    shiftsTableBody.appendChild(row);
                }
            } else {
                const noTurnoRow = document.createElement('tr');
                const noTurnoCell = document.createElement('td');
                noTurnoCell.textContent = 'No hay turnos disponibles para esta dependencia';
                noTurnoCell.colSpan = 3;
                noTurnoRow.appendChild(noTurnoCell);
                shiftsTableBody.appendChild(noTurnoRow);
            }
        })
        .catch(error => console.error('Error al cargar los turnos de la dependencia:', error));
}

// Cargar los turnos relacionados con la dependencia del funcionario
document.addEventListener('DOMContentLoaded', loadDependenciaTurnos);
