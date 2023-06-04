<?php

namespace App\Service;

use Intervention\Image\ImageManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageConverter
{

    private Filesystem   $filesystem;

    private ImageManager $manager;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->manager    = new ImageManager(['driver' => 'imagick']);
    }

    public function getWebpUploadedFile(string $absolutePath, string $filename): ?UploadedFile
    {
        if (!is_file($absolutePath)) {
            return null;
        }
        if ('image/webp' === mime_content_type($absolutePath)) {
            return null;
        }

        $newFileName  = pathinfo($filename, PATHINFO_FILENAME) . '.webp';

        $tmp = $this->filesystem->tempnam('/tmp', 'vich_webp_');
        $img = $this->manager->make($absolutePath);
        $img->save($tmp, 100, 'webp');

        unlink($absolutePath);

        return new UploadedFile(path: $tmp, originalName: $newFileName, test: true);
    }
}
