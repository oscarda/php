<?php

class Triangulo
{

    public float $base = 0;
    public float $altura = 0;
    // matriz con las coordenadas x y de los vértices:
    //  0: vértice izquierdo -- 1: vértice derecho -- 2: vértice central
    public $x = [];
    public $y = [];
    private $relleno = false;
    private $punta_arriba = true;

    //Construye un objeto triángulo, con base horizontal, a partir de su vértice $vertice_dado:
    // 0: vertice izquierdo, 1: vertice derecho, 2: vertice central (TO-DO)
    function __construct($base, $x, $y, $punta_arriba, $vertice_dado = 0, $relleno = false)
    {
        $this->base = $base;
        $this->altura = sqrt($this->base ** 2 - ($this->base / 2) ** 2);
        $this->punta_arriba = $punta_arriba;
        $this->relleno = $relleno;

        if ($vertice_dado == 0) {
            $this->calcula_desde_vertice_izq($x, $y);
        } elseif ($vertice_dado ==2) {
            $this->calcula_desde_vertice_central($x, $y);
        }
    }

    private function calcula_desde_vertice_izq($x, $y) : void {
        //vértice 0 (izquierdo)
        $this->x[0] = $x;
        $this->y[0] = $y;

        //vertice 1 (derecha)
        $this->x[1] = $this->x[0] + $this->base;
        $this->y[1] = $this->y[0];

        //vertice 2 (central)
        $this->x[2] = $this->x[0] + $this->base / 2;
        if ($this->punta_arriba) {
            $this->y[2] = $this->y[0] - $this->altura;
        } else {
            //TRIANGULO PUNTA ABAJO
            $this->y[2] = $this->y[0] + $this->altura;
        }
    }

    // Calcula los vértices de un triángulo con base horizontal y punta hacia abajo, a partir de su vértice central
    private function calcula_desde_vertice_central($x, $y) : void {
        $y_base = $this->punta_arriba? $y + $this->altura : $y - $this->altura;
        //vertice 0 (izquierdo)
        $this->x[0] = $x - $this->base / 2;
        $this->y[0] = $y_base;

        //vertice 1 (derecho)
        $this->x[1] = $x + $this->base / 2;
        $this->y[1] = $y_base;

        //vertice 2 (superior)
        $this->x[2] = $x;
        $this->y[2] = $y;
    }

    public function dibujar($img, $color)
    {
        $ptos = $this->conversion_ptos();
        if ($this->relleno) {
            ImageFilledPolygon($img, $ptos, 3, $color);
        } else {
            ImagePolygon($img, $ptos, 3, $color);
        }

    }

    private function conversion_ptos(): array
    {
        $ptos = [];
        for ($i = 0; $i < 3; $i++) {
            $ptos[] = $this->x[$i];
            $ptos[] = $this->y[$i];
        }
        return $ptos;
    }
}