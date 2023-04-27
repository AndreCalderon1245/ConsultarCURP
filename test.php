<?php
include("bd.php");

if (isset($_GET["searchCURP"])) {
    $curp = $_GET["curp"];

    $query = "SELECT tbl_curp.curp, tbl_person.name, tbl_person.surname, tbl_person.second_surname, tbl_person.birthday, tbl_person.gender, tbl_person.state 
              FROM tbl_curp 
              INNER JOIN tbl_person ON tbl_curp.id_person = tbl_person.id
              WHERE tbl_curp.curp = '$curp'";

    $result = $conexion->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET["searchDP"])) {
    $name = $_GET["name"];
    $surname = $_GET["surname"];
    $second_surname = $_GET["second_surname"];
    $birthday = $_GET["ano"] . "-" . $_GET["month"] . "-" . $_GET["day"];
    $gender = $_GET["gender"];
    $state = $_GET["state"];

    $query = "SELECT * FROM tbl_curp INNER JOIN tbl_person ON tbl_curp.id_person = tbl_person.id WHERE tbl_person.name = '$name' AND tbl_person.surname = '$surname' AND tbl_person.second_surname = '$second_surname' AND tbl_person.birthday = '$birthday' AND tbl_person.gender = '$gender' AND tbl_person.state = '$state'";


    $result = $conexion->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //print_r($_POST);
    // Recolectamos los datos del método POST
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
    $second_surname = isset($_POST["second_surname"]) ? $_POST["second_surname"] : "";
    $dia = isset($_POST["day"]) ? $_POST["day"] : "";
    $mes = isset($_POST["month"]) ? $_POST["month"] : "";
    $ano = isset($_POST["ano"]) ? $_POST["ano"] : "";     
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $state = isset($_POST["state"]) ? $_POST["state"] : "";

    // Concatenamos el valor de dia, mes y año en el formato requerido
    $birthday = isset($_POST["ano"]) && isset($_POST["month"]) && isset($_POST["day"]) ? $_POST["ano"] . "-" . $_POST["month"] . "-" . $_POST["day"] : "";

    // Prepara la insercción de los datos
    $sentencia = $conexion->prepare("INSERT INTO tbl_person(id,name,surname,second_surname,birthday,gender,state) VALUES (null,:name,:surname,:second_surname,:birthday,:gender,:state)");

    // Asignando los valores que vienen del método POST
    $sentencia->bindParam(":name", $name);
    $sentencia->bindParam(":surname", $surname);
    $sentencia->bindParam(":second_surname", $second_surname);
    $sentencia->bindParam(":birthday", $birthday);
    $sentencia->bindParam(":gender", $gender);
    $sentencia->bindParam(":state", $state);
    $sentencia->execute();

    // Obtener el ID de la persona insertada
    $id_persona = $conexion->lastInsertId();

    // Preparar la inserción del CURP
    $sentencia = $conexion->prepare("INSERT INTO tbl_curp(id,curp,id_person) VALUES (null,:curp,:id_person)");

    // Asignar los valores a insertar en la tabla tbl_curp
    $sentencia->bindParam(":id_person", $id_persona);
    $sentencia->bindParam(":curp", $curp);
    $sentencia->execute();
}
?>

<?php include("templates/header.php"); ?>

