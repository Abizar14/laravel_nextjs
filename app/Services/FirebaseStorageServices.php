<?php

namespace App\Services;

use Kreait\Firebase;
use Google\Cloud\Storage\StorageClient;

class FirebaseStorageService
{
    protected $firebase;
    protected $storage;

    public function __construct()
    {
        $serviceAccount = __DIR__ . '/../../firebase/service-account.json'; // Path ke kunci akun layanan Firebase Anda
        $this->firebase = (new Firebase\Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $storageClient = new StorageClient([
            'projectId' => config('firebase.project_id'),
            'keyFile' => $serviceAccount,
        ]);
        $this->storage = $storageClient->bucket(config('firebase.storage_bucket'));
    }

    public function uploadFile($file, $path)
    {
        $object = $this->storage->upload(
            fopen($file->getRealPath(), 'r'),
            ['name' => $path . '/' . $file->getClientOriginalName()]
        );

        return $object->info()['mediaLink'];
    }

    public function deleteFile($path)
    {
        $object = $this->storage->object($path);
        if ($object->exists()) {
            $object->delete();
            return true;
        }
        return false;
    }
}
