<?php

namespace App\Model;

use CodeIgniter\Model;

class Salam extends Model
{
    public $confidence;
    public $sentence;

    function __construct()
    {
        $this->confidence = 0;
        $this->sentence = [
            'halo', 'hai', 'permisi',
            'selamat', 'pagi', 'siang', 'sore',
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