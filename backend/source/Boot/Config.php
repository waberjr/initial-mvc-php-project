<?php

$server = $_SERVER["SERVER_NAME"];
define("SCRIPT_VERSION", "-v0.1.0");

/**
 * DB CONFIG
 */
if ($server == "192.168.1.31" OR $server == "intranet"){
    define("CONF_ENVIRONMENT", "PRODUCTION");
    define("CONF_URL_BASE", "http://{$server}");
}
else if($server == "192.168.1.191") {
    define("CONF_ENVIRONMENT", "TEST");
    define("CONF_URL_BASE", "http://{$server}");
}
else{
    define("CONF_ENVIRONMENT", "DEV");
    define("CONF_URL_BASE", "http://{$server}/contador-cadastros");
}

/**
 * VIEW
 */
const CONF_VIEW_PATH = __DIR__ . "/../../themes";
const CONF_VIEW_EXT = "php";
const CONF_VIEW_THEME = "web";


/**
 * PASSWORD
 */

const CONF_PASSWD_MIN_LEN = 8;
const CONF_PASSWD_MAX_LEN = 18;

/**
 * CRYPT
 */
const CONF_ENCRYPT_METHOD = "AES-256-CBC";
const CONF_SECRET_KEY = "AA74CDCC2BBRT935136HH7B63C27AYSHGBFDOAGSD1L2123OULYASGBFOUYASDG";
const CONF_SECRET_IV = "ASUYIDBF5fgf5HJ5g27ADIJFADFOJIASDFÇJOLKIASFDÇJIOK";