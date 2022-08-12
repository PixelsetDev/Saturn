<?php

namespace Saturn\ClientKit;

class SecureArea
{
    public function __construct()
    {
        if (!isset($_SESSION['token'])) {
            header('Location: /account');
        }
    }
}
