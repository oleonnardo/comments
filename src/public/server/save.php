<?php

session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

$database = new \Leonardo\Comments\Facades\Database();

if (empty($_POST['requestURL']) || empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['comentario'])) {
    \Leonardo\Comments\Http\Request::redirect('../?errors[]=Alguns campos são obrigatórios!');
    exit();
}

$database->createComment([
    'uuid'          => base64_encode($_POST['requestURL']),
    'url'           => $_POST['requestURL'],
    'nome'          => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
    'email'         => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
    'conteudo'      => $_POST['comentario'],
    'created_at'    => date('Y-m-d H:i:s'),
    'updated_at'    => null,
    'deleted_at'    => null
]);

$database->createUser([
    'nome'          => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
    'email'         => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
    'ip'            => \Leonardo\Comments\Http\Request::ip(),
    'created_at'    => date('Y-m-d H:i:s'),
    'updated_at'    => null,
    'deleted_at'    => null
]);

\Leonardo\Comments\CommentPlugin::renderSpinning();
\Leonardo\Comments\Http\Request::redirect('../', 3000);
