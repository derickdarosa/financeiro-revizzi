<?php
declare(strict_types=1);

/**
 * Cookie "lembrar-me" assinado com HMAC — não pode ser forjado sem REMEMBER_SECRET,
 * ao contrário do valor fixo '1' usado anteriormente.
 */
class RememberMe
{
    private const COOKIE = 'revizzi_lembrar';
    private const DIAS   = 30;

    public static function emitir(): void
    {
        $exp = time() + 60 * 60 * 24 * self::DIAS;
        $valor = $exp . '.' . self::assinar((string) $exp);
        setcookie(self::COOKIE, $valor, $exp, '/', '', self::isHttps(), true);
    }

    public static function valido(): bool
    {
        $cookie = $_COOKIE[self::COOKIE] ?? '';
        if (!str_contains($cookie, '.')) {
            return false;
        }

        [$exp, $assinatura] = explode('.', $cookie, 2);
        if (!ctype_digit($exp) || (int) $exp < time()) {
            return false;
        }

        return hash_equals(self::assinar($exp), $assinatura);
    }

    public static function limpar(): void
    {
        setcookie(self::COOKIE, '', time() - 3600, '/', '', self::isHttps(), true);
    }

    private static function assinar(string $exp): string
    {
        $secret = env('REMEMBER_SECRET');
        if (!$secret) {
            throw new RuntimeException('REMEMBER_SECRET não definido no .env');
        }
        return hash_hmac('sha256', $exp, $secret);
    }

    private static function isHttps(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['SERVER_PORT'] ?? null) === '443')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    }
}
