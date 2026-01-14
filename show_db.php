<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BASE DE DATOS: DB_PRUEBAS_DE ===\n\n";

// Obtener todas las tablas
$tables = DB::select("
    SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_TYPE = 'BASE TABLE' 
    ORDER BY TABLE_NAME
");

echo "TABLAS ENCONTRADAS (" . count($tables) . "):\n";
echo str_repeat("-", 50) . "\n";

foreach ($tables as $table) {
    echo "• {$table->TABLE_NAME}\n";
    
    // Obtener conteo de registros
    try {
        $count = DB::table($table->TABLE_NAME)->count();
        echo "  Registros: {$count}\n";
    } catch (Exception $e) {
        echo "  (No se pudo contar)\n";
    }
    
    echo "\n";
}

// Mostrar información adicional
echo "\n" . str_repeat("=", 50) . "\n";
echo "INFORMACIÓN DE CONEXIÓN:\n";
echo "Servidor: " . config('database.connections.sqlsrv.host') . "\n";
echo "Base de datos: " . config('database.connections.sqlsrv.database') . "\n";
echo "Usuario: " . config('database.connections.sqlsrv.username') . "\n";
