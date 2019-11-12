<?php

namespace TrabajoTarjeta;

interface TiempoInterface {

    /**
     * Devuelve la hora. Si le pasamos un tiempo ficticio, usaráese.
     * Si no, devuelve la fecha Unix actual
     *
     * @return int
     */
    public function tiempo();
    
    /**
     * Calcula el tiempo durante el cual, luego de pagar un boleto, 
     * tenés habilitados los transbordos.
     * Si es día de semana, será una hora, sino dos horas.
     * 
     * @return int
     */
    public static function obtenerTiempoTransbordo();

}
