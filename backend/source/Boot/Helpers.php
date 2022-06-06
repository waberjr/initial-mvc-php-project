<?php

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Source\Core\Session;
use Source\Models\PermissionModel;

/**
 * ######################
 * ###   VALIDATION   ###
 * ######################
 */

function is_email($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param $phone
 * @return bool
 */
function is_phone($phone){
    if(strlen($phone) > 0 AND strlen($phone) < 15){
        return false;
    }

    return true;
}

/**
 * @param $phone
 * @return bool
 */
function is_fix_phone($phone){
    if(strlen($phone) > 0 AND strlen($phone) < 14){
        return false;
    }

    return true;
}

/**
 * @param $cnpj
 * @return bool
 */
function is_cnpj($cnpj){
    if(strlen($cnpj) > 0 AND strlen($cnpj) < 18){
        return false;
    }

    return true;
}

/**
 * @param $cep
 * @return bool
 */
function is_cep($cep){
    if(strlen($cep) > 0 AND strlen($cep) < 9){
        return false;
    }

    return true;
}

/**
 * @param $uf
 * @return bool
 */
function is_uf($uf){
    if(strlen($uf) == 1 OR filter_var($uf, FILTER_SANITIZE_NUMBER_INT)){
        return false;
    }

    return true;
}

/**
 * @param $password
 * @return bool
 */
function is_password($password){
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
        return true;
    }

    return false;
}

/**
 * @param string $urls

 */
function is_that_uri(string $uri)
{
    $uri = ($uri[0] == "/" ? mb_substr($uri, 1) : $uri);

    if(CONF_ENVIRONMENT == "DEV" AND uri() == "/comunicar-mais/{$uri}"){
        return true;
    }

    if(CONF_ENVIRONMENT != "DEV" AND uri() == "/{$uri}"){
        return true;
    }

    return false;
}

/**
 * @param string $date
 * @return false|string
 */
function is_date(string $date){
    $checkDate = strlen($date) == 5 ? explode('/', "{$date}/2000") : explode('/', $date);

    //check date with format mm/dd/YYYY
    if (!isset($checkDate[1]) OR !isset($checkDate[0]) OR !isset($checkDate[2])){
        return false;
    }

    if (!checkdate($checkDate[1], $checkDate[0], $checkDate[2])) {
        return false;
    }

    return "{$checkDate[2]}-{$checkDate[1]}-{$checkDate[0]} 00:00:00";
}

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string|null $path
 * @return string
 */
function url(string $path = null): string
{
    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

/**
 * @return string
 */
function uri(): string
{
    return $_SERVER["REQUEST_URI"];
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 *
 */
function reload(): void
{
    header("Refresh: 0");
}

/**
 * ##################
 * ###   ASSETS   ###
 * ##################
 */

function theme(string $path = null, string $theme = CONF_VIEW_THEME): string
{
    if ($path) {
        return CONF_URL_BASE . "/themes/{$theme}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/themes/{$theme}";
}

/**
 * ####################
 * ###   PASSWORD   ###
 * ####################
 */

/**
* @param string $password
* @return bool
*/
function is_passwd(string $password): bool
{
 if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN)) {
     return true;
 }

 return false;
}

 /**
  * @param string $password
  * @return string
  */
 function password(string $password): string
 {
     if (!empty(password_get_info($password)['algo'])) {
         return $password;
     }

     return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
 }

/**
 * @param string|null $password
 * @return string
 */
function password_encode_64(?string $password): ?string
{
    if (!empty($password)){
        for ($i = 0; $i < 5; $i++){
            $password = base64_encode($password);
        }

        return $password;
    }

    return null;
}

/**
 * @param string|null $password
 * @return string
 */
function password_decode_64(?string $password): ?string
{
    if (!empty($password)){
        for ($i = 0; $i < 5; $i++){
            $password = base64_decode($password);
        }

        return $password;
    }
    return null;
}

/**
 * @param $string
 * @param string $action
 * @return false|string|null
 */
function encrypt_decrypt($string, $action = 'encrypt')
{
    if (!empty($string)){
        $encrypt_method = CONF_ENCRYPT_METHOD;
        $secret_key = CONF_SECRET_KEY; // user define private key
        $secret_iv = CONF_SECRET_IV; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
    return null;
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string|null $date
 * @param string $format
 * @return string
 * @throws Exception
 */
function date_fmt(?string $date = null, string $format = "d/m/Y H\hi"): string
{
    $date = (empty($date) ? "now" : $date);
    return (new DateTime($date))->format($format);
}

/**
 * @param string $initialDate
 * @return string
 * @throws Exception
 */
function date_difference(string $initialDate)
{
    $dateFormated = date_fmt($initialDate);
    $initialDate = new DateTime($initialDate);
    $finalDate = new DateTime();

    $interval = $initialDate->diff($finalDate);

    if ($interval->d > 2){
        $months = [
            "janeiro",
            "fevereiro",
            "março",
            "abril",
            "maio",
            "junho",
            "julho",
            "agosto",
            "setembro",
            "outubro",
            "novembro",
            "dezembro",
        ];

        //gets the month name
        $month = substr($dateFormated, 3);
        $month = substr($dateFormated, -13, 2);
        foreach ($months as $key => $m){
            if ($key + 1 == $month){
                $monthName = $m;
            }
        }

        $day = $initialDate->format("d");
        $year = $initialDate->format("Y");
        $hour = $initialDate->format("H:i");

        if ($year < $finalDate->format("Y")){
            return "{$day} de {$monthName} de {$year} às {$hour}";
        }
        else{
            return "{$day} de {$monthName} às {$hour}";
        }
    }

    if ($interval->d > 0){
        return "{$interval->d} d";
    }

    if ($interval->h > 0){
        return "{$interval->h} h";
    }

    if ($interval->i > 0){
        return "{$interval->i} min";
    }

    if ($interval->i == 0){
        return "Agora mesmo";
    }
}

/**
 * ###################
 * ###   REQUEST   ###
 * ###################
 */

/**
 * @return string|null
 */
function flash(): ?string
{
    $session = new Session();
    if ($flash = $session->flash()) {
        $json["message"] = $flash->render();
        return json_encode($json);
    }
    return null;
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function request_repeat(string $field, string $value): bool
{
    $session = new Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function removeSpecialChars(string $string): string
{
    $string = mb_strtolower($string);

    return strtr(
        utf8_decode($string),
        utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
    );
}

/**
 * @param string $string
 * @return string
 */
function removeBlankSpaces(string $string): string
{
    return preg_replace('/^\p{Z}+|\p{Z}+$/u',  '', $string);
}

/**
 * @param array $array
 * @return array
 */
function trim_all(array $array)
{
    // Iterate array through for loop
    // Using trim() function to remove all
    // whitespaces from every array objects
    foreach($array as $key => $value) {
        $array[$key] = is_string($value) ? trim($value) : $value;
    }

    return $array;
}

/**
 * @param $bytes
 * @return string
 */
function bytesToHuman($bytes)
{
    $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $bytes > 1024; $i++) $bytes /= 1024;
    return round($bytes, 2) . ' ' . $units[$i];
}

function containsString(string $fullString, string $stringToFind): bool
{
    if (mb_strpos($fullString, $stringToFind) !== false){
        return true;
    }

    return false;
}

function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_Rand(0, $count-1)];
    }
    return $str;
}