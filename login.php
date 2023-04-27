<?php
// Conectarse a la base de datos
$servidor = "localhost:3307"; //127.0.0.1
$baseDeDatos = "curp";
$usuario = "root";
$contrasenia = "";
$conn = new mysqli($servidor, $usuario, $contrasenia, $baseDeDatos);

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos del formulario
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Consultar la base de datos
  $sql = "SELECT * FROM tbl_users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  // Verificar si se encontró un usuario con ese nombre de usuario y contraseña
  if ($result->num_rows > 0) {
    // Iniciar sesión y redirigir al usuario a la página principal
    session_start();
    $_SESSION["username"] = $username;
    header("Location: test.php");
    exit();
  } else {
    // Mostrar un mensaje de error si no se encontró el usuario
    echo "Nombre de usuario o contraseña incorrectos.";
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title text-center">Iniciar sesión</h3>
            <form method="POST" action="login.php">
              <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
