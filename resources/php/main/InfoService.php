<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/9/2015
 * Time: 12:17 PM
 */

namespace ReuseAndRepair\Info;


class InfoService {

    const WHAT = "what";

    /**
     * getWhat
     *
     * parses the http parameters and returns the integer value for
     * what info is desired, if it exists
     *
     * @param array $params the http request parameters
     * @return int what info is desired; default = INFO_ALL
     */
    public function getWhat($params)
    {
        $what = INFO_ALL;

        /* If parameter 'what':
         * has a value,
         * is numeric,
         * and is an integer
        */
        if (!empty($params[InfoService::WHAT])
            && is_numeric($params[InfoService::WHAT])
            && floor((float)$params[InfoService::WHAT]) == (float)$params[InfoService::WHAT]
        )
        {
            $what = (int)$params[InfoService::WHAT];
        }

        return $what;
    }
}