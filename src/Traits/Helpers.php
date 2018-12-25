<?php
/**
 * Created by PhpStorm.
 * User: ironside
 * Date: 12/25/18
 * Time: 2:59 AM
 */

namespace Zymawy\Sms2Net\Traits;


trait Helpers
{


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