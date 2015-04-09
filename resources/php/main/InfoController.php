<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 4/9/2015
 * Time: 12:17 PM
 */

namespace ReuseAndRepair\Info;

//use ReuseAndRepair\Info\InfoService;
//use ReuseAndRepair\Info\InfoPresenter;

class InfoController {

    public function getInfo() {

        // Use a service to handle business logic
        $infoService = new InfoService();
        $what = $infoService->getWhat($_GET);

        // Use a presenter to construct the http response
        $infoPresenter = new InfoPresenter();
        $infoPresenter->present($what);
    }
}