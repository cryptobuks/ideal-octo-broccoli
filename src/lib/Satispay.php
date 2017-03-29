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
     * properties
     */
    private $properties = array();

    /*
     * cURL request handler
     */
    private $curl_handler = null;

    /*
     * URL to satispay sandbox
     */
    const SATISPAY_SANDBOX = "https://staging.authservices.satispay.com/online/";

    /*
     * Mandatory request params
     */
    private $mandatoryRequestData = array(
        'v1/users'      => array('phone_number'),
        'v1/charges'    => array('user_id', 'currency', 'amount')
    );

    /*
     * Non-mandatory request params
     */
    private $nonMandatoryRequestData = array(
        'v1/charges'    => array('description', 'metadata', 'expire_in', 'callback_url')
    );

    /*
     * class constructor
     */
    function __construct($method, $url, $body = null)
    {

        $this->setProperties();

        $this->curl_handler = curl_init();
        curl_setopt($this->curl_handler, CURLOPT_URL, self::SATISPAY_SANDBOX . $url);
        curl_setopt($this->curl_handler, CURLINFO_HEADER_OUT, 0);
        //all request should have this header
        curl_setopt($this->curl_handler, CURLOPT_HTTPHEADER, array('Accept:application/json'));

        if($method == 'POST'){
            curl_setopt($this->curl_handler, CURLINFO_CONTENT_TYPE, 'application/json');
            curl_setopt($this->curl_handler, CURLOPT_POSTFIELDS, $this->setRequestBody($url, $body));
        }

    }

    private function setProperties(){

        $properties = parse_ini_file('props.ini', true);

        if($properties){
            $this->properties = $properties;
        }
    }

    private function setRequestBody($request, $data){

        $mandatoryFields = $this->mandatoryRequestData[$request];

        $body = array();

        foreach ($mandatoryFields as $mandatoryField) {
            $body[$mandatoryField] = $data[$mandatoryField];
        }

        return json_encode($body);

    }

    public function exec(){

        $result = null;

        try{

            $result = curl_exec($this->curl_handler);

            if($result){
                return $result;
            }

        } catch (\Exception $e){

            $result = new \stdClass();

            $result->err_number = curl_errno($this->curl_handler);
            $result->err_message = curl_error($this->curl_handler);

        }

        return $result;

    }

}