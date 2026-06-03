<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->render('auth/login', [
            'titulo' => 'Login - Revizzi',
        ]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        setcookie('revizzi_lembrar', '', time() - 3600, '/');
        header('Location: login');
        exit;
    }

    public function login(): void
    {
        $usuario = trim($_POST['usuario'] ?? '');
        $senha   = $_POST['senha'] ?? '';

        // TODO: validar contra banco de dados
        if ($usuario === 'jonathan' && $senha === 'revizzitimao') {
            $_SESSION['autenticado'] = true;
            if (!empty($_POST['lembrar'])) {
                setcookie('revizzi_lembrar', '1', time() + 60 * 60 * 24 * 30, '/', '', false, true);
            }
            header('Location: relatorios');
            exit;
        }

        $this->render('auth/login', [
            'titulo' => 'Login - Revizzi',
            'erro'   => 'Usuário ou senha incorretos.',
        ]);
    }
}
