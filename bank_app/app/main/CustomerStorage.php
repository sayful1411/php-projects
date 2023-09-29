<?php 

namespace App\Main;

class CustomerStorage implements Storage
{
    public function save(string $model, array $data): void
    {
        $serializedData = serialize($data);
        file_put_contents($this->getModelPath($model), $serializedData . PHP_EOL);
    }

    public function load(string $model): array
    {
        if(file_exists($this->getModelPath($model))){
            $data = unserialize(file_get_contents($this->getModelPath($model)));
        }

        if(!is_array($data)){
            return [];
        }

        return $data;
    }

    public function getModelPath(string $model)
    {
        return __DIR__ . '/../data/' . $model . ".txt";
    }
}