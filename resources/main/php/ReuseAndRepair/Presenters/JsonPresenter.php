<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:47 PM
 */

namespace ReuseAndRepair\Presenters;


class JsonPresenter implements Presenter {

    public function presentResponse(array $response) {
        header("content-type:application/json");
        echo json_encode($response);
    }

    public function presentException(\Exception $e) {

        $response = array(
            'success' => false,
            'exceptions' => array()
        );

        do {
            $curException = array(
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            );
            array_push($response['exceptions'], $curException);
        } while (($e = $e->getPrevious()) != null);

        $this->presentResponse($response);
    }
}