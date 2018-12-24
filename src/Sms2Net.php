<?php namespace Zymawy\Sms2Net;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Str;
use Config;
use Zymawy\Sms2Net\Traits\HandleErrors;

class Sms2Net
{
    use HandleErrors;
    protected $config;
    protected $client;
    protected $sendUrl = "https://www.net2sms.net/api/httpsend_utf8.asp?";
    protected $balanceUrl = "https://www.net2sms.net/api/getbalance.asp?";


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
    public function checkNumbers($numbers)
    {
        if (!is_array($numbers))
            return $this->parseNumber($numbers);
        $numbers_array = array();
        foreach ($numbers as $number) {
            $checkedNumber = $this->checkNumbers($number);
            array_push($numbers_array, $checkedNumber);
        }
        return implode(',', $numbers_array);
    }

    public function parseNumber($number)
    {
        if (strlen($number) == 10 && starts_with($number, '05'))
            return preg_replace('/^0/', '966', $number);
        elseif (starts_with($number, '00'))
            return preg_replace('/^00/', '', $number);
        elseif (starts_with($number, '+'))
            return preg_replace('/^+/', '', $number);
        return $number;
    }

    public function parseNumbersIfString($collectsNumbers)
    {

        $numbers = "";
        //$invalidNumbers = "";
        //$totalInvalidNumbers = 0;

        $totleNumbers = count($collectsNumbers);

        $i = 0;

        foreach ($collectsNumbers as $key => $number) {


            if (strlen($number) > 9 OR strlen($number) < 9 OR $number == "") {
                // Count How Many Invalid Numbers
                //$totalInvalidNumbers++;
                continue;
            }
            $numbers .= "966" . "$number";
            // If It's The Last Item On The Array Do Not Concatenate The SamaColen
            if (++$i !== $totleNumbers) {
                $numbers .= ",";
            }

        }
        // Check Again If The String Numbers Has Comma If So Remove It.
        if (str_finish($numbers, ',')) {
            $numbers = substr($numbers, 0, -1);
        }

        return $numbers;
    }

    public function withCount($text)
        {
            $length = mb_strlen($text);
            if ($length <= 70)
                return 1;
            else
                return ceil($length / 67);
        }
}
