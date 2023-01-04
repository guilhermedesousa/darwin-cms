<?php

class Entity
{
    protected PDO $dbc;
    protected string $tableName;
    protected array $fields;

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