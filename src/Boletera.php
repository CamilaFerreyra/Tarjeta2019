<?php

namespace TrabajoTarjeta;

use Exception;

class Boletera implements BoleteraInterface {

    protected $colectivo; // la boletera obviamente esta en un unico colectivo
    protected $ingreso;
    public $tiempo;

    public function __construct(ColectivoInterface $colectivo = null, $tiempo = null)
    {
        $this->colectivo = $colectivo;
        $this->ingreso = 0;
        $this->tiempo = new Tiempo($tiempo);
    }

    public function sacarBoleto(TarjetaInterface $tarjeta)
    {
        $tarjeta->informarUso($this->colectivo);
        $tipo = $this->tipoBoleto($tarjeta);

        try {
            $boleto = new Boleto($this, $tarjeta, $tipo);
        } catch (Exception $e) {
            // throw $e;
            return false;
        }

        $descontado = $boleto->obtenerValor();

        $pago = $tarjeta->pagar($descontado);

        if ($pago == FALSE) {
            return FALSE;
        }

        $this->ingreso += $descontado;

        return $boleto;
    }

    public function tipoBoleto(TarjetaInterface $tarjeta) 
    {
        $tipo_tarjeta = $tarjeta->obtenerTipo();

        if ($this->esTransbordo($tarjeta)) {
            $tipo = "transbordo";
        } else if ((
            $tipo_tarjeta == 'media franquicia estudiantil' || 
            $tipo_tarjeta == 'medio boleto universitario'
            ) && $tarjeta->obtenerMedios() > 0 && $tarjeta->saldoSuficienteMedio()
           )
        {
            if ($tipo_tarjeta == 'medio boleto universitario') {
                $tarjeta->contarMedio();
            }

            $tipo = "medio boleto";
        } else if ($tipo_tarjeta == 'franquicia completa') {
            $tipo = "franquicia completa";
        } else {

            if ($tarjeta->saldoSuficiente()) {
                $tipo = "normal";
            } else if ($tarjeta->CantidadPlus() < 2) {
                $tipo = "plus";
            } else {
                $tipo = "denegado";
            }

        }

        return $tipo;
    }

    public function adelantarTiempo($min) {
        if ($this->tiempo->tiempo == null) {
            throw new Exception("Reloj no configurado para modificaciones");
        } else {
            $tiempoNuevo = $this->tiempo->tiempo + $min;
        }

        $this->tiempo->cambiarTiempo($tiempoNuevo);
    }

    public function esTransbordo(TarjetaInterface $tarjeta) 
    {
        if ($tarjeta->DevolverUltimoBoleto() == null) {
            return false;
        }

        $tiempo_desde_ultimo_viaje = $this->tiempo->tiempo() - $tarjeta->DevolverUltimoBoleto();
        // throw new Exception("$tiempo_desde_ultimo_viaje");
        if ($tarjeta->obtenerUltimoPlus() == FALSE && 
        $tarjeta->ColectivosIguales() == FALSE && 
        $tiempo_desde_ultimo_viaje <= Tiempo::obtenerTiempoTransbordo()) 
        {
            // throw new Exception("Tiempo desde ultimo viaje: $tiempo_desde_ultimo_viaje");
            return TRUE;
        }
        
        return FALSE;
    }

    public function obtenerLimiteTransbordos()
    {
        return 5000; // virtualmente infinito
    }

    public function obtenerColectivo() 
    {
        return $this->colectivo;
    }

    public function obtenerIngreso()
    {
        return $this->ingreso;
    }

    public function revision()
    {
        $this->ingreso = 0;
        // se deberia registrar la ultima revision

        return true;
    }
}