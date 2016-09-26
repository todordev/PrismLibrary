<?php

namespace Blockchain\Stats;

use \Blockchain\Blockchain;

class Stats {
    public function __construct(Blockchain $blockchain) {
        $this->blockchain = $blockchain;
    }

    public function get() {
        return new StatsResponse($this->blockchain->get('stats', array('format'=>'json')));
    }
}