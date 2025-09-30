<?php
require 'db.php';
// Minimal order form (adds order without items for brevity)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = intval($_POST['customer_id'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);
    $stmt = $pdo->prepare('INSERT INTO orders (customer_id,total) VALUES (?,?)');
    $stmt->execute([$customer_id,$total]);
    $success = 'Pedido criado.';
}
$customers = $pdo->query('SELECT id,name FROM customers')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Pedidos</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Pedidos</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($success)) echo '<p style="color:green">'.$success.'</p>'; ?>
<form method="post">
  <label>Cliente:
    <select name="customer_id">
      <option value="0">-- selecione --</option>
      <?php foreach($customers as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Total: <input name="total" type="number" step="0.01"></label><br>
  <button type="submit">Criar</button>
</form>
</body></html>
