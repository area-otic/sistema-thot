<?php
include '../includes/db.php';

header('Content-Type: application/json');

try {
    // Obtener parámetros de búsqueda desde POST
    $params = [
        'page' => isset($_POST['page']) ? (int)$_POST['page'] : 1,
        'nombre' => isset($_POST['nombre']) ? $_POST['nombre'] : null,
        'tipo' => isset($_POST['tipo']) ? $_POST['tipo'] : null,
        'categoria' => isset($_POST['categoria']) ? $_POST['categoria'] : null,
        'pais' => isset($_POST['pais']) ? $_POST['pais'] : null,
        'modalidad' => isset($_POST['modalidad']) ? $_POST['modalidad'] : null,
        'universidad' => isset($_POST['universidad']) ? $_POST['universidad'] : null
    ];

    // Calcular offset para la paginación
    $programsPerPage = 8;
    $offset = ($params['page'] - 1) * $programsPerPage;

    // Construir la consulta SQL base
    $sql = "SELECT * FROM data_maestrias WHERE 1=1";
    $queryParams = [];

    // Añadir condiciones dinámicamente según los parámetros recibidos
    if (!empty($params['nombre'])) {
        $sql .= " AND titulo LIKE :nombre";
        $queryParams[':nombre'] = '%' . $params['nombre'] . '%';
    }

    if (!empty($params['tipo'])) {
        $sql .= " AND tipo = :tipo";
        $queryParams[':tipo'] = $params['tipo'];
    }

    if (!empty($params['categoria'])) {
        $sql .= " AND categoria = :categoria";
        $queryParams[':categoria'] = $params['categoria'];
    }

    if (!empty($params['pais'])) {
        $sql .= " AND pais = :pais";
        $queryParams[':pais'] = $params['pais'];
    }

    if (!empty($params['modalidad'])) {
        $sql .= " AND modalidad = :modalidad";
        $queryParams[':modalidad'] = $params['modalidad'];
    }

    if (!empty($params['universidad'])) {
        $sql .= " AND universidad = :universidad";
        $queryParams[':universidad'] = $params['universidad'];
    }

    // Ordenar por algún criterio (opcional)
    $sql .= " ORDER BY titulo ASC";

    // Añadir límite y offset para paginación
    $sql .= " LIMIT :offset, :limit";
    $queryParams[':offset'] = $offset;
    $queryParams[':limit'] = $programsPerPage;

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Bind parameters (necesario para los límites)
    foreach ($queryParams as $key => &$val) {
        if ($key === ':offset' || $key === ':limit') {
            $stmt->bindParam($key, $val, PDO::PARAM_INT);
        } else {
            $stmt->bindParam($key, $val);
        }
    }

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener resultados
    $programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver resultados como JSON
    echo json_encode($programas);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al cargar más programas: ' . $e->getMessage()]);
}
?>