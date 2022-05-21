<?php

function checkOutput($mode, $data)
{
    return stripslashes(checkInput($mode, $data));
}
