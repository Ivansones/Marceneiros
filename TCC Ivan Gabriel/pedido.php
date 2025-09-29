<?php
session_start();
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');

if (!$connect) {
    die("Erro de conexão: " . mysqli_connect_error());
}
$user_id = $_SESSION['user_id'];

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
    $price = 0;
    
    //Para o item base//
    $sql = "SELECT preco FROM opcoes
            WHERE nome = '$qual'";
    $resposta = mysql_query($sql);
    if ($resposta){
    $dados = mysql_fetch_assoc($resposta);
    if ($dados){    
        $price = $dados['preco'];

        }       
    }

    //Aqui é para os adicionais//
    if (!empty($_POST['adicionas'])){
        foreach($_POST['adicionas'] as $adicional) {
        $sqladicional = "SELECT preco FROM adicionais
                     WHERE nome = '$adicional'";
        $respostaadi = mysql_query($sqladicional);
        if ($respostaadi){
        $dadosadi = mysql_fetch_assoc($respostaadi);
        if ($dadosadi){    
            $price = $price + $dadosadi['preco'];
    
            }       
        }
    }
    }
    $sql = "insert into pedidos(cpf,user_id,nome,email,telefone_celular,cep,cidade,endereco,bairro,data,hora,descricao,preco)
    values('$cpf','$user_id','$nome','$email','$telefone_celular','$cep','$cidade','$endereco','$bairro','$data','$hora','$descricao','$price')";


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