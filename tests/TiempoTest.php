<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TiempoTest extends TestCase {

    public function testTiempo() {
        // Test de tiempo falso
        $tiempo_falso = new Tiempo(1);

        $this->assertEquals(1, $tiempo_falso->tiempo());

        // Test de tiempo verdadero
        $tiempo = new Tiempo();

        $this->assertEquals(time(), $tiempo->tiempo());
    }
}
