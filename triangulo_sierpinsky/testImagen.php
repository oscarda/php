<?php

require_once("imagen.php");
require_once("triangulo.php");

$colores_rgb = [    array("red" => 80, "green" => 80, "blue" => 80 ),   //color de fondo 0
                    array("red" => 50, "green" => 180, "blue" => 50 ),  //color de trazado 1
               ];

$img = Imagen::getImagenUnica(640, 480, $colores_rgb);
$colores = $img->getColores();

$t = new Triangulo(base: 200, x: 30, y: 460, punta_arriba: true, vertice_dado: 0, relleno: true);
$t->dibujar($img->getImagenGD(), $colores[1]);

$img->EnviarImagenPng();

