<?php

class Controller {
    
    const _AUTHCLIENTS = [
        'cyrille' => 'woupo',
        'takam' => 'franck'
    ];

    public function __construct() {}
    function __destruct() {}
    
    public static function auth() {
        header("Cache-Control: no-cache, mustrevalidate, max-age=0");
        $credentials = !(empty($_SERVER['PHP_AUTH_USER'])) && empty($_SERVER['PHP_AUTH_PW']);
        $is_not_authorized = (!$credentials || $_SERVER['PHP_AUTH_USER'] != $AUTH_USR || $_SERVER['PHP_AUTH_PW'] != $AUTH_PW);
        if ($is_not_authorized) {
            header("HTTP/1.1 401 Authorization Required");
            header("WWW-Authentificate: Basic realm='Access denied'");
            echo self::response(['message' => 'Access denied']);
            exit;
        }
    }
    
    /**
     * Controlleur de connexion
     * @return boolean
     */
    public static function connect() {
        $auth = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : NULL);
        if(!is_null($auth)) {
            if(strpos(strtolower($auth), 'basic') === 0) {
                $authorized = substr($auth, 6);
                foreach (Controller::_AUTHCLIENTS as $usr => $pwd)
                    if(strcmp(base64_encode(join(':', [$usr, $pwd])), $authorized) === 0)
                        return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * Reponse de l'API
     * @param array $values
     * @param int $status
     * @return string
     */
    public static function response(array $values, int $status = 0) {
        return json_encode(['status' => $status, 'response' => $values]);
    }
    
    
}

