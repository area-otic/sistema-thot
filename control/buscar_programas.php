<?php
include '../includes/db.php';

header('Content-Type: application/json');

try {
    // Obtener parámetros de búsqueda desde GET
    $params = [
        'nombre' => isset($_GET['nombre']) ? $_GET['nombre'] : null,
        'tipo' => isset($_GET['tipo']) ? $_GET['tipo'] : null,
        'categoria' => isset($_GET['categoria']) ? $_GET['categoria'] : null,
        'pais' => isset($_GET['pais']) ? $_GET['pais'] : null,
        'modalidad' => isset($_GET['modalidad']) ? $_GET['modalidad'] : null,
        'universidad' => isset($_GET['universidad']) ? $_GET['universidad'] : null
    ];

    // Construir la consulta SQL base
    $sqlBase = "SELECT * FROM data_maestrias WHERE estado_programa = 'Publicado'";;
    $queryParams = [];

    // Añadir condiciones dinámicamente según los parámetros recibidos
    if (!empty($params['nombre'])) {
        $sqlBase .= " AND titulo LIKE :nombre";
        $queryParams[':nombre'] = '%' . $params['nombre'] . '%';
    }

    if (!empty($params['tipo'])) {
        $sqlBase .= " AND tipo = :tipo";
        $queryParams[':tipo'] = $params['tipo'];
    }

    if (!empty($params['categoria'])) {
        $sqlBase .= " AND categoria = :categoria";
        $queryParams[':categoria'] = $params['categoria'];
    }

    if (!empty($params['pais'])) {
        $sqlBase .= " AND pais = :pais";
        $queryParams[':pais'] = $params['pais'];
    }

    if (!empty($params['modalidad'])) {
        $sqlBase .= " AND modalidad = :modalidad";
        $queryParams[':modalidad'] = $params['modalidad'];
    }

    if (!empty($params['universidad'])) {
        $sqlBase .= " AND universidad = :universidad";
        $queryParams[':universidad'] = $params['universidad'];
    }

    // Primero obtener el conteo total
    $sqlCount = "SELECT COUNT(*) as total FROM ($sqlBase) AS subquery";
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->execute($queryParams);
    $totalResultados = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

    // Luego obtener los resultados paginados
    $sql = $sqlBase . " ORDER BY titulo ASC LIMIT 8";
    $stmt = $conn->prepare($sql);
    $stmt->execute($queryParams);
    $programas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver resultados como JSON incluyendo el total
    echo json_encode([
        'programas' => $programas,
        'total' => $totalResultados
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al buscar programas: ' . $e->getMessage()]);
}
?>