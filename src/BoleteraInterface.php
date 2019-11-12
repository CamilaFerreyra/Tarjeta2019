<?php

namespace TrabajoTarjeta;

interface BoleteraInterface {

    /**
     * Ejecuta toda la logica necesaria para descontar credito de
     * la tarjeta y emitir un boleto dependiendo de las condiciones
     * de la tarjeta
     * 
     * @param TarjetaInterface $tarjeta
     * 
     * @return BoletoInterface|Bool
     *      Devuelve el boleto emitido o False si no se pudo generar un boleto
     */
    public function sacarBoleto(TarjetaInterface $tarjeta);
    
    /**
     * Determina si el boleto es normal, plus, media franquicia, franquicia completa
     * o denengado
     * 
     * @param TarjetaInterface $tarjeta
     * 
     * @return string
     */
    public function tipoBoleto(TarjetaInterface $tarjeta); 

    /**
     * Devuelve un numero muy grande, simulando el infinito.
     *
     * @return int
     */
    public function obtenerLimiteTransbordos();
    
    /**
     * Devuelve el colectivo al cual pertenece la boletera
     *
     */
    public function obtenerColectivo();
    
    /**
     * Devuelve la cantidad de dinero q fue descontada desde la ultima
     * revision
     */
    public function obtenerIngreso();

    /**
     * Realiza la logica necesaria para una revision
     * (la revision es un descuento del ingreso de la boletera que lo deja a 0,
     * es decir, se recupera el ingreso)
     * 
     * @return bool
     *      Devuelve si la operacion se realizo con exito
     */
    public function revision();
}