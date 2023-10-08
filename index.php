<!DOCTYPE html>
<html>
<head>
    <title>Buscar Medicamento</title>
</head>
<body>
    <h2>Buscar Medicamento</h2>
    <form method="post" action="">
        <label for="nombre">Nombre del Medicamento:</label>
        <input type="text" name="nombre" required>
        <br><br>
        <label for="sucursal">Sucursal:</label>
        <input type="text" name="sucursal" required>
        <br><br>
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <?php
    // Cargar el arreglo de medicamentos desde el archivo JSON "data.json"
    $jsonContent = file_get_contents('data.json');
    $medicamentos = json_decode($jsonContent, true);

    if (isset($_POST['buscar'])) {
        $nombreMedicamento = $_POST['nombre'];
        $sucursalBusqueda = $_POST['sucursal'];

        // Encuentra el medicamento en el arreglo de medicamentos
        $medicamentoEncontrado = null;
        foreach ($medicamentos as $medicamento) {
            if ($medicamento['nombre'] === $nombreMedicamento) {
                $medicamentoEncontrado = $medicamento;
                break;
            }
        }

        // Verifica si se encontró el medicamento
        if ($medicamentoEncontrado !== null) {
            $stock = $medicamentoEncontrado['cantidadStock'];
            $precio = $medicamentoEncontrado['precio'];

            // Determina el mensaje según las reglas utilizando if-else
            if ($medicamentoEncontrado['sucursal'] === $sucursalBusqueda && $stock >= 10) {
                $mensaje = "El medicamento $nombreMedicamento está disponible en $sucursalBusqueda. Precio: $$precio. Hay $stock unidades en stock.";
            } elseif ($medicamentoEncontrado['sucursal'] === $sucursalBusqueda && $stock < 10) {
                $mensaje = "El medicamento $nombreMedicamento está disponible en $sucursalBusqueda. ¡Últimas unidades disponibles! Precio: $$precio. Hay $stock unidades en stock.";
            } else {
                $mensaje = "El medicamento $nombreMedicamento no está disponible en $sucursalBusqueda.";
            }

            // Muestra el mensaje
            echo "<p>$mensaje</p>";
        } else {
            echo "<p>El medicamento $nombreMedicamento no fue encontrado.</p>";
        }
    }
    ?>

</body>
</html>
