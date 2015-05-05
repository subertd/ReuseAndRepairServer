<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:47 PM
 */

namespace ReuseAndRepair\Presenters;


class JsonResponsePresenter implements Presenter {

    public function present(array $response) {
        header("content-type:application/json");
        echo json_encode($response);
    }
}