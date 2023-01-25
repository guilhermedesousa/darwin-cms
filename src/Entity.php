<?php

namespace src;

abstract class Entity
{
    protected $dbc;
    protected $tableName;
    protected $fields;

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
            $this->setValues($this, $databaseData);
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
                $object = $this->setValues($object, $objectData);
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

    public function setValues($object, $values): Entity
    {
        foreach ($object->fields as $fieldName) {
            $object->$fieldName = $values[$fieldName];
        }
        return $object;
    }
}