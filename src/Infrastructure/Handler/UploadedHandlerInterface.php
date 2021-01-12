<?php

namespace App\Infrastructure\Handler;

interface UploadedHandlerInterface
{

    public function handle(array $files);
}
