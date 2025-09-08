<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');


if (isset($_POST['enviar'])) {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone_celular= $_POST['telefone_celular'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $descricao = $_POST['descricao'];
    $qual = $_POST['qual'];
    
    $prices = array(
        'mesa'    => 600,
        'cadeira' => 70,
        'armario' => 700,
        'tabua'   => 100
    );


    if (isset($prices[$qual])){
        $price = $prices[$qual];
    }

    $sql = "insert into pedidos(cpf,nome,email,telefone_celular,cep,cidade,endereco,bairro,data,hora,descricao,preco)
    values('$cpf','$nome','$email','$telefone_celular','$cep','$cidade','$endereco','$bairro','$data','$hora','$descricao','$price')";


    $resultado = mysql_query($sql);

    if($resultado==TRUE)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('O pedido foi enviado com sucesso.');
        window.location.href ='home.html';
        </script>";
    }
    else{
        die("Erro na query: " . mysql_error());
    }

}

?>