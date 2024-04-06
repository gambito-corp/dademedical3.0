<?php

namespace App\Models;

class FormField
{
    public $nombre;
    public $id;
    public $tipo;
    public $placeholder;
    public $value;
    public $required;
    public $eloquentModel;

    public function __construct($nombre, $id, $tipo = 'text', $placeholder = '', $value = '', $required = false, $eloquentModel = null)
    {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->tipo = $tipo;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->eloquentModel = $eloquentModel;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getEloquentModel()
    {
        return $this->eloquentModel;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function setEloquentModel($eloquentModel)
    {
        $this->eloquentModel = $eloquentModel;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function __toArray()
    {
        return [
            'nombre' => $this->nombre,
            'id' => $this->id,
            'tipo' => $this->tipo,
            'placeholder' => $this->placeholder,
            'value' => $this->value,
            'required' => $this->required,
            'eloquentModel' => $this->eloquentModel,
        ];
    }

    public function __toJson()
    {
        return json_encode($this->__toArray());
    }

    public function __toObject()
    {
        return (object) $this->__toArray();
    }

    public function __toStdClass()
    {
        return (object) $this->__toArray();
    }

    public function __toCollection()
    {
        return collect($this->__toArray());
    }

    public function __toCollectionOf($class)
    {
        return collect($this->__toArray())->mapInto($class);
    }

    public function __toCollectionOfStdClass()
    {
        return collect($this->__toArray())->mapInto(\stdClass::class);
    }

    public function __toCollectionOfArray()
    {
        return collect($this->__toArray())->mapInto(\stdClass::class)->toArray();
    }

    public function __toCollectionOfObject()
    {
        return collect($this->__toArray())->mapInto(\stdClass::class)->mapInto(\stdClass::class);
    }
}
