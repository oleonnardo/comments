<?php

namespace Leonardo\Comments\Facades;

use PDO;

abstract class DatabaseStruct {

    /** @var \PDO */
    protected $connection;

    /** @var string */
    protected $filename;

    /** @var array  */
    private $sql = [
        'comments' => [
            'id'            => 'integer not null',
            'uuid'          => 'text',
            'url'           => 'text',
            'nome'          => 'text',
            'email'         => 'text',
            'conteudo'      => 'text',
            'created_at'    => 'text',
            'updated_at'    => 'text',
            'deleted_at'    => 'text',
        ],
        'users' => [
            'id'            => 'integer not null',
            'nome'          => 'text',
            'email'         => 'text',
            'ip'            => 'text',
            'created_at'    => 'text',
            'updated_at'    => 'text',
            'deleted_at'    => 'text',
        ]
    ];


    /**
     * @return void
     */
    protected function connectionOrCreate(){
        $this->filename = __DIR__ . "/comments.db";

        if (file_exists($this->filename)) {
            $this->connectSqlite();
        } else {
            $this->createDatabase();
        }
    }


    /**
     * @return void
     */
    private function createDatabase() {
        file_put_contents($this->filename, '');

        $this->connectSqlite();
        $this->createTables();
    }


    private function createTables() {
        foreach($this->sql as $table => $columns) {
            $colunas = array_map(function ($item, $key) {
                return "$key $item";
            }, $columns, array_keys($columns));

            $sql = "CREATE TABLE IF NOT EXISTS {$table} (".implode(',', $colunas).", primary key('id'))";

            $this->connectSqlite();

            $this->connection->exec($sql);
        }
    }


    /**
     * @return void
     */
    protected function connectSqlite() {
        $this->connection = new PDO("sqlite:{$this->filename}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


}
