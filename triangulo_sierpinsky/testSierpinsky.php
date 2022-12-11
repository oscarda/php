<?php

require_once("sierpinsky.php");

//Prueba Clase Sierpinsky
$s = new Sierpinsky(640,
                    [10, 10, 10],   //color de fondo
                    [20, 20, 190]); //color de contraste
$s->dibujar();


