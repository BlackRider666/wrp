<?php


namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class IboxClient
{
    /**
     * @var string
     */
    private $publicKey;

    private $privateKey;

    private $passphrase;

    public function __construct()
    {
        $this->publicKey = Storage::disk('local')->get('key.pub');
        $this->privateKey = Storage::disk('local')->get('key');
        $this->passphrase = env('IBOX_PASSPHRASE');
    }

    /**
     * розшифровка ответа
     * @param string $info
     * @param string $encryptedKey
     * @return string
     * @desc дешифрует $info и возвращает структуру «Info» конкретного метода в виде JSON-
     * строки. В случае ошибки генерирует исключение
     */
    public function getDecryptedInfo(string $info, string $encryptedKey): string
    {
        $cipher = 'aes-256-ctr';
        $privateKey = openssl_pkey_get_private($this->privateKey, $this->passphrase);
        if (!$privateKey) {
            throw new RuntimeException('Private key error!');
        }
        if (!openssl_private_decrypt(base64_decode($encryptedKey), $decrypted
            , $privateKey)) {
            throw new RuntimeException('Decrypted error!');
        }
        $key = json_decode($decrypted, true);
        if (empty($key) || !isset($key['key'], $key['iv']) || empty($key['key']) || empty($key['iv'])) {
            throw new RuntimeException('Empty key or iv!');
        }
        $result = openssl_decrypt($info, $cipher, base64_decode($key['key']), 0,
            base64_decode($key['iv']));

        return $result;
    }

    /**
     * @param string $info
     * @param $sign
     * @return string
     * @desc проверяет соответствие сообщения $info и подписи $sign, декодированной из
     * BASE64. В случае ошибки генерирует исключение
     */
    public function verifySignInfo(string $info, $sign)
    {
        $publicKey = openssl_get_publickey($this->publicKey);
        if (!$publicKey) {
            throw new RuntimeException('Public key error!');
        }
        $signature = base64_decode($sign);
        if (!openssl_verify($info, $signature, $publicKey, 'sha256WithRSAEncryption')) {
            throw new RuntimeException('Sign error!');
        }

        return true;
    }

    /**
     * @param string $data
     * @return string
     * @desc подписывает $data и возвращает цифровую подпись в виде BASE64 строки. В
     * случае ошибки генерирует исключение
     */
    public function getSignData(string $data): string
    {
        $privateKey = openssl_pkey_get_private($this->privateKey, $this->passphrase);
        if(!$privateKey) {
            throw new RuntimeException('Private key error!');
        }
        if(!openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Sign error!');
        }
        return base64_encode($signature);
    }

    /**
     * отправка запроса
     * @param string $data
     * @return array
     * @desc шифрует $data и возвращает зашифрованные данные в виде BASE64 строки. В
     * случае ошибки генерирует исключение
     */
    public function getEncryptedData(string $data): array
    {
        $cipher = 'aes-256-ctr';
        if (!in_array($cipher, openssl_get_cipher_methods())) {
            throw new RuntimeException('Wrong cipher!');
        }
        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivLen);
        $encryptKey = openssl_random_pseudo_bytes(64);
        $key = json_encode([
            'iv' => base64_encode($iv),
            'key' => base64_encode($encryptKey)
        ]);
        $publicKey = openssl_get_publickey($this->publicKey);
        if(!$publicKey) {
        throw new RuntimeException('Public key error!');
        }
        if(!openssl_public_encrypt($key, $encrypted, $publicKey)) {
            throw new RuntimeException('Encryption error!');
        }
        $result = [
            'info' => openssl_encrypt($data, $cipher, $encryptKey, 0, $iv),
            'key' => base64_encode($encrypted)
        ];
        return $result;
    }

    public function test()
    {
        $requestData = json_encode([
            'card' => [
                'number' => '5375414116329060',
                'expire_month' => '08',
                'expire_year'  => '24',
                'cvv'          => '052',
            ],
            'amount'    => 20,
            'currency'  => 'UAH',
            'comment'   => 'test',
            'order_id'      =>  '123',
            'result_url'    =>  env('APP_URL').'/api/test-result',
        ]);
        $encryptedData = $this->getEncryptedData($requestData);
        $method = 'debit';
        $info = $encryptedData['info'];
        $key = $encryptedData['key'];
        $sign = $this->getSignData($requestData);
        $client = new Client();
        $body = json_encode([
            'merchant_point_id' =>  env('IBOX_MERCHANT_POINT_ID'),
            'method'            =>  $method,
            'info'              =>  $info,
            'key'               =>  $key,
            'sign'              =>  $sign,
            'lang'              => env('IBOX_LANG'),
        ]);
        try {
            $response = $client->request('POST',env('IBOX_URL'),['body' => $body]);
            $resData = json_decode($response->getBody()->getContents());
            $data = $this->getDecryptedInfo($resData->info, $resData->key);
            $verif = $this->verifySignInfo($data,$resData->sign);
            if ($verif) {
                dd(json_decode($data));
            }
        } catch (GuzzleException $e) {
            dd($e);
        }
    }
    public function testResult($data)
    {
        Log::info($data);
    }
}
