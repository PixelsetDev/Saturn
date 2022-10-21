<?php

namespace Boa\Authentication;

use Boa\App;

/**
 * Boa JavaScript Web Token Library.
 *
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */
class JWT extends App
{
    /**
     * The super-secret key.
     *
     * @var string
     */
    private string $key;

    /**
     * The value of the 'iss' key.
     *
     * @var string
     */
    private string $issuer;

    /**
     * Stores the type of JWT to be created. Usually 'JWT'.
     *
     * @var string
     */
    private string $type;

    /**
     * Stores the algorithm to be used. Usually 'SHA-512'.
     *
     * @var string
     */
    private string $algorithm;

    /**
     * The UNIX timestamp for a start time for the token.
     *
     * @var string
     */
    private string $starttime;

    /**
     * Constructs the class.
     *
     * @param string $key       Your super-secret key.
     * @param string $issuer
     * @param string $type      The type of JWT (Optional - Doesn't change functionality)
     * @param string $algorithm The algorithm that will be used (Optional)
     * @param int    $starttime
     */
    public function __construct(
        string $key,
        string $issuer,
        string $type = 'JWT',
        string $algorithm = JWT_ALGORITHM,
        int $starttime = 0
    ) {
        parent::__construct();

        $this->key = $key;
        $this->issuer = $issuer;
        $this->type = $type;
        $this->algorithm = $algorithm;
        $this->starttime = $starttime;

        if ($starttime < time()) {
            $this->starttime = time();
        } else {
            $this->starttime = $starttime;
        }
    }

    /**
     * Generates a JWT.
     *
     * @param string $payload
     *
     * @return string
     */
    public function Generate(string $payload): string
    {
        $header = $this->GenerateHeader();
        $payload = $this->GeneratePayload($payload);
        $signature = $this->GenerateSignature($header, $payload);

        return $header.'.'.$payload.'.'.$signature;
    }

    /**
     * Generates the header part of the token.
     * Uses settings preset during construction.
     *
     * @return string
     */
    private function GenerateHeader(): string
    {
        $header = '{"alg": "'.$this->algorithm.'", "typ": "'.$this->type.'", "iat": "'.time().'", "nbf": "'.$this->starttime.'", "iss": "'.$this->issuer.'"}';

        return $this->EncodeData($header);
    }

    /**
     * Generates the payload part of the token.
     *
     * @param string $payload
     *
     * @return string
     */
    private function GeneratePayload(string $payload): string
    {
        return $this->EncodeData($payload);
    }

    /**
     * Generates the signature part of the token.
     *
     * @param string $EncodedHeader
     * @param string $EncodedPayload
     *
     * @return string
     */
    private function GenerateSignature(string $EncodedHeader, string $EncodedPayload): string
    {
        $algorithm = $this->GetAlgorithm();

        $data = $EncodedHeader.'.'.$EncodedPayload;
        $sig = hash_hmac($algorithm, $data, $this->key);
        var_dump($data, $sig);

        return $sig;
    }

    /**
     * Checks that the token is valid.
     *
     * @param string $token
     *
     * @return bool
     */
    public function Validate(string $token): bool
    {
        $algorithm = $this->GetAlgorithm();

        $Token = explode('.', $token);

        if (!array_keys($Token) == 3) {
            return false;
        }

        $Header = $Token[0];
        $Payload = $Token[1];

        $data = $Header.'.'.$Payload;

        if (hash_hmac($algorithm, $data, $this->key) === $Token[2]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetches the data within a token.
     *
     * @param string $token
     *
     * @return array
     */
    public function GetData(string $token): array
    {
        $Token = explode('.', $token);

        $Data[0] = $this->DecodeData($Token[0]);
        $Data[1] = $this->DecodeData($Token[1]);

        return $Data;
    }

    /**
     * Encode data to Base64URL.
     *
     * @param string $data
     *
     * @return bool|string
     */
    private function EncodeData(string $data): bool|string
    {
        $b64 = base64_encode(trim($data));
        if (!$b64) {
            return false;
        }
        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }

    /**
     * Decode data from Base64URL.
     *
     * @param string $data
     * @param bool   $strict
     *
     * @return bool|string
     */
    private function DecodeData(string $data, bool $strict = false): bool|string
    {
        $b64 = strtr($data, '-_', '+/');

        return base64_decode($b64, $strict);
    }

    /**
     * Returns the PHP equivalent to the algorithm.
     *
     * @return string
     */
    private function GetAlgorithm(): string
    {
        return match ($this->algorithm) {
            'HS256' => 'sha256',
            'HS384' => 'sha384',
            default => 'sha512'
        };
    }
}
