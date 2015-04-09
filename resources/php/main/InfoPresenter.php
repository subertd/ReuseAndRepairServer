<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/7/2015
 * Time: 4:33 PM
 */

namespace ReuseAndRepair\Info;


class InfoPresenter {

    /**
     * present
     *
     * generates and sends an http response
     *
     * @param int $what what info is to be displayed;
     * default = INFO_ALL
     */
    public function present($what = INFO_ALL)
    {
        header("Content-type: text/html");
        phpInfo($what);
    }
}