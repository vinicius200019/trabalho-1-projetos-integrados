<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($name === '') { $error = 'Nome obrigatório.'; }
    else {
        $stmt = $pdo->prepare('INSERT INTO suppliers (name, phone) VALUES (?,?)');
        $stmt->execute([$name,$phone]);
        header('Location: suppliers.php');
        exit;
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM suppliers WHERE id = ?');
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: suppliers.php');
    exit;
}
$suppliers = $pdo->query('SELECT * FROM suppliers ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Fornecedores</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Fornecedores (CRUD)</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
  <label>Nome: <input name="name" required></label><br>
  <label>Telefone: <input name="phone"></label><br>
  <button type="submit">Adicionar</button>
</form>
<hr>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Nome</th><th>Telefone</th><th>Ações</th></tr>
<?php foreach($suppliers as $s): ?>
<tr>
<td><?=htmlspecialchars($s['id'])?></td>
<td><?=htmlspecialchars($s['name'])?></td>
<td><?=htmlspecialchars($s['phone'])?></td>
<td><a href="suppliers.php?delete=<?= $s['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
