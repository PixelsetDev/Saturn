<?php

namespace SaturnServer\Page;

use Boa\Database\SQL;

class Get
{
    private array $List = [];

    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @return array
     */
    public function List(): array
    {
        $SQL = new SQL();

        $PageList = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`slug` IS NULL', 'ALL:ASSOC', 'title');
        $this->List[] = $PageList[0];
        $this->ListChildPages($PageList[0]['id'], 1);
        $this->ListPages();

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
     * @return array
     */
    public function ListPages(): array
    {
        $SQL = new SQL();

        $PageList = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`parent` IS NULL AND `slug` IS NOT NULL', 'ALL:ASSOC', 'title');
        foreach ($PageList as $Item) {
            $Item['parentcount'] = 0;
            if ($this->IsParent($Item['id'])) {
                $Item['isparent'] = true;
                $this->List[] = $Item;
                $this->ListChildPages($Item['id'], 1);
            } else {
                $Item['isparent'] = false;
                $this->List[] = $Item;
            }
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
     * @param $ID
     *
     * @return void
     */
    private function ListChildPages($ID, $Parents): bool
    {
        $SQL = new SQL();

        $ChildList = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`parent` = \''.$ID.'\'', 'ALL:ASSOC', 'title');

        if ($ChildList != null) {
            foreach ($ChildList as $Child) {
                $Child['parentcount'] = $Parents;
                if ($this->IsParent($Child['id'])) {
                    $Child['isparent'] = true;
                    $this->List[] = $Child;
                    $this->ListChildPages($Child['id'], $Parents + 1);
                } else {
                    $Child['isparent'] = false;
                    $this->List[] = $Child;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @author      Lewis Milburn <lewis.milburn@lmwn.co.uk>
     * @license     Apache 2.0
     *
     * @since       1.0.0
     *
     * @version     1.0.0
     *
     * @param $ID
     *
     * @return void
     */
    private function IsParent($ID): bool
    {
        $SQL = new SQL();

        $IsParent = $SQL->Select('*', $SQL->Escape(DATABASE_PREFIX).'Pages', '`parent` = \''.$ID.'\'', 'NUM_ROWS');

        if ($IsParent == 0) {
            return false;
        } else {
            return true;
        }
    }
}
