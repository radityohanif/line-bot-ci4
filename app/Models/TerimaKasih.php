<?php

namespace App\Model;

use CodeIgniter\Model;

class TerimaKasih extends Model
{
    public $confidence;
    public $sentence;

    function __construct()
    {
        $this->confidence = 0;
        $this->sentence = [
            'terimakasih',
            'tq',
            'terima',
            'kasih'
        ];
    }

    public function setConfidence($pesanMasuk)
    {
        foreach ($this->sentence as $indikator) {
            if (in_array($indikator, $pesanMasuk)) {
                $this->confidence += 1;
            }
        }
    }
}