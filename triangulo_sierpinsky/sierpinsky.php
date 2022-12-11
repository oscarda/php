<?php

require_once("triangulo.php");
require_once("imagen.php");

class Sierpinsky
{
    public $base = 0;
    const MARGEN = 20;
    public $colores = [];
    private Imagen $img;
    private array $triangulos;

    public function __construct($base, $col1rgb, $col2rgb)
    {
        $this->base = $base;

        //Crea una nueva imagen basada en paleta de colores
        $colores = [    array("red" => $col1rgb[0], "green" => $col1rgb[1], "blue" => $col1rgb[2] ),  //color de fondo
                        array("red" => $col2rgb[0], "green" => $col2rgb[1], "blue" => $col2rgb[2] ),  //color de trazado 1
                        array("red" => $col1rgb[0], "green" => $col1rgb[1], "blue" => $col1rgb[2] ),  //color de trazado 2
                   ];
        $this->img =     Imagen::getImagenUnica($base + 2*self::MARGEN, $base, $colores);
        $this->colores = $this->img->getColores();
    }

    public function dibujar() : void {
        // Creamos el triángulo madre primigenio sobre el que se dibujarán todos los demás triángulos hijos.
        // Dejamos un margen entre el vértice y los límites de la imagen
        $t = new Triangulo( base: $this->base,
                            x: self::MARGEN, y: $this->base - self::MARGEN,
                            punta_arriba: true, vertice_dado: 0, relleno: true);
        $t->dibujar($this->img->getImagenGD(), $this->colores[1]);
        $this->triangulos[] = $t;

        $this->trazadoSierpinsky(tmadre: $t);   //traza todos los triángulos hijos decrecientes de forma recursiva

        $this->img->EnviarImagenPng();              //envía la imagen png
    }

    // Función recursiva que traza un triángulo Sierpinsky realizando los siguientes pasos:
    // Dado un triángulo 'madre', dibuja en su interior un triángulo 'central' (un nuevo triángulo inscrito
    // con la punta hacia abajo);
    // Calcula los 3 subtriángulos 'hijos' que se forman tras dibujar el triángulo inscrito;
    // Se llama a sí misma para avanzar el trazado Sierpinsky en cada subtriángulo hijo.
    // La recursividad se detiene cuando la altura del triángulo madre es igual o menor a 12 píxeles.
    private function trazadoSierpinsky(Triangulo $tmadre) : void {

        // -------------------------------------------------------------------------------------------------
        // A) Cortamos la recursividad si el triángulo tiene altura 12
        if ($tmadre->altura <= 12)
            return;

        // -------------------------------------------------------------------------------------------------
        // B) Creamos triángulo invertido a partir de su vértice central
        // las coordenadas del vértice central: x = x0madre + base/2,  y = y0madre
        $nueva_base = $tmadre->base/2;
        $tcentral = new Triangulo(  base: $nueva_base, x: $tmadre->x[0] + $tmadre->base/2, y: $tmadre->y[0],
                                    punta_arriba: false, vertice_dado: 2, relleno: true);
        $tcentral->dibujar($this->img->getImagenGD(), $this->colores[0]);
        $this->triangulos[] = $tcentral;
        // -------------------------------------------------------------------------------------------------
        // C) Calculamos cada uno de los tres subtriángulos hijos creados

        //Calcula subtriángulo 1 (inferior izquierda)
        //el vértice izquierdo de este triángulo es idéntico al vértice izquierdo de tmadre
        $thijo1 = new Triangulo(    base: $nueva_base, x: $tmadre->x[0], y: $tmadre->y[0],
                                    punta_arriba: true, vertice_dado: 0, relleno: true);
        $this->triangulos[] = $thijo1;

        //Calcula subtriángulo 2 (inferior derecha)
        //el vértice izquierdo de este triángulo es idéntico al vértice central de tcentral
        $thijo2 = new Triangulo(    base: $nueva_base, x: $tcentral->x[2], y: $tcentral->y[2],
                                    punta_arriba: true, vertice_dado: 0, relleno: true);
        $this->triangulos[] = $thijo2;

        //Calcula subtriangulo 3 (superior central)
        //el vértice izquierdo de este triángulo es idéntico al vértice izquierdo (0) de tcentral
        $thijo3 = new Triangulo(    base: $nueva_base, x: $tcentral->x[0], y: $tcentral->y[0],
                                    punta_arriba: true, vertice_dado: 0, relleno: true);
        $this->triangulos[] = $thijo3;

        // -------------------------------------------------------------------------------------------------
        // D) Recursivamente volvemos a llamar a esta función con cada uno de los tres subtriángulos hijos
        $this->trazadoSierpinsky(tmadre: $thijo1);
        $this->trazadoSierpinsky(tmadre: $thijo2);
        $this->trazadoSierpinsky(tmadre: $thijo3);
    }
}
