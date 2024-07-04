<?php
// Conexión a MariaDB
$servername = "localhost";
$username = "mauro";
$password = "Maurok92";
$dbname = "examen";

// Crear conexión
$connMaria = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$connMaria) {
    die("Connection failed: " . mysqli_connect_error());
}

// Conexión a Oracle
$connOracle = oci_connect('mauro', 'Maurok92', '192.168.11.23/XEPDB1');
if (!$connOracle) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjI3v5W2RU90FeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .d { text-align: right; }
    </style>
</head>
<body>
    <h1>Notas de la BBDD "EXAMEN" en MariaDB</h1>
    <table border="2" class="table table-striped">
        <tr>
            <th scope="col">DNI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Nota</th>
        </tr>
        <?php
        $sql = "SELECT * FROM notas";
        $result = mysqli_query($connMaria, $sql);

        // Borrar la tabla de Oracle
        $stid = oci_parse($connOracle, "DELETE FROM notas");
        if (!$stid) {
            $e = oci_error($connOracle);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        oci_execute($stid);

        // Insertar en la BBDD de Oracle
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["dni"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td class='d'>" . $row["nota"] . "</td>";
                echo "</tr>";

                $stid = oci_parse($connOracle, "INSERT INTO NOTAS (dni, nombre, nota) VALUES ('{$row["dni"]}', '{$row["nombre"]}', {$row["nota"]})");
                if (!$stid) {
                    $e = oci_error($connOracle);
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                }
                oci_execute($stid);
            }
        } else {
            echo "<tr><td colspan='3'>0 results</td></tr>";
        }

        mysqli_close($connMaria);
        ?>
    </table>

    <!-- ahora pongo los datos de Oracle -->
    <h1>Consulta a "NOTAS" en Oracle</h1>
    <table border="2" class="table table-striped">
        <tr>
            <th scope="col">DNI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Nota</th>
        </tr>
        <?php
        try {
            $stid = oci_parse($connOracle, 'SELECT * FROM notas');
            if (!$stid) {
                $e = oci_error($connOracle);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            oci_execute($stid);

            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>";
                }
                echo "</tr>";
            }

            oci_free_statement($stid);
            oci_close($connOracle);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </table>
</body>
</html>
