
<?php
require 'db.php';
// Simple customer form (no full CRUD) as required by the brief
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name === '') { $error = 'Nome obrigatório.'; } else {
        $stmt = $pdo->prepare('INSERT INTO customers (name,email) VALUES (?,?)');
        $stmt->execute([$name,$email]);
        $success = 'Cliente cadastrado.';
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Clientes</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Clientes</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<?php if(!empty($success)) echo '<p style="color:green">'.$success.'</p>'; ?>
<form method="post">
  <label>Nome: <input name="name" required></label><br>
  <label>Email: <input name="email" type="email"></label><br>
  <button type="submit">Salvar</button>
</form>
</body></html>
