<?php

class Product {

    private $nom;
    private $preu;
    private $desc_llarga;
    private $desc_curta;
    private $foto;

    public function __constructor($nom, $preu, $llarga, $curta, $foto) {
        $this->nom = $nom;
        $this->preu = $preu;
        $this->desc_llarga = $llarga;
        $this->desc_curta = $curta;
        $this->foto = $foto;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        $this->update();
    }

    public function getPreu() {
        return $this->preu;
    }

    public function setPreu($preu) {
        $this->preu = $preu;
        $this->update();
    }

    public function getDesLlarga() {
        return $this->desc_llarga;
    }

    public function setDesLlarga($desc) {
        $this->desc_llarga = $desc;
        $this->update();
    }

    public function getDesCurta() {
        return $this->desc_curta;
    }

    public function setDesCurta($desc) {
        $this->desc_curta = $desc;
        $this->update();
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
        $this->update();
    }

}

?>