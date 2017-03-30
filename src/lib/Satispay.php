<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/03/2017
 * Time: 15:14
 * Satispay online API wrapper
 */

namespace satispay;


class Satispay
{

    /*
     * cURL headers
     */
    private $headers = array();

    /*
     * properties
     */
    private $properties = array();

    /*
     * url and action
     */
    private $url = "";
    private $action = "";

    /*
     * cURL request handler
     */
    private $curl_handler = null;

    /*
     * URL to satispay sandbox
     */
    //const SATISPAY_SANDBOX = "https://staging.authservices.satispay.com/online/v1/";

    /*
     * .ini file name
     */
    const INI_FILE_NAME = 'props.ini';

    /*
     * Mandatory request params
     */
    private $mandatoryRequestData = array(
        'users'      => array(
            'create'    => array('phone_number'),
            'get'       => 'id'
            ),
        'charges'    => array('user_id', 'currency', 'amount'),
        'refund'     => array('charge_id', 'currency', 'amount')
    );

    /*
     * optional request params
     */
    private $nonMandatoryRequestData = array(
        'users'     => array(
            'list'      => array('starting_after', 'ending_before', 'limit')
        ),
        'charges'    => array('description', 'metadata', 'expire_in', 'callback_url')
    );

    /*
     * class constructor
     */
    function __construct($method, $url, $body = null)
    {

        //set private properties
        $this->setProperties();

        //set url and action
        $this->setUrlAndAction($url);

        //init cURL handler
        $this->curl_handler = curl_init();

        //headers options (to avoid overwriting)
        $this->headers = array(
            //all request should have this header
            'Accept:application/json',
            'Authorization:Bearer ' . $this->properties['security-bearer']
            );

        //avoid SSL check - comment for production
        curl_setopt($this->curl_handler, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl_handler, CURLOPT_SSL_VERIFYPEER, 0);

        //get request params
        $params = $this->getRequestParams($body);

        //set headers/method/params
        $this->setRequestData($method, $params);

    }

    private function setRequestData($method, $data){

        if($method == 'POST') {

            //just for POST request
            $this->headers[] = "Content-type:application/json";
            curl_setopt($this->curl_handler, CURLOPT_POST, 1);
            curl_setopt($this->curl_handler, CURLOPT_POSTFIELDS, json_encode($data));

        } else {
            $query = ($this->action == 'get') ? "/" . urlencode($data) : "?" . http_build_query($data);
            $this->url .= $query;
        }

        curl_setopt($this->curl_handler, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl_handler, CURLOPT_URL, $this->properties['sandbox_url'] . $this->url);

    }

    //parse ini file and set properties
    private function setProperties(){

        $properties = null;

        try{
            $properties = parse_ini_file(self::INI_FILE_NAME, true);
        } catch (\Exception $ex){
            return false;
        }


        if($properties && (count($properties) > 0)){
            $this->properties = $properties;
        }
    }

    /**
     * @param $url
     */
    private function setUrlAndAction($url){

        $options = explode("/", $url);

        $this->url = $options[0];
        $this->action = $options[1];

    }

    /**
     * @param $data
     * @return array
     */
    private function getRequestParams($data){

        $body = array();

        //get data map for mandatory fields
        if(array_key_exists($this->action, $this->mandatoryRequestData[$this->url])){ //check for key in multidimensional array
            $mandatoryFields = $this->mandatoryRequestData[$this->url][$this->action];

            if($mandatoryFields){

                if(is_array($mandatoryFields)){
                    foreach ($mandatoryFields as $mandatoryField) {
                        $body[$mandatoryField] = $data[$mandatoryField];
                    }
                } else {
                    $body = $data[$mandatoryFields];
                }
            }
        }

        //get data map for optional fields
        if(array_key_exists($this->action, $this->nonMandatoryRequestData[$this->url])){
            $optionalFields = $this->nonMandatoryRequestData[$this->url][$this->action];
            foreach ($optionalFields as $optionalField) {
                //optional, only if provided
                if(array_key_exists($optionalField, $data) && $data[$optionalField] != ""){
                    $body[$optionalField] = $data[$optionalField];
                }
            }
        }

        return $body;

    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function exec(){

        $result = curl_exec($this->curl_handler);

        if(FALSE == $result){
            throw new \Exception(curl_errno($this->curl_handler) . " - " . curl_error($this->curl_handler));
        }

        return $result;

    }

}

class UserRequest{

    public static function create($route, $body = null){
        //is a POST request
        return new Satispay('POST', $route, $body);
    }

    public static function getList($body = null){
        //GET request
        return new Satispay('GET', 'users/list', $body);
    }

    public static function getUser($body){
        //GET request
        return new Satispay('GET', 'users/get', $body);
    }

}

class Request{

    public static function create($method, $route, $body = null){
        //is a POST request
        return new Satispay($method, $route, $body);
    }

}

class ChargeRequest{

    public static function create($body = null){
        return new Satispay('POST', 'charges/create');
    }
    
    public static function getCharge($body = null){
        return new Satispay('GET', 'charges/get');
    }

}
