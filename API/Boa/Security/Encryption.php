<?php

/**
 * Boa Encryption Library
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

namespace Boa\Security;

use Boa\App;

class Encryption extends App
{
    public array $settings;

    public function __construct()
    {
        parent::__construct();

        $this->settings = array(
            'password_hash' => SECURITY_PASSWORD_HASH,
            'ip_hash' => SECURITY_IP_HASH,
            'other_hash' => SECURITY_OTHER_HASH,
        );
    }

    public function hash_ip($ip): string
    {
        return hash($this->settings['ip_hash'], $ip);
    }

    public function hash($data): string
    {
        return hash($this->settings['other_hash'], $data);
    }

    public function hash_password($password): string
    {
        return password_hash($password,$this->settings['password_hash']);
    }

    public function verify_password($password): bool
    {
        return password_verify($password,$this->settings['password_hash']);
    }
}
