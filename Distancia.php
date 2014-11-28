<?php
namespace Distancia;

class Distancia 
{

    private $saida;

    public function distanciaPontosGPS($p1LA, $p1LO, $p2LA, $p2LO) {
        $r = 6371.0;
           
        $p1LA = $p1LA * pi() / 180.0;
        $p1LO = $p1LO * pi() / 180.0;
        $p2LA = $p2LA * pi() / 180.0;
        $p2LO = $p2LO * pi() / 180.0;
           
        $dLat = $p2LA - $p1LA;
        $dLong = $p2LO - $p1LO;
           
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($p1LA) * cos($p2LA) * sin($dLong / 2) * sin($dLong / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
       
        if($this->saida == 'km'){
            return round($r * $c * 1000)/1000.0; //  resultado em km.
        }else{
            return round($r * $c * 1000); //  resultado em metros.
        }
        
    }

    


    /**
     * Gets the value of saida.
     *
     * @return mixed
     */
    public function getSaida()
    {
        return $this->saida;
    }

    /**
     * Sets the value of saida.
     *
     * @param mixed $saida the saida
     *
     * @return self
     */
    public function setSaida($saida)
    {
        $this->saida = $saida;

        return $this;
    }
}



