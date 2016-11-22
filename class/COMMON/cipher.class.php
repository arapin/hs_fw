<?php
/**
 * Cipher Class (PHP 5 Only!)
 * 암호화 클래스입니다
 *
 * 파일명, 클래스명은 팀에 따라 수정해 사용해주세요
 * 클래스 내의 24 Line의 $iv값은 팀에 따라 수정해 사용해주세요
 * 아닐 시에, setVectorKey('16Bytes String') method로 외부에서 키를 지정할 수도 있습니다
 *
 * 사용법은 아래 @example 섹션과 같습니다
 *
 * @example
 *     $oCipher = new Cipher('testPrivateKey');              // 암호화 할 키값
 *     $enc = $oCipher -> getEncrypt("cafe24@simplexi.com"); // 암호화 할 content
 *     $dec = $oCipher -> getDecrypt($enc);                  // 디코딩 할 content
 *
 *     echo '<br />enc : '.$enc;
 *     echo "<br />dec : ".$dec;
 */
class Cipher {


    // 전역변수 설정
    private $iv = '_hsjung_ssg_com_'; // 이 벡터값은 16자리 고정이어야 동작합니다 수정해서 사용하세요
    private $sPrivateKey;             // 암호화에 사용될 키값

    /**
     * construct method
     * 클래스 생성과 동시에 암호화 키 값을 입력받아 설정합니다
     * @access public
     *
     * @param  $sPrivateKey {String} 암호화 키값
     * @return NULL
     */
    public function __construct($sPrivateKey) {
        $this -> setPrivateKey($sPrivateKey);
    }


    /**
     * setPrivateKey
     * 암호화에 사용할 키를 생성합니다
     * @access public
     *
     * @param  $sKey {String} 암호화 할 키값
     * @return NULL
     */
    public function setPrivateKey($sKey) {
        $this->sPrivateKey = $sKey;
    }


    /**
     * setVectorKey
     * 벡터 키를 초기화합니다
     * 입력받은 값이 16글자보다 작으면, 기본 클래스 내에 설정되어 있는 값으로
     * 사용되고, 16글자인 경우에는 벡터값을 갱신합니다.
     * @access public
     *
     * @param  $sIv {String} 설정할 벡터값
     * @return NULL
     */
    public function setVectorKey($sIv) {
        $this->iv = 
            (strlen($sIv) === 16) 
                ? $sIv 
                : $this->iv;
    }


    /**
     * getPrivateKey
     * 암호화에 사용되는 현재 설정된 키값을 반환합니다
     * @access public
     *
     * @return {String} 암호화 할 키값
     */
    public function getPrviatekey() {
        return $this->sPrivateKey;
    }


    /**
     * getVectorKey
     * 암호화에 사용되는 현재 설정된 벡터값을 반환합니다
     * @access public
     *
     * @return {String} 벡터값
     */
    public function getVectorKey() {
        return $this->iv;
    }


    /**
     * getEncrypt
     * 일반 평문을 받아 암호화된 값으로 반환해줍니다
     * @access public
     *
     * @param  $sText {String} 일반 평문 content
     * @return        {String} 암호화 된 content
     */
    public function getEncrypt($sText) {
        return $this -> doEncryptData($sText);
    }


    /**
     * getDecrypt
     * 암호화 처리 된 값을 받아 복호화된 값으로 반환해줍니다
     * @access public
     *
     * @param  $sEncText {String} 암호화 된 content
     * @return           {String} 복호화 된 content
     */
    public function getDecrypt($sEncText) {
        return $this -> doDecryptData($sEncText);
    }


    /**
     * doEncryptData
     * 일반 평문을 받아 암호화된 값으로 반환해줍니다
     * @access private
     *
     * @param  $sText {String} 일반 평문 content
     * @return        {String} 암호화 된 content
     */
    private function doEncryptData($sText) {
        return
            bin2hex(
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_128,
                    $this->sPrivateKey,
                    $sText,
                    MCRYPT_MODE_CBC,
                    $this->iv
                )
            );
    }


    /**
     * doDecryptData
     * 암호화 처리 된 값을 받아 복호화된 값으로 반환해줍니다
     * @access private
     *
     * @param  $sEncText {String} 암호화 된 content
     * @return           {String} 복호화 된 content
     */
    private function doDecryptData($sEncText) {
        return
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                $this->sPrivateKey,
                pack("H*", $sEncText),
                MCRYPT_MODE_CBC,
                $this->iv
            );
    }


} // end class


//EOF
?>