<br>
<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#curp">CURP</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#datos-personales">Datos Personales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#crear-curp">Crear CURP</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active border-top-0 border p-4" id="curp">
            <form method="GET" action="">
                <h4 class="mb-3">Clave Única de Registro de Población (CURP)*:</h4>
                <div class="mb-3">
                    <input name="curp" type="text" class="form-control" id="input-curp">
                </div>
                <a href="#" onclick="mostrarPanel()">¿No conoces tu CURP?</a>
                <button name="searchCURP" class="btn btn-primary float-end">Buscar</button>
            </form>

            <?php if (isset($row) && isset($_GET["searchCURP"])) : ?>
                <h5 class="mt-4">Información encontrada:</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>CURP:</strong>
                            <?= $row["curp"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong>
                            <?= $row["name"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Apellido paterno:</strong>
                            <?= $row["surname"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Apellido materno:</strong>
                            <?= $row["second_surname"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Fecha de nacimiento:</strong>
                            <?= $row["birthday"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Género:</strong>
                            <?= $row["gender"] ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong>
                            <?= $row["state"] ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade border-top-0 border p-4" id="datos-personales">
            <form>
                <h4 class="mb-3">Datos Personales</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="input-nombre" class="form-label">Nombre*</label>
                        <input name="name" type="text" class="form-control" id="input-nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-primer-apellido" class="form-label">Primer Apellido*</label>
                        <input name="surname" type="text" class="form-control" id="input-primer-apellido" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-segundo-apellido" class="form-label">Segundo Apellido*</label>
                        <input name="second_surname" type="text" class="form-control" id="input-segundo-apellido" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-dia-nacimiento-dp" class="form-label">Día de Nacimiento*</label>
                        <select name="day" class="form-control" id="input-dia-nacimiento-dp" required>
                            <option value="">Seleccionar día</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="input-mes-nacimiento-dp" class="form-label">Mes de Nacimiento*</label>
                        <select name="month" class="form-control" id="input-mes-nacimiento-dp" required>
                            <option value="">Seleccionar mes</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-ano-nacimiento-dp" class="form-label">Año de Nacimiento*</label>
                        <select name="ano" class="form-control" id="input-ano-nacimiento-dp" required>
                            <option value="">Seleccionar año</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-sexo" class="form-label">Sexo*</label>
                        <select name="gender" class="form-select" id="input-sexo" required>
                            <option value="">Seleccione</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-estado" class="form-label">Estado*</label>
                        <select name="state" class="form-select mb-3" id="input-estado" required>
                            <option value="">Seleccione</option>
                            <option value="Aguascalientes">Aguascalientes</option>
                            <option value="Baja California">Baja California</option>
                            <option value="Baja California Sur">Baja California Sur</option>
                            <option value="Campeche">Campeche</option>
                            <option value="Coahuila">Coahuila</option>
                            <option value="Colima">Colima</option>
                            <option value="Chiapas">Chiapas</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Ciudad de México">Ciudad de México</option>
                            <option value="Durango">Durango</option>
                            <option value="Guanajuato">Guanajuato</option>
                            <option value="Guerrero">Guerrero</option>
                            <option value="Hidalgo">Hidalgo</option>
                            <option value="Jalisco">Jalisco</option>
                            <option value="Estado de México">Estado de México</option>
                            <option value="Michoacán">Michoacán</option>
                            <option value="Morelos">Morelos</option>
                            <option value="Nayarit">Nayarit</option>
                            <option value="Nuevo León">Nuevo León</option>
                            <option value="Oaxaca">Oaxaca</option>
                            <option value="Puebla">Puebla</option>
                            <option value="Querétaro">Querétaro</option>
                            <option value="Quintana Roo">Quintana Roo</option>
                            <option value="San Luis Potosí">San Luis Potosí</option>
                            <option value="Sinaloa">Sinaloa</option>
                            <option value="Sonora">Sonora</option>
                            <option value="Tabasco">Tabasco</option>
                            <option value="Tamaulipas">Tamaulipas</option>
                            <option value="Tlaxcala">Tlaxcala</option>
                            <option value="Veracruz">Veracruz</option>
                            <option value="Yucatán">Yucatán</option>
                            <option value="Zacatecas">Zacatecas</option>
                        </select>
                        <button name="searchDP" class="btn btn-primary float-end">Buscar</button>
                    </div>
                </div>
            </form>
            <?php if (isset($row) && isset($_GET["searchDP"])) : ?>
                <h5>Información encontrada:</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>CURP:</strong>
                            <?= $row["curp"] ?>
                        </p>
                    </div>
                <?php endif; ?>
                </div>
        </div>


        <div class="tab-pane fade border-top-0 border p-4" id="crear-curp">
            <form method="POST" action="test.php">
                <h4 class="mb-3">Datos Personales</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="input-nombre" class="form-label">Nombre*</label>
                        <input name="name" type="text" class="form-control" id="name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-primer-apellido" class="form-label">Primer Apellido*</label>
                        <input name="surname" type="text" class="form-control" id="surname" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-segundo-apellido" class="form-label">Segundo Apellido*</label>
                        <input name="second_surname" type="text" class="form-control" id="second_surname" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-dia-nacimiento-curp" class="form-label">Día de Nacimiento*</label>
                        <select name="day" class="form-control" id="input-dia-nacimiento-curp" required>
                            <option value="">Seleccionar día</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-mes-nacimiento-curp" class="form-label">Mes de Nacimiento*</label>
                        <select name="month" class="form-control" id="input-mes-nacimiento-curp" required>
                            <option value="">Seleccionar mes</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-ano-nacimiento-curp" class="form-label">Año de Nacimiento*</label>
                        <select name="ano" class="form-control" id="input-ano-nacimiento-curp" required>
                            <option value="">Seleccionar año</option>
                            <!-- Opciones generadas dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-sexo" class="form-label">Sexo*</label>
                        <select name="gender" class="form-select" id="gender" required>
                            <option value="">Seleccione</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-estado" class="form-label">Estado*</label>
                        <select name="state" class="form-select mb-3" id="state" required>
                            <option value="">Seleccione</option>
                            <option value="Aguascalientes">Aguascalientes</option>
                            <option value="Baja California">Baja California</option>
                            <option value="Baja California Sur">Baja California Sur</option>
                            <option value="Campeche">Campeche</option>
                            <option value="Coahuila">Coahuila</option>
                            <option value="Colima">Colima</option>
                            <option value="Chiapas">Chiapas</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Ciudad de México">Ciudad de México</option>
                            <option value="Durango">Durango</option>
                            <option value="Guanajuato">Guanajuato</option>
                            <option value="Guerrero">Guerrero</option>
                            <option value="Hidalgo">Hidalgo</option>
                            <option value="Jalisco">Jalisco</option>
                            <option value="Estado de México">Estado de México</option>
                            <option value="Michoacán">Michoacán</option>
                            <option value="Morelos">Morelos</option>
                            <option value="Nayarit">Nayarit</option>
                            <option value="Nuevo León">Nuevo León</option>
                            <option value="Oaxaca">Oaxaca</option>
                            <option value="Puebla">Puebla</option>
                            <option value="Querétaro">Querétaro</option>
                            <option value="Quintana Roo">Quintana Roo</option>
                            <option value="San Luis Potosí">San Luis Potosí</option>
                            <option value="Sinaloa">Sinaloa</option>
                            <option value="Sonora">Sonora</option>
                            <option value="Tabasco">Tabasco</option>
                            <option value="Tamaulipas">Tamaulipas</option>
                            <option value="Tlaxcala">Tlaxcala</option>
                            <option value="Veracruz">Veracruz</option>
                            <option value="Yucatán">Yucatán</option>
                            <option value="Zacatecas">Zacatecas</option>
                        </select>
                        <button onclick="generarCURP()" name="createCURP" class="btn btn-primary float-end">Generar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generarCURP() {
            // Obtener los valores de los campos del formulario
            const nombre = document.querySelector('#name').value.toUpperCase();
            const apellidoPaterno = document.querySelector('#surname').value.toUpperCase();
            const apellidoMaterno = document.querySelector('#second_surname').value.toUpperCase();
            const diaNacimiento = document.querySelector('#input-dia-nacimiento-curp').value;
            const mesNacimiento = document.querySelector('#input-mes-nacimiento-curp').value;
            const anoNacimiento = document.querySelector('#input-ano-nacimiento-curp').value.substring(2);
            const sexo = document.querySelector('#gender').value.charAt(0);
            const estado = document.querySelector('#state').value.substring(0, 2).toUpperCase();

            // Generar el CURP
            const curp =
                apellidoPaterno.substring(0, 2) +
                apellidoMaterno.charAt(0) +
                nombre.charAt(0) +
                anoNacimiento +
                mesNacimiento +
                diaNacimiento +
                sexo +
                estado +
                calcularHomoclave(apellidoPaterno, apellidoMaterno, nombre, anoNacimiento, mesNacimiento, diaNacimiento, sexo, estado);

            // Mostrar el CURP generado
            alert(`El CURP generado es: ${curp}`);
        }

        // Función para calcular la homoclave del CURP
        function calcularHomoclave(apellidoPaterno, apellidoMaterno, nombre, anoNacimiento, mesNacimiento, diaNacimiento, sexo, estado) {
            // Concatenar los datos personales y la fecha de nacimiento
            const datos = apellidoPaterno + apellidoMaterno + nombre + anoNacimiento + mesNacimiento + diaNacimiento + sexo + estado;
            let suma = 0;

            // Recorrer los caracteres de la cadena y sumar los valores de acuerdo a la tabla de valores
            for (let i = 0; i < datos.length; i++) {
                let valor = 0;
                const letra = datos.charAt(i);
                if (letra.match(/[A-Z]/)) {
                    valor = letra.charCodeAt(0) - 55;
                } else {
                    valor = parseInt(letra);
                }
                suma += valor * (18 - i);
            }

            // Calcular el residuo de la división entre la suma y 10
            const residuo = suma % 10;

            // Retornar la homoclave de acuerdo al residuo calculado
            if (residuo === 0) {
                return "0";
            } else {
                return (10 - residuo).toString();
            }
        }
    </script>

    <script>
        // Obtener el elemento select por su ID
        var selectDiaDP = document.getElementById("input-dia-nacimiento-dp");
        var selectDiaCURP = document.getElementById("input-dia-nacimiento-curp");

        // Generar las opciones del campo de selección de día con un bucle for
        for (var i = 1; i <= 31; i++) {
            var optionDP = document.createElement("option");
            var optionCURP = document.createElement("option");
            optionDP.value = (i < 10) ? "0" + i : i;;
            optionCURP.value = (i < 10) ? "0" + i : i;;

            // Si el número es menor a 10, se agrega un 0 a la izquierda; de lo contrario, se mantiene igual
            optionDP.text = (i < 10) ? "0" + i : i;
            optionCURP.text = (i < 10) ? "0" + i : i;

            selectDiaDP.appendChild(optionDP);
            selectDiaCURP.appendChild(optionCURP);
        }

        // Obtener el elemento select por su ID
        var selectMesDP = document.getElementById("input-mes-nacimiento-dp");
        var selectMesCURP = document.getElementById("input-mes-nacimiento-curp");

        // Generar las opciones del campo de selección de día con un bucle for
        for (var i = 1; i <= 12; i++) {
            var optionDP = document.createElement("option");
            var optionCURP = document.createElement("option");
            optionDP.value = (i < 10) ? "0" + i : i;;
            optionCURP.value = (i < 10) ? "0" + i : i;;

            // Si el número es menor a 10, se agrega un 0 a la izquierda; de lo contrario, se mantiene igual
            optionDP.text = (i < 10) ? "0" + i : i;
            optionCURP.text = (i < 10) ? "0" + i : i;

            selectMesDP.appendChild(optionDP);
            selectMesCURP.appendChild(optionCURP);
        }


        // Obtener el elemento select por su ID
        var selectAnoDP = document.getElementById("input-ano-nacimiento-dp");
        var selectAnoCURP = document.getElementById("input-ano-nacimiento-curp");

        // Generar las opciones del campo de selección de día con un bucle for
        for (var i = 1940; i <= 2023; i++) {
            var optionDP = document.createElement("option");
            var optionCURP = document.createElement("option");
            optionDP.value = i;
            optionDP.text = i;
            optionCURP.value = i;
            optionCURP.text = i;
            selectAnoDP.appendChild(optionDP);
            selectAnoCURP.appendChild(optionCURP);
        }
    </script>

    <script>
        function mostrarPanel() {
            const link = document.querySelector("a[data-bs-toggle='tab'][href='#datos-personales']");
            link.click();
            panel.classList.add("active");
        }
    </script>
    <?php include("templates/footer.php"); ?>