<?php

namespace SaturnServer\Article;

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
    public function CountTotalArticles()
    {
        $SQL = new SQL();

        return $SQL->Select('*', DATABASE_PREFIX.'Articles', '1', 'NUMROWS');
    }
}
