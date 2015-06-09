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

        $utf8Response = $this->utf8ize($response);

        header("content-type:application/json");
        echo json_encode($utf8Response);
    }

    /**
     * Recursively changed the encoding of all string proerties and sub-properties
     * to utf8
     *
     * @citation the following method uses code from this forum thread
     * http://stackoverflow.com/questions/19361282/why-would-json-encode-returns-an-empty-string
     */
    private function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
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
