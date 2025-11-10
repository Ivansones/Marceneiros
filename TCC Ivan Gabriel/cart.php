<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];
$user_tipo = $_SESSION['user_tipo'];
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove")
{
  if(!empty($_SESSION["shopping_cart"])) {
    foreach($_SESSION["shopping_cart"] as $key => $value) {
      if($_POST["id"] == $key){
      unset($_SESSION["shopping_cart"][$key]);
      $status = "<div class='box' style='color:red;'>
         Produto foi removido do carrinho !</div>";
      }
      if(empty($_SESSION["shopping_cart"]))
         unset($_SESSION["shopping_cart"]);
    }
  }
}

if (isset($_POST["comprar"])){
    $fora_de_estoque = array();

    foreach ($_SESSION["shopping_cart"] as $key => $product){
        
        $productid = $product['id'];

        $sqlquant = "select quantidade from itens where id = '".$productid."'";

        $result = mysql_query($sqlquant);

        $row = mysql_fetch_assoc($result);

        if ($row) {
            $currentQuantity = $row['quantidade'];
            $data_hora = date("Y-m-d H:i:s");
            if ($currentQuantity == 0){
                $fora_de_estoque[] = $product['nome'];
                continue;
            }
            else{
            $sqladiciona = "Insert into vendas(nome,descricao,preco,id_usuario,data,imagen)
                    values('" . $product['nome'] . "','" . $product['descricao'] . "','" . $product['preco'] . "','" . $user_id . "','" . $data_hora . "','" . $product['imagen'] . "')";
       
                
            $resultado = mysql_query($sqladiciona);
            if ($resultado == TRUE){
               $quantidadefinal = $currentQuantity - 1;
               $sqlarruma = "UPDATE itens SET quantidade = '$quantidadefinal' WHERE id = '$productid'";
               mysql_query($sqlarruma);
            } else{
                echo "deu errado";
            }
            }
        }
        if (!empty($fora_de_estoque)) {
        $nomes = implode(", ", $fora_de_estoque);
        echo "<script>
                alert('Compra concluída! Porém, os seguintes produtos estavam fora de estoque: $nomes');
                window.location.href = 'home.php';
              </script>";
        }else {
        echo "<script>
                alert('Compra realizada com sucesso!');
                window.location.href = 'home.php';
              </script>";
    }
    }
    unset($_SESSION['shopping_cart']);
}
?>
<HTML>
<HEAD>
 <TITLE>Carrinho Compras </TITLE>
  <link rel="stylesheet" href="estiliza.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</HEAD>
<BODY>

<div class="home-content">
    <a href="home.php" class="btn" style="margin-bottom: 20px; display: inline-block;">Voltar para a Home</a>

    <section class="items-section">
        <h2>Seu Carrinho de Compras</h2>

        <div class="cart-content">
            <?php
            if(isset($_SESSION["shopping_cart"])){
            ?>
                <table class="table cart-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>descricao</th>
                            <th>Valor</th>
                            <th>Imagem</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                foreach ($_SESSION["shopping_cart"] as $key => $product){
                ?>
                    <tr>
                        <td><?php echo $product["nome"]; ?></td>
                        <td><?php echo $product["descricao"]; ?></td>
                        <td>R$ <?php echo number_format($product["preco"],2,',','.'); ?></td>
                        <td><img src="imagens/<?php echo $product["imagen"]; ?>" class="cart-item-image"></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $key; ?>" />
                                <input type="hidden" name="action" value="remove" />
                                <button type="submit" class="btn-remove">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <?php
            }else{
                echo "<div class='empty-state'><h3>Seu carrinho esta vazio!</h3><p>Adicione produtos da loja para ve-los aqui.</p></div>";
            }
            ?>
        </div>

        <div style="clear:both;"></div>

        <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
        </div>

        <?php if(!empty($_SESSION["shopping_cart"])): ?>
            <div class="cart-footer">
                <form action="cart.php" method="post">
                    <input type="submit" name="comprar" value="Finalizar Compra" class="btn-order">
                </form>
            </div>
        <?php endif; ?>

    </section>
</div>

</BODY>
</HTML>
