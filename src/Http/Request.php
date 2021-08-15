<?php

namespace Leonardo\Comments\Http;

use Leonardo\Comments\Facades\Builder;

/**
 * Class Request
 * @package Leonardo\Comments\Http
 */
class Request {

    /** @var array */
    private $server;

    /** @var array */
    private $whitelist = ['127.0.0.1', '::1'];


    /**
     * Request constructor.
     */
    public function __construct() {
        $this->server = $_SERVER;
    }


    /**
     * @return string
     */
    public static function method() {
        return exists('REQUEST_METHOD', (new static())->server);
    }


    /**
     * @return string
     */
    public static function userAgent() {
        return exists('HTTP_USER_AGENT', (new static())->server);
    }


    /**
     * @return string
     */
    public static function host() {
        return exists('HTTP_HOST', (new static())->server);
    }


    /**
     * @return string
     */
    public static function ip() {
        return exists('REMOTE_ADDR', (new static())->server);
    }


    /**
     * @return string
     */
    public static function root() {
        return rtrim(exists('SCRIPT_FILENAME', (new static())->server), '/');
    }


    /**
     * @return string
     */
    public static function secure() {
        $https = exists('HTTPS', (new static())->server);

        return ($https == "on") ? 'https' : 'http';
    }


    /**
     * @return string
     */
    public static function decodedPath() {
        return exists('REQUEST_URI', (new static())->server);
    }


    /**
     * @return string
     */
    public static function fullUrl() {
        $url = self::url();

        if (! (new static())->isLocalhost()) {
            $url .= self::decodedPath();
        }

        $url .= "?" . (new static())->queryString();

        return rtrim($url, '?');
    }


    /**
     * @return string
     */
    public static function domain() {
        $protocolo  = self::secure();
        $hostname   = self::host();

        return "{$protocolo}://{$hostname}";
    }


    /**
     * @return string
     */
    public static function url() {
        $url = rtrim(self::domain() . (new static())->getUri(), '/');

        if ($string = strstr($url, '?', true)) {
            return rtrim($string, '/');
        }

        return rtrim($url, '/');
    }


    /**
     * @return string
     */
    public static function redirect($url, $time = 100) {
        echo "<script>
        setTimeout(function () {
            window.location.href= '{$url}';
        }, {$time});
        </script>";
    }


    /**
     * @return string
     */
    private function getUri() {
        return exists('REQUEST_URI', $this->server);
    }


    /**
     * @return int|string|null
     */
    private function queryString() {
        return exists('QUERY_STRING', $this->server);
    }


    /**
     * @return bool
     */
    private function isLocalhost() {
        return in_array(self::ip(), $this->whitelist);
    }

}
