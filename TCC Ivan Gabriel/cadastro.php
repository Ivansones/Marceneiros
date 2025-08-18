<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');


if (isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];


    $sql = "select login,senha from usuario
    where login = '$login' and senha = '$senha'";

    $resultado = mysql_query($sql);


    if (mysql_num_rows($resultado) >0)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('Conta ja cadastrada');
        window.location.href ='login.html';
        </script>";
    }
    else {
    $sqlent = "insert into usuario(nome,senha)
            values('$nome','$senha') ";

    $resultadoent = mysql_query($sqlent);

    
    if ($resultadoent==TRUE)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('Conta cadastrada corretamente');
        window.location.href ='home.html';
        </script>";
    }
    }
}

?>