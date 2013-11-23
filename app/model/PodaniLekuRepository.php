<?php

namespace Todo;

use Nette;

class PodaniLekuRepository extends Repository {

    public function addPodaniLeku($IDleku, $rodneCislo, $zacatekPodani, $konecPodani, $mnozstvi, $opakovaniDenne, $zpusobPodani) {
        $this->getTable()->insert(array(
            'IDleku' => $IDleku,
            'rodneCislo' => $rodneCislo,
            'zacatekPodani' => $zacatekPodani,
            'konecPodani' => $konecPodani,
            'mnozstvi' => $mnozstvi,
            'opakovaniDenne' => $opakovaniDenne,
            'zpusobPodani' => $zpusobPodani));
    }

}
