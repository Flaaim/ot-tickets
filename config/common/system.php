<?php

declare(strict_types=1);

use App\Product\Entity\File\FileSystem;
use App\Product\Entity\File\UploadDirectory;
use App\Product\Service\MimeTypeMapper;
use App\Product\Service\Uploader;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory;

return [
    'config' => [
        'debug' => (bool)getenv('APP_DEBUG'),
        'upload_directory' => $_ENV['UPLOAD_DIRECTORY'],
        'mimeTypes' => [
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
        ],
    ],


    ResponseFactoryInterface::class => Di\get(ResponseFactory::class),

    MimeTypeMapper::class => function (ContainerInterface $container) {
        return new MimeTypeMapper($container->get('config')['mimeTypes']);
    },
    UploadDirectory::class => function (ContainerInterface $container) {
        return new UploadDirectory(
                $_ENV['UPLOAD_DIRECTORY'],
                new FileSystem(),
        );
    },
];
