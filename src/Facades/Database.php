<?php

namespace Leonardo\Comments\Facades;

use \PDO;

class Database extends DatabaseStruct {

    /**
     * Database constructor.
     */
    public function __construct() {
        $this->connectionOrCreate();
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
     * @param $values
     * @return bool
     */
    public function createUser($values) {

        $_SESSION['comments_db'] = [
            'nome' => $values['nome'],
            'email' => $values['email']
        ];

        if ($this->hasUser($values['email']) > 0) {
            return;
        }

        // inicia o PDO
        $pdo = $this->connection;

        // recupera as colunas
        $colunas = $this->getColunas($values);

        // cria o sql para o insert
        $query = "INSERT INTO users (" . $colunas . ") VALUES (".$this->getValues(array_keys($values)).")";

        // prepara o SQL
        $stmt = $pdo->prepare($query);
        return $stmt->execute($this->replaceKeys($values));
    }


    /**
     * @return int
     */
    private function hasUser() {
        // cria o sql
        $sql = "SELECT * FROM users WHERE email = '{$_SESSION['comments_db']['email']}'";

        // executa o sql
        return $this->connection->prepare($sql)->rowCount();
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
