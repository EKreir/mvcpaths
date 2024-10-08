<?php

namespace Core\Table;

use Core\Database\MysqlDatabase;

class Table {

    protected $table;
    protected $db;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));   // Récupère le nom de la classe
            $className = end($parts);   // Récupère le dernier élément du tableau
            $this->table = strtolower(str_replace('Table', '', $className)) . 's';   // Remplace 'Table' par '' dans le nom de la classe et ajoute un 's' à la fin
        }

    }

    public function all()
    {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    public function find($id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function update($id, $fields)
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("UPDATE {$this->table} SET $sqlPart WHERE id = ?", $attributes, true);
    }

    public function create($fields)
    {
        $sqlParts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sqlParts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sqlPart = implode(', ', $sqlParts);
        return $this->query("INSERT INTO {$this->table} SET $sqlPart", $attributes, true);
    }

    public function delete($id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function extract($key, $value)
    {
        $records = $this->all();   // Récupère tous les enregistrements
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;   // Crée un tableau associatif avec la clé $key et la valeur $value
        }
        return $return;
    }

    public function query($statement, $attributes = null, $one = false)
    {
        if ($attributes) {
            return $this->db->prepare(
                $statement,
                $attributes,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        } else {
            return $this->db->query(
                $statement,
                str_replace('Table', 'Entity', get_class($this)),
                $one
            );
        }
    }

}