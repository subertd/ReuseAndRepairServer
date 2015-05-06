<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:31 PM
 */

namespace ReuseAndRepair\Presenters;


interface Presenter {

    public function presentResponse(array $response);

    public function presentException(\Exception $e);
}