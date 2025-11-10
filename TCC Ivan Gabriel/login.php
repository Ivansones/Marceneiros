<?php
session_start();

// Use 127.0.0.1 and the correct port
$host = '127.0.0.1:3306'; // change 3307 to the port you set in my.ini
$user = 'root';
$pass = '';           // use the password you set in my.ini
$db   = 'marcenaria';

// Connect to MySQL
$connect = mysql_connect($host, $user, $pass) or die("Erro de conexão: " . mysql_error());

// Select database
mysql_select_db($db, $connect) or die("Erro ao selecionar o banco: " . mysql_error());

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
        window.location.href ='login_no_log.html';
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
