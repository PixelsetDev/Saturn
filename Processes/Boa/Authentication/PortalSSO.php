<?php

/**
 * Boa Portal SSO Library
 * @author      LMWN <contact@lmwn.co.uk>
 * @license     Apache-2.0 License
 */

namespace Boa\Authentication;

use Boa\App;

class PortalSSO extends App
{
    public array $settings;

    public function __construct() {
        parent::__construct();

        $this->settings = array(
            'portal_redirect_url' => 'https://localhost/account/login',
            'portal_permissions' => '110100000000011',
            'portal_secret' => 'LMWN_PORTAL_USER'
        );
    }

    /**
     * @return bool Returns true/false, the status of the login.
     */
    public function Login(): bool
    {
        $token = $_GET['token'];
        $sig = $_GET['sig'];
        if(!empty($token) && !$_SESSION['token'])
        {
            $algorithm = file_get_contents('https://portal.lmwn.co.uk/assets/common/ptkhash.txt');
            if (hash_equals(hash_hmac($algorithm, $token, $this->settings['portal_secret']), $sig)) {
                $_SESSION['token'] = $token;
                return true;
            } else {
                header('Location: https://portal.lmwn.co.uk/authenticate/?redirect_url='.$this->settings['portal_redirect_url'].'&permissions='.$this->settings['portal_permissions']);
                return false;
            }
        } else {
            header('Location: https://portal.lmwn.co.uk/authenticate/?redirect_url='.$this->settings['portal_redirect_url'].'&permissions='.$this->settings['portal_permissions']);
            return false;
        }
    }

    /**
     * @return bool|string Returns false or the user's information.
     */
    public function Authenticate(): bool|string
    {
        if($_SESSION['token']) {
            $url = "https://portal.lmwn.co.uk/authenticate/authservice.php?token=".$_SESSION['token'];

            $response = json_decode($this->RequestData($url));
            $user = $response->data;

            if ($response->code != 200) {
                unset($_SESSION['token']);
                return false;
            } else {
                return $user;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $url "The URL data should be requested from."
     * @param string $method "The method that should be used. Default: 'GET'"
     * @param $postdata "The post data that should be used. Default: null"
     * @return bool|string "Returns false or the data response."
     */
    private function RequestData($url, string $method = "GET", $postdata = null): bool|string
    {
        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
        );

        if ($method == "POST") {
            curl_setopt_array($ch, array(
                CURLOPT_POST  => 1,
                CURLOPT_HTTPHEADER  => $headers,
                CURLOPT_POSTFIELDS  => $postdata,
                CURLOPT_RETURNTRANSFER  =>true,
                CURLOPT_VERBOSE     => 1
            ));
        }else{
            curl_setopt_array($ch, array(
                CURLOPT_HTTPGET  => 1,
                CURLOPT_HTTPHEADER  => $headers,
                CURLOPT_RETURNTRANSFER  =>true,
                CURLOPT_VERBOSE     => 1
            ));
        }

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}