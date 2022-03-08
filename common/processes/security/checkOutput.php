<?php

function checkOutput($mode, $data): string
{
    return stripslashes(checkInput($mode, $data));
}
