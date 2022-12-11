<?php

require_once("triangulo.php");

//Prueba Clase Triángulo
//Envía una cabecera HTTP para indicar al navegador el tipo de contenido, en este caso, una imagen.
header("Content-type: image/png");

//Crea una nueva imagen basada en paleta de colores
$img = ImageCreate(640, 480) or die ("Cannot Create image");
ImageAntialias($img, true);   //mejora la pixelización del trazado de formas


//Define colores para una imagen, para que puedan ser utilizados posteriormente
//La 1ª llamada a ImageColorAllocate() establece el color de fondo de la imagen
$color_fondo = ImageColorAllocate($img, 125, 175, 0);
//Definimos dos colores que se usarán más adelante
$color1 = ImageColorAllocate($img, 50, 50, 75);

//Triángulo sólido
$t = new Triangulo(base: 100, x: 50, y: 300, punta_arriba: true, relleno: true);
$t->dibujar($img, $color1);

//Triángulo sin relleno
$t2 = new Triangulo(base: 100, x: 0, y: 300, punta_arriba: false);
//$t2 = new Triangulo(100, 0, 300, false);
$t2->dibujar($img, $color1);

//Triángulo definido a partir del vértice central
$t3 = new Triangulo(base: 100, x: 200, y: 300, punta_arriba: false, vertice_dado: 2, relleno: 2);
$t3->dibujar($img, $color1);

//Enviamos los datos de la imagen al cliente
ImagePng($img);




