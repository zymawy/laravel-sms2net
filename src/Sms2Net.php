<?php namespace Zymawy\Sms2Net;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Str;
use Config;
use Zymawy\Sms2Net\Traits\HandleErrors;
use Zymawy\Sms2Net\Traits\Helpers;

class Sms2Net
{
    use HandleErrors, Helpers;

    protected $config;
    protected $client;
    protected $sendUrl = "https://www.net2sms.net/api/httpsend_utf8.asp?";
    protected $balanceUrl = "https://www.net2sms.net/api/getbalance.asp?";
    protected $senderUrl = "https://www.net2sms.net/api/GetSender.asp?";
    protected $tranUrl = "https://www.net2sms.net/api/querytran.asp?";
    protected $authUrl = "https://www.net2sms.net/api/authenticate.asp?";
    protected $accessLevelUrl = "https://www.net2sms.net/api/Getlevel.asp?";
    protected $groupsUrl = "https://www.net2sms.net/api/GetGroups.asp?";
    protected $groupOfMemberUrl = "https://www.net2sms.net/api/GetMembers.asp?";
    protected $phoneBookUrl = "https://www.net2sms.net/api/GetPhoneBook.asp?";
    protected $sendersUrl = "https://www.net2sms.net/api/GetSenders.asp?";
    protected $getMessagesUrl = "https://www.net2sms.net/api/getmessages.asp?";
    protected $contactUsUrl = "https://www.net2sms.net/api/SendEmail.asp?";


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
                'SMSTest' => $this->config['SMSTest'],
                'Unicode' => $this->config['Unicode'],
                'SMSDateTime' => $this->config['SMSDateTime'],
                'SMSGateway' => $this->config['SMSGateway'],
                'SmsRef' => $this->config['SmsRef'],
            ]
        ]);

        return $this->handleSendExceptions($response);
    }

    /**
     * Sending SMS Messages For One Number
     * Using GET Is Faster Then POST But Not Secure As Post,
     * @param $numbers
     * @param string $SMSData
     * @return Response
     */

    public function sendToOne($numbers, $SMSData)
    {

        $numbers = $this->checkNumbers($numbers);
        $this->config['SMSData'] = $SMSData;
        $this->config['phonenumbers'] = $numbers;

        $response = $this->client->request('GET', $this->sendUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
                'phonenumbers' => $this->config['phonenumbers'],
                'sender' => $this->config['sender'],
                'SMSData' => $this->config['SMSData'],
                'SMSTest' => $this->config['SMSTest'],
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
     * @return Response
     */
    public function geBalance()
    {
        $response = $this->client->request('GET', $this->balanceUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);

        return $this->handleGetBalanceExceptions($response);
    }

    /**
     * This will return a list of all groups for specific user in an XML format
     * @return XML
     */
    public function getGroups()
    {
        $response = $this->client->request('GET', $this->groupsUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);
        return $response->getBody();
    }

    /**
     *  This will return a list of all members for specific user and group in an XML format
     * @param $groupID int
     * @return XML
     */
    public function getOneGroup($groupID)
    {
        $response = $this->client->request('GET', $this->groupOfMemberUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
                'GroupID' => $groupID,
            ]
        ]);
        return $response->getBody();
    }

    /**
     * This will return a list of all groups & members for specific user and in an XML format
     *
     * @return XML
     */
    public function phoneBook()
    {
        $response = $this->client->request('GET', $this->phoneBookUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);
        return $response->getBody();
    }


    /**
     * This will return a list of all Senders for specific user in an XML format
     *
     * @return XML
     */
    public function sender()
    {
        $response = $this->client->request('GET', $this->sendersUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);
        return $response->getBody();
    }


    /**
     * This will return a list of all Senders for specific user in an XML format
     *
     * @return XML
     */
    public function getMessages()
    {
        $response = $this->client->request('GET', $this->getMessagesUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
            ]
        ]);
        return $response->getBody();
    }

    /**
     *This form to email web service to contact us
     * @param $email
     * @param $message
     * @return XML
     */
    public function contactUs($email, $message)
    {
        $response = $this->client->request('GET', $this->contactUsUrl, [
            'form_params' => [
                'userName' => $this->config['userName'],
                'password' => $this->config['password'],
                'Email' => $email,
                'Body' => $message
            ]
        ]);
        return $response->getBody();
    }
}
