<?php

namespace App\Infrastructure\Handler;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProcessFilesHandlerInterface
{

    public function handle(UploadedFile $file);
}
