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
        'charges'    => array(
            'create'    => array('user_id', 'currency', 'amount'),
            'get'       => 'id'
        ),
        //needs testing
        'refund'     => array(
            'create'    => array('charge_id', 'currency', 'amount'),
            'get'       => 'id'
        )
    );

    /*
     * optional request params
     */
    private $nonMandatoryRequestData = array(
        'users'     => array(
            'list'      => array('starting_after', 'ending_before', 'limit')
        ),
        'charges'    => array(
            'list'      => array('starting_after', 'ending_before', 'limit', 'starting_after_timestamp')
        )
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

    /**
     * @param $method
     * @param $data
     */
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
        if(array_key_exists($this->action, $this->mandatoryRequestData[$this->url])){
            //check for key in multidimensional array
            $mandatoryFields = $this->mandatoryRequestData[$this->url][$this->action];

            if($mandatoryFields){

                if(is_array($mandatoryFields)){
                    foreach ($mandatoryFields as $mandatoryField) {
                        //some fields needs to be modified
                        $field = $this->checkField($mandatoryField, $data[$mandatoryField]);
                        $body[$mandatoryField] = $field;
                    }
                } else {
                    
                    if($data[$mandatoryFields] != ""){
                        $body = $data[$mandatoryFields];
                    }
                }
            }
        }

        //get data map for optional fields
        if(array_key_exists($this->action, $this->nonMandatoryRequestData[$this->url])){
            $optionalFields = $this->nonMandatoryRequestData[$this->url][$this->action];
            foreach ($optionalFields as $optionalField) {
                //optional, set only if provided
                if(array_key_exists($optionalField, $data) && $data[$optionalField] != ""){
                    $body[$optionalField] = $data[$optionalField];
                }
            }
        }

        return $body;

    }

    private function checkField($field, $value){

        $returnValue = $value;

        //amount needs to be modified
        if($field == 'amount'){
            $returnValue = $value * 100;
        }

        if($field == 'starting_after_timestamp'){
            //convert to timestamp
        }

        return $returnValue;

    }

}

class Request{

    public static function create($method, $route, $body = null){
        //get instance of Satispay Wrapper "Factory"
        return new Satispay($method, $route, $body);
    }

}
