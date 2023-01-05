<?php

abstract class Entity
{
    protected PDO $dbc;
    protected string $tableName;
    protected array $fields;

    abstract protected function initFields();

    protected function __construct($dbc, $tableName) {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->initFields();
    }

    public function findBy(string $fieldName, string $fieldValue): void
    {
        $sql = "SELECT * FROM $this->tableName WHERE $fieldName = :value";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute(['value' => $fieldValue]);
        $databaseData = $stmt->fetch();

        $this->setValues($databaseData);
    }

    public function setValues($values): void
    {
        foreach ($this->fields as $fieldName) {
            $this->$fieldName = $values[$fieldName];
        }
    }
}