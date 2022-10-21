<?php

namespace SaturnServer\Status;

use Boa\Database\SQL;

class Status
{
    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @return mixed
     */
    public function Status()
    {
        $SQL = new SQL();

        if ($SQL != null) {
            $jsonArray['status'] = '200';
            $jsonArray['response'] = 'OK';
            echo json_encode($jsonArray);
        } else {
            exit;
        }
    }
}
