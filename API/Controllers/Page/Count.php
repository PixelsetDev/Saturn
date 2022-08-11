<?php

namespace SaturnServer\Page;

use Boa\Database\SQL;

class Count
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
    public function CountTotalPages() {
        $SQL = new SQL();

        return $SQL->Select('*', DATABASE_PREFIX.'Pages', '1', 'NUMROWS');
    }
}