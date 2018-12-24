<?php
/**
 * Created by PhpStorm.
 * User: ironside
 * Date: 12/24/18
 * Time: 10:21 PM
 */

namespace Zymawy\Sms2Net\Traits;


trait HandleErrors
{

    protected  function handleSendExceptions($res)
    {
        $costed = $res->getBody();

        // Cast So We Can Grip It
        $contents = (string)$costed;

        $code = str_before($contents, ',');
        if ($code == 'Ok 000') {
            return response()->json([
                'msg' => trans('sms2net.000'),
                'code' => $code,
                'count_delivered_msg' => $this->getBetween($contents, '[', ']'),
                'full_massage' => $contents
            ], 200);

        } else if ($code == 'Err 010') {
            return response()->json([
                'msg' => trans('sms2net.010'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);
        } else if ($code == 'Err 011') {

            return response()->json([
                'msg' => trans('sms2net.011'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 012') {

            return response()->json([
                'msg' => trans('sms2net.012'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 020') {

            return response()->json([
                'msg' => trans('sms2net.020'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 030') {

            return response()->json([
                'msg' => trans('sms2net.030'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);


        } else if ($code == 'Err 040') {

            return response()->json([
                'msg' => trans('sms2net.040'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 045') {

            return response()->json([
                'msg' => trans('sms2net.045'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 050') {

            return response()->json([
                'msg' => trans('sms2net.050'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 060') {

            return response()->json([
                'msg' => trans('sms2net.060'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 070') {

            return response()->json([
                'msg' => trans('sms2net.070'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 075') {

            return response()->json([
                'msg' => trans('sms2net.075'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 076') {

            return response()->json([
                'msg' => trans('sms2net.076'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 080') {

            return response()->json([
                'msg' => trans('sms2net.080'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 090') {

            return response()->json([
                'msg' => trans('sms2net.090'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 091') {

            return response()->json([
                'msg' => trans('sms2net.091'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 092') {

            return response()->json([
                'msg' => trans('sms2net.092'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 095') {

            return response()->json([
                'msg' => trans('sms2net.095'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 096') {

            return response()->json([
                'msg' => trans('sms2net.096'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        } else if ($code == 'Err 099') {
            return response()->json([
                'msg' => trans('sms2net.099'),
                'code' => $code,
                'full_massage' => $contents
            ], 404);

        }
    }

    protected function handleGetBalanceExceptions($res)
    {
        $costed = $res->getBody();

        // Cast So We Can Grip It
        $contents = (string)$costed;


        if ($contents == starts_with($contents,'Credit'))
        {
            return response()->json([
                'msg' => trans('sms2net.credit'),
                'full_massage' => $contents,
                'points' => str_after($contents,"= ")
            ], 404);
        }


        return response()->json([
            'msg' => trans('sms2net.unknown'),
            'full_massage' => $contents
        ], 404);
    }


   protected function getBetween($content,$start,$end){
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
}