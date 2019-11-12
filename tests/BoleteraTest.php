<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoleteraTest extends TestCase {
    
    public function testAdelantarTiempo() {
        $colectivo = new Colectivo("a", "b", "c", 1);
        $tarjeta = new Tarjeta("franquicia normal", 1);
        $boletera = $colectivo->boletera;

        $boletera->sacarBoleto($tarjeta);

        $boletera->adelantarTiempo(Tiempo::obtenerTiempoTransbordo() + 5);
        
        $this->assertFalse($boletera->esTransbordo($tarjeta));
    }

    public function testEsTransbordo() {
        $colectivo1 = new Colectivo("a", "b", "c");
        $boletera1 = $colectivo1->boletera;
        
        $tarjeta = new Tarjeta("franquicia normal");
        
        // Compruebo q no se puedan sacar transbordos despues de un plus
        $boleto = $boletera1->sacarBoleto($tarjeta);

        $this->assertFalse($boletera1->esTransbordo($tarjeta));

        // Saco un boleto normal y sigo probando
        $tarjeta->recargar(1000);

        $boletera1->sacarBoleto($tarjeta);

        $this->assertTrue($boletera1->esTransbordo($tarjeta));

        // Compruebo q el transbordo en la misma linea no funciona
        $boleto = $boletera1->sacarBoleto($tarjeta);

        $this->assertEquals("normal", $boleto->obtenerTipo());
    }
}
