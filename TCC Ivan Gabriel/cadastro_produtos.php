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

if (isset($_POST['cadastrar'])) {
    $id = mysql_real_escape_string($_POST['id']);
    $nome = mysql_real_escape_string($_POST['nome']);
    $descricao = mysql_real_escape_string($_POST['descricao']);
    $preco = mysql_real_escape_string($_POST['preco']);
    $quantidade = mysql_real_escape_string($_POST['quantidade']);
    
    // Diretório onde as imagens serão salvas
    $diretorio = "imagens/";
    
    // Verificar se o diretório existe, senão criar
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }
    
    // Processar upload da imagem
    $nome_imagem = '';
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Pegar a extensão do arquivo
        $extensao = strtolower(substr($_FILES['foto']['name'], -4));
        
        // Gerar nome único para a imagem (igual ao projeto da livraria)
        $novo_nome = md5(time() . rand()) . $extensao;
        
        // Mover o arquivo para a pasta imagens/
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome)) {
            $nome_imagem = $novo_nome; // Salva APENAS o nome do arquivo, não o caminho
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem!');</script>";
        }
    }
    
    // Inserir no banco (salva apenas o nome do arquivo na coluna imagen)
    $sql = "INSERT INTO itens (id, nome, descricao, preco, quantidade, imagen) 
            VALUES ('$id', '$nome', '$descricao', '$preco', '$quantidade', '$nome_imagem')";
    
    $resultado = mysql_query($sql);
    
    if ($resultado) {
        echo "<script>alert('Produto cadastrado com sucesso!');
        window.location.href='cadastro_produtos.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar produto: " . mysql_error() . "');</script>";
    }
}

mysql_close($conectar);
?>
