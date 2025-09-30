<?php
require 'db.php';
// Simple CRUD for users (create, read, update, delete) in same page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');
    if ($name === '' || $email === '') {
        $error = 'Nome e email são obrigatórios.';
    } else {
        if (!empty($_POST['id'])) {
            // update
            $stmt = $pdo->prepare('UPDATE users SET name=?, email=?, role=? WHERE id=?');
            $stmt->execute([$name,$email,$role,(int)$_POST['id']]);
        } else {
            // insert
            $stmt = $pdo->prepare('INSERT INTO users (name,email,role) VALUES (?,?,?)');
            $stmt->execute([$name,$email,$role]);
        }
        header('Location: users.php');
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: users.php');
    exit;
}

$users = $pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Usuários</title><link rel="stylesheet" href="assets/style.css"></head><body>
<h2>Usuários (CRUD)</h2>
<p><a href="index.php">Voltar ao início</a></p>
<?php if(!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
  <input type="hidden" name="id" value="">
  <label>Nome: <input name="name" required></label><br>
  <label>Email: <input name="email" type="email" required></label><br>
  <label>Role: <input name="role"></label><br>
  <button type="submit">Salvar</button>
</form>
<hr>
<table border="1" cellpadding="6"><tr><th>ID</th><th>Nome</th><th>Email</th><th>Role</th><th>Ações</th></tr>
<?php foreach($users as $u): ?>
<tr>
<td><?=htmlspecialchars($u['id'])?></td>
<td><?=htmlspecialchars($u['name'])?></td>
<td><?=htmlspecialchars($u['email'])?></td>
<td><?=htmlspecialchars($u['role'])?></td>
<td>
  <a href="users.php?delete=<?= $u['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
