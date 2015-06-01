<?php

class Wallet {
	private $identifier = null;
	private $main_password = null;
	private $second_password = null;

	public function __construct(Blockchain $blockchain) {
		$this->blockchain = $blockchain;
	}

	public function credentials($id, $pw1, $pw2=null) {
		$this->identifier = $id;
		$this->main_password = $pw1;
		if(!is_null($pw2)) {
			$this->second_password = $pw2;
		}
	}

	private function _checkCredentials() {
		if(is_null($this->identifier) || is_null($this->main_password)) {
			throw new Blockchain_CredentialsError('Please enter wallet credentials.');
		}
	}

    private function reqParams($extras=array()) {
        $ret = array('password'=>$this->main_password);
        if(!is_null($this->second_password)) {
            $ret['second_password'] = $this->second_password;
        }

        return array_merge($ret, $extras);
    }

    private function url($resource) {
        return "merchant/" . $this->identifier . "/" . $resource;
    }

    private function call($resource, $params=array()) {
        $this->_checkCredentials();
        return $this->blockchain->post($this->url($resource), $this->reqParams($params)); 
    }

    public function getIdentifier() {
        return $this->identifier;
    }

    public function getBalance() {
        $json = $this->call('balance');
        return BTC_int2str($json['balance']);
    }

    public function getAddressBalance($address) {
        return new WalletAddress($this->call('address_balance', array('address'=>$address)));
    }

    public function getAddresses() {
        $json = $this->call('list');
        $addresses = array();
        foreach ($json['addresses'] as $address) {
            $addresses[] = new WalletAddress($address);
        }
        return $addresses;
    }

    public function getNewAddress($label=null) {
        $params = array();
        if(!is_null($label)) {
            $params['label'] = $label;
        }
        return new WalletAddress($this->call('new_address', $params));
    }

    public function archiveAddress($address) {
        $json = $this->call('archive_address', array('address'=>$address));
        if(array_key_exists('archived', $json)) {
            if($json['archived'] == $address) {
                return true;
            }
        }
        return false;
    }

    public function unarchiveAddress($address) {
        $json = $this->call('unarchive_address', array('address'=>$address));
        if(array_key_exists('active', $json)) {
            if($json['active'] == $address) {
                return true;
            }
        }
        return false;
    }

    public function consolidateAddresses($days=60) {
        $consolidated = array();
        $json = $this->call('auto_consolidate', array('days'=>intval($days)));
        if(array_key_exists('consolidated', $json) && is_array($json['consolidated'])) {
            $consolidated = $json['consolidated'];
        }
        return $consolidated;
    }

    public function send($to_address, $amount, $from_address=null, $fee=null, $public_note=null) {
        if(!isset($amount))
            throw new Blockchain_ParameterError("Amount required.");

        $params = array(
            'to'=>$to_address,
            'amount'=>BTC_float2int($amount)
        );
        if(!is_null($from_address))
            $params['from'] = $from_address;
        if(!is_null($fee))
            $params['fee'] = BTC_float2int($fee);
        if(!is_null($public_note))
            $params['note'] = $public_note;
        
        return new PaymentResponse($this->call('payment', $params));
    }

    public function sendMany($recipients, $from_address=null, $fee=null, $public_note=null) {
        $R = array();
        // Construct JSON by hand, preserving the full value of amounts
        foreach ($recipients as $address => $amount) {
            $R[] = '"' . $address . '":' . BTC_float2int($amount);
        }
        $json = '{' . implode(',', $R) . '}';

        $params = array(
            'recipients'=>$json
        );
        if(!is_null($from_address))
            $params['from'] = $from_address;
        if(!is_null($fee))
            $params['fee'] = BTC_float2int($fee);
        if(!is_null($public_note))
            $params['note'] = $public_note;
        
        return new PaymentResponse($this->call('sendmany', $params));
    }
}

class PaymentResponse {
    public $message;                    // string
    public $tx_hash;                    // string
    public $notice;                     // string

    public function __construct($json) {
        if(array_key_exists('message', $json))
            $this->message = $json['message'];
        if(array_key_exists('tx_hash', $json))
            $this->tx_hash = $json['tx_hash'];
        if(array_key_exists('notice', $json))
            $this->notice = $json['notice'];
    }
}

class WalletAddress {
    public $balance;                    // string, e.g. "12.64952835"
    public $address;                    // string
    public $label;                      // string
    public $total_received;             // string, e.g. "12.64952835"

    public function __construct($json) {
        if(array_key_exists('balance', $json))
            $this->balance = BTC_int2str($json['balance']);
        if(array_key_exists('address', $json))
            $this->address = $json['address'];
        if(array_key_exists('label', $json))
            $this->label = $json['label'];
        if(array_key_exists('total_received', $json))
            $this->total_received = $json['total_received'];
    }
}