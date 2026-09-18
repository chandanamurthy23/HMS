<?php
/**
 * Hospital Management System (HMS) - Database Connection Layer
 * Supports MySQL with automatic fallback to SQLite for zero-config portability.
 */

require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $instance = null;
    private static string $driver = 'mysql';

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            try {
                // Attempt MySQL Connection (Supports custom cloud ports and SSL)
                $port = defined('DB_PORT') ? (int)DB_PORT : 3306;
                $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                // If connecting to remote cloud host over non-localhost, disable verify peer for self-signed cloud certs
                if (DB_HOST !== 'localhost' && DB_HOST !== '127.0.0.1') {
                    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
                }
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$driver = 'mysql';
            } catch (PDOException $e) {
                // If database does not exist, try to create it or fall back to SQLite
                try {
                    $port = defined('DB_PORT') ? (int)DB_PORT : 3306;
                    $dsnHostOnly = "mysql:host=" . DB_HOST . ";port=" . $port . ";charset=" . DB_CHARSET;
                    $tempPdo = new PDO($dsnHostOnly, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                    $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    self::$instance = new PDO("mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                    self::$driver = 'mysql';
                } catch (Exception $fallbackEx) {
                    // Fallback to SQLite
                    $sqliteFile = SQLITE_DB_PATH;
                    self::$instance = new PDO("sqlite:" . $sqliteFile, null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                    self::$driver = 'sqlite';
                }
            }
        }
        return self::$instance;
    }

    public static function getDriver(): string {
        return self::$driver;
    }
}

// Global helper function to get DB instance
function getDB(): PDO {
    return Database::getConnection();
}
