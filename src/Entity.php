<?php

namespace src;

use phpDocumentor\Reflection\Types\This;

abstract class Entity
{
    protected $dbc;
    protected $tableName;
    protected $fields;
    protected $primaryKeys = ['id'];

    abstract protected function initFields();

    protected function __construct($dbc, $tableName) {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->initFields();
    }

    public function findBy($fieldName, $fieldValue): void
    {
        $sql = "SELECT * FROM $this->tableName WHERE $fieldName = :value";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute(['value' => $fieldValue]);
        $databaseData = $stmt->fetch();

        if ($databaseData) {
            $this->setValues($databaseData);
        }
    }

    public function findAll(): array
    {
        $results = [];
        $databaseData = $this->find();

        if ($databaseData) {
            $className = static::class;
            foreach ($databaseData as $objectData) {
                $object = new $className($this->dbc);
                $object = $this->setValues($objectData, $object);
                $results[] = $object;
            }
        }

        return $results;
    }

    private function find($fieldName = '', $fieldValue = ''): array
    {
        $results = [];
        $preparedFields = [];
        $sql = "SELECT * FROM $this->tableName";
        if ($fieldName) {
            $sql .= "WHERE $fieldName = :value";
            $preparedFields = ['value' => $fieldValue];
        }
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);

        $databaseData = $stmt->fetchAll();

        return $databaseData;
    }

    public function setValues($values, $object = null): Entity
    {
        if ($object === null) {
            $object = $this;
        }

        foreach ($object->primaryKeys as $keyName) {
            if (isset($values[$keyName])) {
                $object->$keyName = $values[$keyName];
            }
        }

        foreach ($object->fields as $fieldName) {
            if (isset($values[$fieldName])) {
                $object->$fieldName = $values[$fieldName];
            }
        }

        return $object;
    }

    public function save()
    {
        $fieldBindings = [];
        $keyBindings = [];
        $preparedFields = [];

        foreach ($this->primaryKeys as $keyName) {
            $keyBindings[$keyName] = "$keyName = :$keyName";
            $preparedFields[$keyName] = $this->$keyName;
        }

        foreach ($this->fields as $fieldName) {
            $fieldBindings[$fieldName] = "$fieldName = :$fieldName";
            $preparedFields[$fieldName] = $this->$fieldName;
        }

        $fieldBindingsString = join(', ', $fieldBindings);
        $keyBindingsString = join(', ', $keyBindings);

        $sql = "UPDATE $this->tableName SET $fieldBindingsString WHERE $keyBindingsString";

        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }

    public function insert()
    {
        $fieldBindingsString = join(', ', $this->fields);
        $preparedFields = [];

        foreach ($this->fields as $fieldName) {
            $preparedFields[] = '"' . $this->$fieldName . '"';
        }

        $valuesString = join(', ', $preparedFields);

        $sql = "INSERT INTO $this->tableName ($fieldBindingsString) VALUES ($valuesString)";

        $stmt = $this->dbc->prepare($sql);
        $stmt->execute();
    }
}