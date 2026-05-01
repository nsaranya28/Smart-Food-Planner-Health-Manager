<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
        $height = $_POST['height'] ?? null;
        $weight = $_POST['weight'] ?? null;

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, height, weight) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $password, $height, $weight]);
            
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            
            header("Location: ../index.php");
            exit;
        } catch (PDOException $e) {
            header("Location: ../register.php?error=exists");
            exit;
        }
    }

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: ../index.php");
            exit;
        } else {
            header("Location: ../login.php?error=1");
            exit;
        }
    }
}
?>
