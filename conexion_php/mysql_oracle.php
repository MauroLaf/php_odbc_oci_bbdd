<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="
https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
" 
          rel="stylesheet" 
          integrity="sha384-QWTKZVijpPEj1Sv5WaRU90FeRpok6YctnYmDr5pNlYt2bRJXh0JMhY6HW+ALEwH1" 
          crossorigin="anonymous">
    <style>
        .d {text-align:right;}
    </style>
</head>
<body>
    <h1>Notas de la BBDD "examen"</h1>
    <table border="1" class="table table-striped">
        <tr>
            <th scope="col">DNI</th>
            <th scope="col">Nombre</th>
            <th scope="col">Nota</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "mauro";
        $password = "Maurok92";
        $dbname = "examen";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT dni, nombre, nota FROM notas";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr scope='row'>";
                echo "<td>" . $row["dni"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td class='d'>" . $row["nota"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>0 results</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</body>
</html> 