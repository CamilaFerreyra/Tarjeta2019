<?php
namespace TrabajoTarjeta;
use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {
    
    /**
     * Comprueba que la tarjeta aumenta su saldo cuando se carga saldo válido.
     */

    public function testSaldoSuficiente() {
        

        

        

        
    }
    
    public function testCargaSaldo() {
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    
    
    /**
     *testeamos transbordos para tarjetas de tipo franquicia normal
     */
     public function testTransbordoTarjetaNormalDiaSemanal() {
        
        
        
        
        
        
    }
    /**
     *testeamos transbordos para tarjetas de tipo franquicia normal en dia no semanales
     */
    
    public function testTransbordoTarjetaDiaNoSemanal() {
        
        
        
    }
    
    /**
     * Testeamos los transbordos para tarjetas especiales
     */
    public function testTransbordoEnTarjetasEspeciales() {
        
        
        
        
    }
    
    /**
     *testeamos la funcion que nos devuelve la cantidad de dinero realizada en nuestro ultimo viaje
     */
    public function testUltimoPago() {
        
        
        
        
    }
    
    /**
     *testeo que sirve para probar que no podemos cargar nuestra tarjeta si usamos un monto invalido
     */
    public function testCargaSaldoInvalido() {
        
       
    }
    
    /**
     *Testeo de viajes plus,comprobamos que no podamos viajar debiendo 2 plus
     */
    public function testViajePlus() {
        
        
        
        
    }
    
    /**
     *Este test se encarga de asegurarse que cuando debemos un viaje
     *plus y pagamos, estos se nos cobren
     */
    public function testSaldoPlus() {
        
        
         //creamos 2 tarjetas y le cargamos 10 pesos a cada una
        
        
        
    }
    
    /**
     * Verificamos que cuando usamos una tarjeta de tipo medio boleto
     * tienen que pasar como minimo 5 minutos para poder realizar otro viaje
     * Verificamos que al 3er viaje del dia el monto pase a valer 14.8
     */
    public function testMedioUniversitario() {
        
         //creamos una tarjeta y le cargamos 100 pesos
        
        
        
    }
    
    /**
     *esta funcion se encarga de verificar que no padamos pagar un pasaje cuando adeudemos 2 plus
     *para las tarjetas de tipo medio boleto
     */
    public function pagoNoValido() 
    {
        
        
    }



    /**
     * En este test vamos a verificar que las tarjeta de tipo medio estudiantil puedan
     * pagar la cantidad de medios boletos que quieran en el dia
     */
    public function pagoMedioEstudiantil() {
        
        


    }

    /**
     * Este test verifica que el metodo pago medio boleto ande bien en caso de que: 
     * - 
     * - Debamos algun plus 
     */
    public function testPago2plus() {
        
        
        

    }

    /**
     *Testeamos que los transbordos funcionen bien cuando es de noche
     */
    public function testTransbordoDeNoche() {
        
        
        
        

    } 

    /**
     *Testeamos que los transbordos funcionen bien cuando es fin de semana
     */
    public function testTransbordoEnFinDeSemana() {
        
        
        
        

    }
  
}