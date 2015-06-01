<?php

class Create {
	public function __construct(Blockchain $blockchain) {
		$this->blockchain = $blockchain;
	}

    public function create($password, $email=null, $label=null) {
        return $this->doCreate($password, null, $email, $label);
    }

    public function createWithKey($password, $privKey, $email=null, $label=null) {
        if(!isset($privKey) || is_null($privKey))
            throw new Blockchain_ParameterError("Private Key required.");

        return $this->doCreate($password, $privKey, $email, $label);
    }

    public function doCreate($password, $priv=null, $email=null, $label=null) {
        if(!isset($password) || is_null($password))
            throw new Blockchain_ParameterError("Password required.");
        
        $params = array(
            'password'=>$password,
            'format'=>'json'
        );
        if(!is_null($priv))
            $params['priv'] = $priv;
        if(!is_null($email))
            $params['email'] = $email;
        if(!is_null($label))
            $params['label'] = $label;

        return new WalletResponse($this->blockchain->post('api/v2/create_wallet', $params));
    }
}

class WalletResponse {
    public $guid;                       // string
    public $address;                    // string
    public $link;                       // string

    public function __construct($json) {
        if(array_key_exists('guid', $json))
            $this->guid = $json['guid'];
        if(array_key_exists('address', $json))
            $this->address = $json['address'];
        if(array_key_exists('link', $json))
            $this->link = $json['link'];
    }
}