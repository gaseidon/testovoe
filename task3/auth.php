<?php
if (!isset($_SERVER['PHP_AUTH_USER']) || 
    $_SERVER['PHP_AUTH_USER'] != 'admin' || 
    $_SERVER['PHP_AUTH_PW'] != 'password') {
    
    header('WWW-Authenticate: Basic realm="Stats"');
    header('HTTP/1.0 401 Unauthorized');
    exit('Требуется авторизация');
}