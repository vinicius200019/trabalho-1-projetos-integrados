<?php
require 'db.php';
// Simple products CRUD: note this is minimal for the example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    if ($name === '') {
        $error = 'Nome do produto é obrigatório.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO products (name, sku, price, stock) VALUES (?,?,?,?)');
        $stmt->execute([$name,$sku,$price,$stock]);
        header('Location: products.php');
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: products.php');
    exit;
}

$products = $pdo->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Produtos</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Produtos (CRUD)</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
  <label>Nome: <input name="name" required></label><br>
  <label>SKU: <input name="sku"></label><br>
  <label>Preço: <input name="price" type="number" step="0.01"></label><br>
  <label>Estoque: <input name="stock" type="number"></label><br>
  <button type="submit">Adicionar</button>
</form>
<hr>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Nome</th><th>SKU</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr>
<?php foreach($products as $p): ?>
<tr>
<td><?=htmlspecialchars($p['id'])?></td>
<td><?=htmlspecialchars($p['name'])?></td>
<td><?=htmlspecialchars($p['sku'])?></td>
<td><?=htmlspecialchars($p['price'])?></td>
<td><?=htmlspecialchars($p['stock'])?></td>
<td><a href="products.php?delete=<?= $p['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
