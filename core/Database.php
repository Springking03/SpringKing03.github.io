<?php

class Database {
    /**
     * Kết nối DB theo ENV (dùng được cho local XAMPP, Docker, Render, v.v.)
     *
     * Ưu tiên các biến môi trường:
     *  - DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
     * (fallback)
     *  - MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD
     *
     * SSL (Aiven thường REQUIRE SSL):
     *  - DB_SSL_MODE: AUTO | REQUIRED | DISABLED (mặc định AUTO)
     *  - DB_SSL_CA: đường dẫn file CA (mặc định configs/aiven-ca.pem)
     *  - DB_SSL_VERIFY: true|false (mặc định true)
     *
     * AUTO: chỉ bật SSL khi host KHÔNG phải localhost/127.0.0.1 và có file CA.
     */
    private function env(string $key, ?string $fallback = null): ?string {
        $v = getenv($key);
        if ($v === false || $v === '') {
            return $fallback;
        }
        return $v;
    }

    private function boolEnv(string $key, bool $fallback = true): bool {
        $v = getenv($key);
        if ($v === false || $v === '') return $fallback;
        $v = strtolower(trim((string)$v));
        return in_array($v, ['1','true','yes','on'], true);
    }

    public function connect(): false|mysqli
    {
        $host = $this->env('DB_HOST', $this->env('MYSQL_HOST', 'localhost'));
        $port = (int)($this->env('DB_PORT', $this->env('MYSQL_PORT', '3306')) ?? '3306');

        // DB name: ưu tiên ENV, fallback về MYSQL_DATABASE, cuối cùng là defaultdb (Aiven hay dùng)
        $db   = $this->env('DB_NAME', $this->env('MYSQL_DATABASE', 'defaultdb'));

        $user = $this->env('DB_USER', $this->env('MYSQL_USER', 'root'));
        $pass = $this->env('DB_PASS', $this->env('MYSQL_PASSWORD', ''));

        $sslMode = strtoupper($this->env('DB_SSL_MODE', 'AUTO') ?? 'AUTO');
        $defaultCa = __DIR__ . '/../configs/aiven-ca.pem';
        $sslCa = $this->env('DB_SSL_CA', $defaultCa);

        $isLocalHost = in_array($host, ['localhost', '127.0.0.1'], true);

        $useSsl = false;
        if ($sslMode === 'REQUIRED') {
            $useSsl = true;
        } elseif ($sslMode === 'DISABLED') {
            $useSsl = false;
        } else { // AUTO
            $useSsl = (!$isLocalHost) && is_string($sslCa) && $sslCa !== '' && file_exists($sslCa);
        }

        $verify = $this->boolEnv('DB_SSL_VERIFY', true);

        $mysqli = mysqli_init();

        if ($useSsl) {
            // client key/cert không cần, chỉ cần CA
            $mysqli->ssl_set(null, null, $sslCa, null, null);
        }

        $flags = 0;
        if ($useSsl) {
            $flags |= MYSQLI_CLIENT_SSL;
            if (!$verify && defined('MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT')) {
                $flags |= MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
            }
        }

        if (!$mysqli->real_connect($host, $user, $pass, $db, $port, null, $flags)) {
            // giữ return false để code cũ không bị vỡ, nhưng log rõ lý do
            error_log('[DB] Connect failed: ' . mysqli_connect_error());
            return false;
        }

        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
}
