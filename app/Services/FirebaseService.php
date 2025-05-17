<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected Database $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->database = $factory->createDatabase();
    }

    public function getData(string $node): mixed
    {
        return $this->database->getReference($node)->getValue();
    }

    public function storeData($path, $data)
    {
        return $this->database->getReference($path)->push($data);
    }

    public function getDataById($path, $id)
    {
        $snapshot = $this->database->getReference("$path/$id")->getSnapshot();
        return $snapshot->getValue();
    }

    public function updateData($path, $id, array $data)
    {
        return $this->database->getReference("$path/$id")->update($data);
    }

    public function setValue($path, $value)
    {
        return $this->database->getReference($path)->set($value);
    }

    public function deleteData($path, $id)
    {
        return $this->database->getReference("$path/$id")->remove();
    }
}
