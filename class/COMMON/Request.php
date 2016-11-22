<?php
/**
 * @Author "" <>
 */

final class Request {

    const GET       = 1;
    const POST      = 2;
    const FILES     = 4;
    const COOKIE    = 8;
    const SESSION   = 16;
    const XSS_CLEAR = 32;
    const REQUEST   = 64;
    const NPOST     = 128;

    private static $requestMethod = NULL;
    private static $clearXssFlag = FALSE;

    /**
     * Get request value
     *
     * @param string $sParamName
     * @param mixed $option
     * @return mixed
     */
    public static function get($sParamName, $option) {
        $sResult = NULL;

        if (empty($option) == TRUE) throw new Exception('Parameter type is not defined.');

        switch (TRUE) {
            case (($option & self::GET) == self::GET):
                $sResult = (isset($_GET[$sParamName]) == TRUE) ? trim($_GET[$sParamName]) : NULL;
                break;
            case (($option & self::POST) == self::POST):
                $sResult = (isset($_POST[$sParamName]) == TRUE) ? trim($_POST[$sParamName]) : NULL;
                break;
            case (($option & self::NPOST) == self::NPOST):
                $sResult = (isset($_POST[$sParamName]) == TRUE) ? $_POST[$sParamName] : NULL;
                break;
            case (($option & self::FILES) == self::FILES):
                $sResult = (isset($_FILES[$sParamName]) == TRUE) ? trim($_FILES[$sParamName]) : NULL;
                break;
            case (($option & self::COOKIE) == self::COOKIE):
                $sResult = (isset($_COOKIE[$sParamName]) == TRUE) ? trim($_COOKIE[$sParamName]) : NULL;
                break;
            case (($option & self::SESSION) == self::SESSION):
                $sResult = (isset($_SESSION[$sParamName]) == TRUE) ? trim($_SESSION[$sParamName]) : NULL;
                break;
            case (($option & self::REQUEST) == self::REQUEST):
                $sResult = (isset($_REQUEST[$sParamName]) == TRUE) ? trim($_REQUEST[$sParamName]) : NULL;
                break;
            default:
                throw new Exception('Parameter type is invalid.');
        }

        if (empty($sResult) == TRUE) $sResult = NULL;

        if (($option & self::XSS_CLEAR) == self::XSS_CLEAR) {
            $sResult = self::clearXssString($sResult);
        }

        return $sResult;
    }

    /**
     * Set request value
     *
     * @param string $sParamName
     * @param mixed $mParamValue
     * @param mixed $option
     * @return mixed
     */
    public static function set($sParamName, $mParamValue, $option) {
        if (empty($option) == TRUE) throw new Exception('Parameter type is not defined.');

        if (($option & self::XSS_CLEAR) == self::XSS_CLEAR) {
            $mParamValue = self::clearXssString($mParamValue);
        }

        switch (TRUE) {
            case (($option & self::GET) == self::GET):
                $_GET[$sParamName] = $mParamValue;
                break;
            case (($option & self::POST) == self::POST):
                $_POST[$sParamName] = $mParamValue;
                break;
            case (($option & self::COOKIE) == self::COOKIE):
                setcookie($sParamName, $mParamValue, time()+(86400*7), '/');
                break;
            case (($option & self::SESSION) == self::SESSION):
                $_SESSION[$sParamName] = $mParamValue;
                break;
            default:
                throw new Exception('Parameter type is invalid.');
        }
    }

    /**
     * Clear XSS string
     *
     * @param mixed $variable
     * @return mixed
     */
    private static function clearXssString($mValue) {
        if (is_array($mValue) == TRUE) {
            $mValue = filter_var_array($mValue, FILTER_SANITIZE_STRING);
        } else {
            $mValue = filter_var($mValue, FILTER_SANITIZE_STRING);
        }

        return $mValue;
    }

}
?>