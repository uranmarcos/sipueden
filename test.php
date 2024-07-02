<?php



$host = "localhost";
$usuario = "sipueden";
$clave = "Pt1js803~";
$db = "sipueden";

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
echo "Conexion exitosa<br>";

// Definir la clase Database
class Database {
    private $conexion;

    // Constructor para establecer la conexión
    public function __construct($conn) {
        $this->conexion = $conn;
        $this->conexion->set_charset("utf8");
    }

    // Método para consultar la limpieza
    public function consultarLimpieza() {
        try {
            $resultado = $this->conexion->query("SELECT COUNT(*) as cantidad FROM pedidos");
            // if ($resultado) {
            //     return $resultado->fetch_all(MYSQLI_ASSOC);
            // } else {
            //     throw new Exception("Error en la consulta: " . $this->conexion->error);
            // }
            if ($resultado) {
                $filas = array();
                while ($fila = $resultado->fetch_assoc()) {
                    $filas[] = $fila;
                }
                return $filas;
            } else {
                throw new Exception("Error en la consulta: " . $this->conexion->error);
            }
        } catch (\Throwable $th) {
            echo "Excepción capturada: " . $th->getMessage();
            return false;
        }
    }
}

// Crear una instancia de la clase Database
$db = new Database($conn);

echo "consultando";
// Llamar a la función consultarLimpieza
$resultado = $db->consultarLimpieza();

echo "resultado";
var_dump($resultado);
if ($resultado !== false) {
    echo "Resultados de la consulta de limpieza:<br>";
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";
} else {
    echo "Error al ejecutar la consulta de limpieza.";
}

// Cerrar la conexión
$conn->close();
?>
