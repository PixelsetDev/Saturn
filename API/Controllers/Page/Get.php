<?php

namespace SaturnServer\Page;

use Boa\Database\SQL;

class Get
{

    private $List = array();

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
    public function List() {
        $SQL = new SQL();

        $PageList = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`parent` IS NULL', 'ALL:ASSOC');
        foreach ($PageList as $Item) {
            $this->List[] = $Item;
            $this->GetChildPages($Item['id']);
        }

        return $this->List;
    }

    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @return void
     */
    private function GetChildPages($ID): void {
        $SQL = new SQL();

        $ChildList = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`parent` = \''.$ID.'\'', 'ALL:ASSOC');
        if ($ChildList != null) {
            foreach ($ChildList as $Child) {
                $this->List[] = $Child;
                $this->GetChildPages($Child['id']);
            }
        }
    }
}