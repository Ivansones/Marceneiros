<?php
session_start();

$conectar = mysql_connect('localhost', 'root', '');
if (!$conectar) {
    die('Erro de conexão: ' . mysql_error());
}

$db = mysql_select_db('marcenaria', $conectar);
if (!$db) {
    die('Erro ao selecionar banco: ' . mysql_error());
}

// Buscar itens do catálogo
$query = "SELECT * FROM itens ORDER BY id DESC";
$resultado = mysql_query($query, $conectar);

$itens = array();

if ($resultado) {
    while ($item = mysql_fetch_assoc($resultado)) {
        $itens[] = $item;
    }
}

mysql_close($conectar);

// Retornar JSON para o JavaScript usar
header('Content-Type: application/json');
echo json_encode($itens);
?>