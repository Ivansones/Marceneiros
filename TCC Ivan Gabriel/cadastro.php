<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');

if (!$connect) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if (isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $tipo = "usuario";
    
    $sqlbusca = "select id from usuario
            where  nome = '$nome' and senha = '$senha'";

    $resultadobusca = mysql_query($sqlbusca);

    if (mysql_num_rows($resultadobusca) == 0){
    $sql = "insert into usuario(nome,senha,cpf,email,cep,cidade,telefone,endereco,bairro,tipo)
            values('$nome','$senha','$cpf','$email','$cep','$cidade','$telefone','$endereco','$bairro','$tipo')";

    $resultado = mysql_query($sql);
  
    if($resultado==TRUE){
        echo "<script language ='javascript' type='text/javascript'>
        alert ('Cadastrado com sucesso');
        window.location.href ='home.html';
        </script>";
    }
    else{
        echo "<script language ='javascript' type='text/javascript'>
        alert ('Houve um erro ao cadastrara');
        window.location.href ='cadastro.html';
        </script>";
    }
    }
    else {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('Conta ja foi cadastrada, tente outra');
        window.location.href ='cadastro.html';
        </script>";
    }
}

?>