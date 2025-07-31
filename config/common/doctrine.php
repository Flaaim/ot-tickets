<?php


declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;


return [
    EntityManagerInterface::class => function (ContainerInterface $container): EntityManagerInterface {
        $settings = $container->get('config')['doctrine'];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache_dir'],
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        $connection = DriverManager::getConnection(
            $settings['connection'],
            $config
        );

        return new EntityManager($connection, $config);
    },
    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => $_ENV['DB_HOST'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'dbname' => $_ENV['DB_NAME'],
                'charset' => 'utf-8'
            ],
            'metadata_dirs' => [],
        ],
    ],
    EntityManagerProvider::class => function (ContainerInterface $container): SingleManagerProvider {
        return new SingleManagerProvider($container->get(EntityManagerInterface::class));
    },
];
