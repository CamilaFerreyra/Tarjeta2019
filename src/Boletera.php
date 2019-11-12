<?php

namespace TrabajoTarjeta;

use Exception;

class Boletera implements BoleteraInterface {

    protected $colectivo; // la boletera obviamente esta en un unico colectivo
    protected $ingreso;
    protected $tiempo;

    public function __construct(ColectivoInterface $colectivo, $tiempo = null)
    {
        $this->colectivo = $colectivo;
        $this->ingreso = 0;
        $this->tiempo = new Tiempo($tiempo);
    }

    public function sacarBoleto(TarjetaInterface $tarjeta)
    {
        $tipo = $this->tipoBoleto($tarjeta);

        try {
            $boleto = new Boleto($this, $tarjeta, $tipo);
        } catch (Exception $e) {
            return false;
        }

        $descontado = $boleto->obtenerValor();

        $tarjeta->informarUso($this->colectivo);
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

        if ((
            $tipo_tarjeta == 'media franquicia estudiantil' || 
            $tipo_tarjeta == 'medio boleto universitario'
            ) && $tarjeta->medios > 0 && $tarjeta->saldoSuficienteMedio()
           )
        {
            if ($tipo_tarjeta == 'medio boleto universitario') {
                $tarjeta->contarMedio();
            }

            $tipo = "medio boleto";
        } else if ($tipo_tarjeta == 'franquicia completa') {
            $tipo = "franquicia completa";
        } else {

            if ($this->esTransbordo($tarjeta)) {
                $tipo = "transbordo";
            } else if ($tarjeta->saldoSuficiente()) {
                $tipo = "normal";
            } else if ($tarjeta->CantidadPlus() < 2) {
                $tipo = "plus";
                $tarjeta->descontarPlus();
            } else {
                $tipo = "denegado";
            }

        }

        return $tipo;
    }

    public function adelantarTiempo($min) {
        if ($this->tiempo->tiempo == null) {
            $xd = $this->tiempo->tiempo;
            throw new Exception("Reloj no configurado para modificaciones: $xd");
        } else {
            $tiempoNuevo = $this->tiempo->tiempo + $min;
        }

        $tiempoViejo = $this->tiempo->tiempo;
        // throw new Exception("Tiempo Nuevo: $tiempoNuevo " . "Tiempo Viejo: $tiempoViejo");

        $this->tiempo->cambiarTiempo($tiempoNuevo);
    }

    private function esTransbordo(TarjetaInterface $tarjeta) 
    {
        if ($tarjeta->DevolverUltimoBoleto() == null) {
            return false;
        }

        $tiempo_desde_ultimo_viaje = $this->tiempo->tiempo() - $tarjeta->DevolverUltimoBoleto();

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