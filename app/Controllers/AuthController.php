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
        RememberMe::limpar();
        header('Location: login');
        exit;
    }

    public function login(): void
    {
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            $this->render('auth/login', [
                'titulo' => 'Login - Revizzi',
                'erro'   => 'Sessão expirada, tente novamente.',
            ]);
            return;
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $senha   = $_POST['senha'] ?? '';

        $bloqueio = $this->verificarBloqueio();
        if ($bloqueio !== null) {
            $this->render('auth/login', [
                'titulo' => 'Login - Revizzi',
                'erro'   => "Muitas tentativas. Tente novamente em {$bloqueio}s.",
            ]);
            return;
        }

        $usuarioEsperado = env('AUTH_USER');
        $hashEsperado     = env('AUTH_PASS_HASH');

        $ok = $usuarioEsperado !== null && $hashEsperado !== null
            && hash_equals($usuarioEsperado, $usuario)
            && password_verify($senha, $hashEsperado);

        if ($ok) {
            unset($_SESSION['login_tentativas'], $_SESSION['login_ultima_tentativa']);
            session_regenerate_id(true);
            $_SESSION['autenticado'] = true;
            if (!empty($_POST['lembrar'])) {
                RememberMe::emitir();
            }
            header('Location: relatorios');
            exit;
        }

        $this->registrarFalha();
        $this->render('auth/login', [
            'titulo' => 'Login - Revizzi',
            'erro'   => 'Usuário ou senha incorretos.',
        ]);
    }

    private function registrarFalha(): void
    {
        $_SESSION['login_tentativas']       = ($_SESSION['login_tentativas'] ?? 0) + 1;
        $_SESSION['login_ultima_tentativa'] = time();
    }

    /** Retorna segundos restantes de bloqueio, ou null se pode tentar. */
    private function verificarBloqueio(): ?int
    {
        $tentativas = $_SESSION['login_tentativas'] ?? 0;
        if ($tentativas < 3) {
            return null;
        }

        $espera   = min(30, ($tentativas - 2) * 5);
        $decorrido = time() - (int) ($_SESSION['login_ultima_tentativa'] ?? 0);
        $restante  = $espera - $decorrido;

        return $restante > 0 ? $restante : null;
    }
}
