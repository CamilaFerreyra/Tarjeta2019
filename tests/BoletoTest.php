<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;
use Exception;

class BoletoTest extends TestCase {
    
    public function testBoletoDenegado() 
    {
        $colectivo = new Colectivo("133 negra", "semptur", "1234", 1);
        $tarjeta = new Tarjeta("franquicia normal");
        
        // Uso los dos plus
        $colectivo->pagarCon($tarjeta);
        
        $colectivo = $this->pasarOtroBoleto($colectivo);
        $colectivo->pagarCon($tarjeta);

        // Sacar un nuevo boleto y comprobar q es denegado
        $colectivo = $this->pasarOtroBoleto($colectivo);
        $boleto = $colectivo->pagarCon($tarjeta);
        
        $this->assertFalse($boleto);
    }

    public function testFranquiciaCompleta() {
        $colectivo = new Colectivo("133 negra", "semptur", "1234");
        $tarjeta = new Tarjeta("franquicia completa");

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertEquals(0, $boleto->obtenerValor());
    }

    public function testFranquiciaNormal() {
        $colectivo = new Colectivo("133 negra", "semptur", "1234");
        $tarjeta = new Tarjeta("franquicia normal");

        $tarjeta->recargar(Boleto::obtenerMontoNormal());

        // Usamos el credito cargado 
        $boleto = $colectivo->pagarCon($tarjeta);

        // Comprobamos que se pueda sacar un boleto
        $this->assertNotFalse($boleto);

        // Comprobamos que el boleto se cree bien
        $this->assertEquals("normal", $boleto->obtenerTipo());
        $this->assertEquals(Boleto::obtenerMontoNormal(), $boleto->obtenerValor());
    }

    public function testViajePlus()
    {
        $colectivo = new Colectivo("133 negra", "semptur", "1234", 1);
        $tarjeta = new Tarjeta("franquicia normal");
        
        // Usamos los dos viajes plus
        $colectivo->pagarCon($tarjeta);

        $colectivo = $this->pasarOtroBoleto($colectivo);
        $boleto = $colectivo->pagarCon($tarjeta);

        // Comprobamos q se puedan usar dos plus
        $this->assertNotFalse($boleto);

        // Comprobamos que el boleto se cree bien
        $this->assertEquals("plus", $boleto->obtenerTipo());
        $this->assertEquals(Boleto::obtenerMontoNormal(), $boleto->obtenerValor());

        // Comprobamos q no se puedan usar mas viajes
        $this->assertFalse($colectivo->pagarCon($tarjeta));

        // Comprobamos q en la recarga se descuenten los viajes plus
        $tarjeta->recargar(100);

        $this->assertEquals($tarjeta->obtenerSaldo(), 100 - 2 * Boleto::obtenerMontoNormal());
    }

    public function testMedioBoleto()
    {
        $colectivo = new Colectivo("133 negra", "semptur", "1234");
        $tarjeta = new Tarjeta("media franquicia estudiantil");

        $tarjeta->recargar(Boleto::obtenerMedioBoleto());

        $boleto = $colectivo->pagarCon($tarjeta);

        // Comprobamos que se haya podido pagar correctamente el viaje
        $this->assertNotFalse($boleto);

        // Comprobamos que el boleto se cree bien
        $this->assertEquals("medio boleto", $boleto->obtenerTipo());
        $this->assertEquals(Boleto::obtenerMedioBoleto(), $boleto->obtenerValor());
    }

    public function pasarOtroBoleto($colectivo) {
        $tiempoTransbordo = Tiempo::obtenerTiempoTransbordo() + 5;
        $colectivo->boletera->adelantarTiempo($tiempoTransbordo);
        
        return $colectivo;
    }
    
    public function testCircuitoTransbordo() {
        $colectivo1 = new Colectivo("133 negra", "semptur", "1234");
        $colectivo2 = new Colectivo("a", "b", "c");
        $tarjeta = new Tarjeta("media franquicia estudiantil");

        $tarjeta->recargar(100);

        // Usamos el plus y "activamos" el transbordo
        $colectivo1->pagarCon($tarjeta);

        $transbordo = $colectivo2->pagarCon($tarjeta);

        // $this->assertTrue($tarjeta->CantidadPlus() < 2);
        // Comprobamos que se haya podido pagar correctamente
        $this->assertNotFalse($transbordo);

        // Comprobamos que el boleto se cree bien
        $this->assertEquals("transbordo", $transbordo->obtenerTipo());
        $this->assertEquals(0, $transbordo->obtenerValor());
    }
}
