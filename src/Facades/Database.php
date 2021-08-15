<?php

namespace Leonardo\Comments\Facades;

use \PDO;

class Database {

    /** @var \PDO */
    private $connection;

    public function __construct() {
        $filename = __DIR__ . "/comments.db";

        $this->connection = new PDO("sqlite:{$filename}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * @return \PDO
     */
    public static function connection() {
        return (new static())->connection;
    }


    /**
     * @param array $values
     * @return bool
     */
    public function createComment($values) {
        // inicia o PDO
        $pdo = $this->connection;

        // recupera as colunas
        $colunas = $this->getColunas($values);

        // cria a sql para o insert
        $query = "INSERT INTO comments (" . $colunas . ") VALUES (".$this->getValues(array_keys($values)).")";

        // prepara o SQL
        $stmt = $pdo->prepare($query);
        return $stmt->execute($this->replaceKeys($values));
    }


    /**
     * @param     $url
     * @param int $pagination
     * @return array
     */
    public function getComments($url, $pagination = 25) {

        // define a SQL
        $sql =  "SELECT * FROM comments WHERE uuid = '" . base64_encode($url) . "' ORDER BY created_at DESC LIMIT 0, $pagination";

        // inicia o PDO
        return $this->connection
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param array $items
     * @return string
     */
    private function getColunas($items) {
        return implode(",", array_keys($items));
    }


    /**
     * @param $items
     * @return string
     */
    private function getValues($items) {
        return implode(",", array_map(function ($item) {
            return ":" . $item;
        }, $items));
    }


    /**
     * @param array $items
     * @return array
     */
    private function replaceKeys($items) {
        $newArray = [];

        foreach($items as $key => $item) {
            $newArray[":$key"] = $item;
        }

        return $newArray;
    }

}
