<?php
session_start();
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');


if (!$connect) {
    die("Erro de conexão: " . mysql_connect());
}

if (isset($_POST['verificar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "select id,nome,senha,cpf,email,cep,cidade,telefone,endereco,bairro,tipo from usuario
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
        if ($dados['tipo'] == "usuario"){
        $_SESSION['user_id'] = $dados['id'];
        $_SESSION['user_nome'] = $dados['nome'];
        $_SESSION['user_cpf'] = $dados['cpf'];
        $_SESSION['user_email'] = $dados['email'];
        $_SESSION['user_cep'] = $dados['cep'];
        $_SESSION['user_cidade'] = $dados['cidade'];
        $_SESSION['user_telefone'] = $dados['telefone'];
        $_SESSION['user_endereco'] = $dados['endereco'];
        $_SESSION['user_bairro'] = $dados['bairro'];
        $_SESSION['user_tipo'] = $dados['tipo'];
        setcookie('nome',$nome);
        header('location:home.php');
        }
        else{
            $_SESSION['user_id'] = $dados['id'];
            $_SESSION['user_nome'] = $dados['nome'];
            $_SESSION['user_cpf'] = $dados['cpf'];
            $_SESSION['user_email'] = $dados['email'];
            $_SESSION['user_cep'] = $dados['cep'];
            $_SESSION['user_cidade'] = $dados['cidade'];
            $_SESSION['user_telefone'] = $dados['telefone'];
            $_SESSION['user_endereco'] = $dados['endereco'];
            $_SESSION['user_bairro'] = $dados['bairro'];
            $_SESSION['user_tipo'] = $dados['tipo'];
            setcookie('nome',$nome);
            header('location:home_adm.php');            
        }
    }
}

?>
