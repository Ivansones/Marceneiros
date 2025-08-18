<?php
session_start();


$conectar = mysql_connect('localhost', username: 'root', password: '');
if (!$conectar) {
    die('Erro de conexão: ' . mysql_error());
}
$db = mysql_select_db(database_name: 'marcenaria', link_identifier: $conectar);
if (!$db) {
    die('Erro ao selecionar banco: ' . mysql_error());
}







            
            
 