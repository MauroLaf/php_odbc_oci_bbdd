<?PHP
$user = "mauro";
$password = "Maurok92";
$dsn = "mariadb";

$ODBCConnection = odbc_connect($dsn, $user, $password);

if ($ODBCConnection) {
    echo "Connection established.";
} else {
    echo "Connection failed: " . obdc_errormsg();
}
$SQLQuery = "SELECT * FROM notas";
$RecordSet = odbc_exec($ODBCConnection, $SQLQuery);
$result = odbc_result_all($RecordSet, "border=1");  
odbc_close($ODBCConnection);
?>