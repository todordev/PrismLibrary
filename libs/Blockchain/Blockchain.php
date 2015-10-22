<?php
/*
    Blockchain PHP API
    https://github.com/blockchain/api-v1-client-php/
*/

require_once(__DIR__.'/Blockchain/Exceptions.php');

// Check if BCMath module installed
if(!function_exists('bcscale')) {
    throw new Blockchain_Error("BC Math module not installed.");
}

// Check if curl module installed
if(!function_exists('curl_init')) {
    throw new Blockchain_Error("cURL module not installed.");
}

require_once(__DIR__.'/Blockchain/Create.php');
require_once(__DIR__.'/Blockchain/Explorer.php');
require_once(__DIR__.'/Blockchain/PushTX.php');
require_once(__DIR__.'/Blockchain/Rates.php');
require_once(__DIR__.'/Blockchain/Receive.php');
require_once(__DIR__.'/Blockchain/Stats.php');
require_once(__DIR__.'/Blockchain/Wallet.php');

class Blockchain {
	const URL = 'https://blockchain.info/';


	private $ch;
	private $api_code = null;

	const DEBUG = true;
	public $log = Array();

	public function __construct($api_code=null) {
		if(!is_null($api_code)) {
			$this->api_code = $api_code;
		}

		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_USERAGENT, 'Blockchain-PHP/1.0');
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($this->ch, CURLOPT_CAINFO, __DIR__.'/Blockchain/ca-bundle.crt');

        $this->Create = new Create($this);
        $this->Explorer = new Explorer($this);
        $this->Push = new Push($this);
        $this->Rates = new Rates($this);
        $this->Receive = new Receive($this);
        $this->Stats = new Stats($this);
        $this->Wallet = new Wallet($this);
	}

	public function __deconstruct() {
		curl_close($this->ch);
	}

	public function setTimeout($timeout) {
		curl_setopt($this->ch, CURLOPT_TIMEOUT, intval($timeout));
	}

	public function post($resource, $data=null) {
		curl_setopt($this->ch, CURLOPT_URL, self::URL.$resource);
        curl_setopt($this->ch, CURLOPT_POST, true);

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, 
            array("Content-Type: application/x-www-form-urlencoded"));

        if(!is_null($this->api_code)) {
            $data['api_code'] = $this->api_code;
        }

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));

		$json = $this->_call();

		// throw ApiError if we get an 'error' field in the JSON
		if(array_key_exists('error', $json)) {
			throw new Blockchain_ApiError($json['error']);
		}

		return $json;
	}

	public function get($resource, $params=null) {
		curl_setopt($this->ch, CURLOPT_POST, false);

		if(!is_null($this->api_code)) {
			$params['api_code'] = $this->api_code;
		}
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array());

		$query = http_build_query($params);
		curl_setopt($this->ch, CURLOPT_URL, self::URL.$resource.'?'.$query);

		return $this->_call();
	}

	private function _call() {
		$t0 = microtime(true);
		$response = curl_exec($this->ch);
		$dt = microtime(true) - $t0;

		if(curl_error($this->ch)) {
			$info = curl_getinfo($this->ch);
			throw new Blockchain_HttpError("Call to " . $info['url'] . " failed: " . curl_error($this->ch));
		}
		$json = json_decode($response, true);
		if(is_null($json)) {
			throw new Blockchain_Error("Unable to decode JSON response from Blockchain: " . $response);
		}

		if(self::DEBUG) {
			$info = curl_getinfo($this->ch);
			$this->log[] = array(
				'curl_info' => $info,
				'elapsed_ms' => round(1000*$dt)
			);
		}

		return $json;
	}
}

// Convert an incoming integer to a BTC string value
function BTC_int2str($val) {
    $a = bcmul($val, "1.0", 1);
    return bcdiv($a, "100000000", 8);
}
// Convert a float value to BTC satoshi integer string
function BTC_float2int($val) {
    return bcmul($val, "100000000", 0);
}
// From comment on http://php.net/manual/en/ref.bc.php
function bcconv($fNumber) {
    $sAppend = '';
    $iDecimals = ini_get('precision') - floor(log10(abs($fNumber)));
    if (0 > $iDecimals) {
        $fNumber *= pow(10, $iDecimals);
        $sAppend = str_repeat('0', -$iDecimals);
        $iDecimals = 0;
    }
    return number_format($fNumber, $iDecimals, '.', '').$sAppend;
}