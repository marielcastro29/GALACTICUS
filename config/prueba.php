<?php
try {
    $pdo = new PDO("sqlsrv:Server=localhost;Database=GALACTICUSBD","sa","1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1) Base de datos actual
    $stmt = $pdo->query("SELECT DB_NAME() AS BaseActual");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Base actual: " . $row['BaseActual'] . "<br>";

    // 2) Intentar seleccionar directo de la tabla con nombre totalmente calificado
    $stmt2 = $pdo->query("SELECT TOP 1 * FROM GALACTICUSBD.dbo.SUCURSALES");
    $r = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        echo "Tabla SUCURSALES existe y tiene filas. Primer registro:<br>";
        print_r($r);
    } else {
        echo "Tabla SUCURSALES existe pero está vacía o no devuelve filas.<br>";
    }

    // 3) Intentar ejecutar el SP usando nombre completo
    $stmt3 = $pdo->query("EXEC GALACTICUSBD.dbo.SP_L_SUCURSALES");
    $rows = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    echo "<br>SP ejecutado, filas devueltas: " . count($rows);
} catch (PDOException $e) {
    echo "ERROR PDO: " . $e->getMessage();
}
