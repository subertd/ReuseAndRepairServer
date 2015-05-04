<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:31 PM
 */

namespace ReuseAndRepair\Presenters;


class JsonSyncResponsePresenter implements Presenter {

    /**
     * Present the response to the client as application JSON
     *
     * @param array $response the response to send as JSON
     */
    public function present($response) {
        header("content-type:application/json");
        echo json_encode($response);
    }
}