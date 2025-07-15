<?php

namespace App\Service;

use Google\Cloud\Storage\StorageClient;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GcsUploader
{
    private StorageClient $storage;
    private string $bucketName;

    public function __construct(string $bucketName, string $keyFilePath)
    {
        $this->storage = new StorageClient([
            'keyFilePath' => $keyFilePath,
        ]);

        $this->bucketName = $bucketName;
    }

    public function upload(UploadedFile $file, string $destinationFolder = 'documents'): string
    {
        $bucket = $this->storage->bucket($this->bucketName);

        $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
        $objectName = $destinationFolder . '/' . $uniqueName;

        $bucket->upload(
            fopen($file->getPathname(), 'r'),
            ['name' => $objectName]
        );

        return $objectName;
    }

    public function generateSignedUrl(string $objectPath, string $duration = '+15 minutes'): string
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->object($objectPath);

        return $object->signedUrl(
            new \DateTime($duration), // durée de validité
            ['version' => 'v4']
        );
    }

    public function delete(string $objectPath): void
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->object($objectPath);

        if ($object->exists()) {
            $object->delete();
        }
    }
}
