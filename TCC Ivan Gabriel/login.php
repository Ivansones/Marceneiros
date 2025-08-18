<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');

if (isset($_POST['verificar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "select nome,senha from usuario
            where senha ='$senha' and nome = '$nome'";

    $resultado = mysql_query($sql);

    if (mysql_num_rows($resultado) <=0)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('login e/ou senha incorretos');
        window.location.href ='login.html';
        </script>";
    }
    else 
    {
        setcookie('nome',$nome);
        header('location:home.html');
    }
}



?>