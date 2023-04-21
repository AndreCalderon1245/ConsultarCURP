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

            <?php if (isset($row) && isset($_GET["searchCURP"])): ?>
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
                        <input name="second_surname" type="text" class="form-control" id="input-segundo-apellido"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-dia-nacimiento" class="form-label">Día de Nacimiento*</label>
                        <input name="day" type="number" class="form-control" id="input-dia-nacimiento" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-mes-nacimiento" class="form-label">Mes de Nacimiento*</label>
                        <input name="month" type="number" class="form-control" id="input-mes-nacimiento" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-ano-nacimiento" class="form-label">Año de Nacimiento*</label>
                        <input name="ano" type="number" class="form-control" id="input-ano-nacimiento" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="input-sexo" class="form-label">Sexo*</label>
                        <select name="gender" class="form-select" id="input-sexo" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
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
            </form>
            <?php if (isset($row) && isset($_GET["searchDP"])): ?>
                <h5>Información encontrada:</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>CURP:</strong>
                            <?= $row["curp"] ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <script>
                function mostrarPanel() {
                    const link = document.querySelector("a[data-bs-toggle='tab'][href='#datos-personales']");
                    link.click();
                    panel.classList.add("active");
                }
            </script>

            <?php include("templates/footer.php"); ?>