<?php

namespace app;

class Database
{
    public function __invoke()
    {
        \Doctrine\DBAL\Types\Type::addType('ipv4', 'entity\DoctrineTypes\IPv4Type');
        $doctrine_paths = [ROOT_DIR . '/entity'];
        $dbParams = [
            'driver'   => DB_DRIVER,
            'user'     => DB_USER,
            'password' => DB_PASSWORD,
            'dbname'   => DB_NAME,
            'host' => DB_HOST
        ];
        $doctrine_config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($doctrine_paths, DEV_MODE);
        $entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $doctrine_config);
        $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('INT', 'ipv4');

        return $entityManager;
    }

    public static function entityManagerGetRepository($class)
    {
        global $container;
        return $container['DoctrineEntityManager']->getRepository('entity\\' . $class);
    }
}
