<?php

// Aplicamos un patrón Singleton para esta clase. Este patrón permite asegurar que
// de una clase concreta existe una única instancia en memoria y proporciona un
// método único que la devuelve.
// Imagen::getImagen()
//
class Imagen
{
    private static Imagen $imagenUnica;     //Guarda el único objeto Imagen que se creará en todo el programa
    private $imagenGD;          //Referencia a la imagen GD en memoria
    private int $ancho;
    private int $alto;
    private array $coloresGD;  //Referencias a los colores GD; $colores[0] = color de fondo de la imagen

    // Devuelve el recurso imagen.  Si no existiera aún, lo crea, lo almacena y lo devuelve.
    public static function getImagenUnica(int $ancho=0, int $alto=0, array $colores = []) {
        //Si es la primera vez que nos piden la imagen, la iniciamos.
        if(!isset(self::$imagenUnica)) {
           self::$imagenUnica = new Imagen ($ancho, $alto, $colores);
           //El constructor tiene visibilidad protegida, por tanto únicamente se puede invocar desde dentro de la clase

        }
        //Devolvemos la instancia de Imagen, recién creada o creada en llamadas anteriores
        return self::$imagenUnica;
    }

    protected function __construct($ancho, $alto, $colores) {
        //Se crea la única instancia de la clase Imagen que habrá en memoria en todo el programa
        $this->inicia_imagen($ancho, $alto, $colores);
    }

    private function inicia_imagen($ancho, $alto, $colores) {
        // Establece la cabecera de la respuesta a tipo imagen
        header("Content-type:image/png");

        //Crea una nueva imagen basada en paleta de colores
        $this->imagenGD = ImageCreate($ancho, $alto) or die ("Cannot Create image");
        ImageAntialias($this->imagenGD, true);   //mejora pixelización en el trazado de formas

        //Cargamos los colores suministrados en la imagen
        for($i=0; $i < count($colores); $i++) {
            $this->coloresGD[] = ImageColorAllocate($this->imagenGD,
                $colores[$i]['red'], $colores[$i]['green'], $colores[$i]['blue']);
        }
    }
    public function getColores() : array {
        return $this->coloresGD;
    }

    public function getImagenGD() {
        return $this->imagenGD;
    }
    public function getAncho() : array {
        return $this->ancho;
    }
    public function getAlto() : array {
        return $this->alto;
    }
    public function EnviarImagenPng() {
        ImagePng($this->imagenGD);
    }

}