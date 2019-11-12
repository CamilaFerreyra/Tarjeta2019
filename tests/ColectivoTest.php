<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    
    /**
     *Testeamos las funciones linea(),empresa() y numero()
     */
    public function testAlgoUtil() {
        $coletivo = new Colectivo("144 n", "mixta", 20);
        
        $this->assertEquals($coletivo->linea(), "144 n");
        $this->assertEquals($coletivo->empresa(), "mixta");
        $this->assertEquals($coletivo->numero(), 20);
        
    }
    
    /**
     * Testemos que la funcion pagarCon ande correctamente
     */
    public function testeoPagarCon() {
        $colectivo = new Colectivo("134", "mixta", 30);
        $tarjeta   = new Tarjeta("franquicia normal");
        
        $tarjeta->descontarPlus();
        $tarjeta->descontarPlus();

        // Comprobamos q un boleto denegado devuelve false
        $boleto = $colectivo->pagarCon($tarjeta); 

        $this->assertFalse($boleto);

        // Recargamos y comprobamos q un boleto normal es generado
        $tarjeta->recargar(1000);

        $boleto = $colectivo->pagarCon($tarjeta);

        $this->assertNotFalse($boleto);
    }
}