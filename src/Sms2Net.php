<?php namespace Zymawy\Sms2Net;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Str;
use Config;
use Zymawy\Sms2Net\Traits\HandleErrors;
use Zymawy\Sms2Net\Traits\Helpers;

class Sms2Net
{
    use HandleErrors,Helpers;

    protected $config;
    protected $client;
    protected $sendUrl = "https://www.net2sms.net/api/httpsend_utf8.asp?";
    protected $balanceUrl = "https://www.net2sms.net/api/getbalance.asp?";
    protected $senderUrl = "https://www.net2sms.net/api/GetSender.asp?";
    protected $tranUrl = "https://www.net2sms.net/api/querytran.asp?";
    protected $authUrl = "https://www.net2sms.net/api/authenticate.asp?";
    protected $accessLevelUrl = "https://www.net2sms.net/api/Getlevel.asp?";


    public function __construct($config = array())
    {
        $this->config = (class_exists("Config") ? Config::get('sms2net') : []);
        $this->client = new Client();

    }

    /**
     * Sending SMS Messages For  More Than One Number
     *
     * @param $numbers
     * @param string $SMSData
     * @return array
     */
    public function sendToMany($numbers, $SMSData)
    {

        $numbers = $this->checkNumbers($numbers);
        $this->config['SMSData'] = $SMSData;
        $this->config['phonenumbers'] = $numbers;

        $response = $this->client->request('POST', $this->sendUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
                'phonenumbers' => $this->config['phonenumbers'],
                'sender' => $this->config['sender'],
                'SMSData' => $this->config['SMSData'],
                'SMSTest' =>  $this->config['SMSTest'],
                'Unicode' => $this->config['Unicode'],
                'SMSDateTime' => $this->config['SMSDateTime'],
                'SMSGateway' => $this->config['SMSGateway'],
                'SmsRef' => $this->config['SmsRef'],
                ]
        ]);

    return $this->handleSendExceptions($response);
    }

/*
 * This will return the number of credits available on this particular account. The account balance is returned
 *  as a floating point value.
 */

    public function geBalance()
    {
        $response = $this->client->request('GET',$this->balanceUrl,[
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);

      return  $this->handleGetBalanceExceptions($response);
    }


}
