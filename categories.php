<?php
require 'db.php';
// Simple category form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') { $error = 'Nome obrigatório.'; } else {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
        $success = 'Categoria criada.';
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Categorias</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Categorias</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($success)) echo '<p style="color:green">'.$success.'</p>'; ?>
<form method="post">
  <label>Nome: <input name="name" required></label><br>
  <button type="submit">Salvar</button>
</form>
</body></html>
