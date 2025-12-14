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
     *  - Nếu có file CA tại configs/aiven-ca.pem thì tự bật SSL
     *  - Hoặc set đường dẫn CA bằng ENV: DB_SSL_CA
     */
    private function env(string $key, ?string $fallback = null): ?string {
        $v = getenv($key);
        if ($v === false || $v === '') {
            return $fallback;
        }
        return $v;
    }

    public function connect(): false|mysqli
    {
        $host = $this->env('DB_HOST', $this->env('MYSQL_HOST', 'localhost'));
        $port = (int)($this->env('DB_PORT', $this->env('MYSQL_PORT', '3306')) ?? '3306');

        // ✅ DB của bạn trên Aiven là "vidental"
        $db   = $this->env('DB_NAME', $this->env('MYSQL_DATABASE', 'vidental'));

        $user = $this->env('DB_USER', $this->env('MYSQL_USER', 'root'));
        $pass = $this->env('DB_PASS', $this->env('MYSQL_PASSWORD', ''));

        // ✅ Nếu có CA cert thì bật SSL (Aiven SSL REQUIRED)
        $defaultCa = __DIR__ . '/../configs/aiven-ca.pem';
        $sslCa = $this->env('DB_SSL_CA', $defaultCa);
        $useSsl = is_string($sslCa) && $sslCa !== '' && file_exists($sslCa);

        $mysqli = mysqli_init();

        if ($useSsl) {
            // client key/cert không cần, chỉ cần CA
            $mysqli->ssl_set(null, null, $sslCa, null, null);
        }

        $flags = $useSsl ? MYSQLI_CLIENT_SSL : 0;

        if (!$mysqli->real_connect($host, $user, $pass, $db, $port, null, $flags)) {
            return false;
        }

        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
}
