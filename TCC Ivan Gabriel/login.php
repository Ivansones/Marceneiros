<?php
session_start();
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');


if (!$connect) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if (isset($_POST['verificar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "select id,nome,senha,tipo from usuario
            where senha ='$senha' and nome = '$nome'";

    $resultado = mysql_query($sql);

    $dados = mysql_fetch_assoc($resultado);

    if (mysql_num_rows($resultado) <=0)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('login e/ou senha incorretos');
        window.location.href ='login.html';
        </script>";
    }
    else 
    {
        $_SESSION['user_id'] = $dados['id'];
        $_SESSION['user_name'] = $dados['nome'];
        setcookie('nome',$nome);
        header('location:home.html');
    }
}




?>
