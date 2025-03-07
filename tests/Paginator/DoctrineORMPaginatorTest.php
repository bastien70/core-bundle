<?php

declare(strict_types=1);

namespace Leapt\CoreBundle\Tests\Paginator;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Leapt\CoreBundle\Paginator\DoctrineORMPaginator;
use Leapt\CoreBundle\Paginator\PaginatorInterface;
use Leapt\CoreBundle\Tests\Paginator\Entity\Player;
use Leapt\CoreBundle\Tests\Paginator\Fixtures\LoadPlayerData;

class DoctrineORMPaginatorTest extends AbstractPaginatorTest
{
    protected static EntityManagerInterface $em;

    public static function setUpBeforeClass(): void
    {
        $dbParams = [
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ];

        $config = ORMSetup::createAnnotationMetadataConfiguration([static::getEntityPath()], false);
        $config->setMetadataDriverImpl(new AttributeDriver([static::getEntityPath()]));

        $proxiesIdentifier = uniqid('Proxies', true);
        $config->setProxyDir(sys_get_temp_dir() . '/' . $proxiesIdentifier);
        $config->setProxyNamespace('MyProject\Proxies\\' . $proxiesIdentifier);
        $config->setAutoGenerateProxyClasses(true);

        $em = EntityManager::create($dbParams, $config);

        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);

        $classes = array_map(function ($className) use ($em) {
            return $em->getClassMetadata($className);
        }, static::getEntityClasses());
        $tool->createSchema($classes);

        static::$em = $em;
    }

    public function testIteration(): void
    {
        $this->assertTrue(true);
    }

    protected function buildPaginator(int $limit): PaginatorInterface
    {
        $this->loadFixture(new LoadPlayerData($limit));
        $dql = <<<DQL
            SELECT p FROM Leapt\CoreBundle\Tests\Paginator\Entity\Player p
DQL;
        $query = static::$em->createQuery($dql)->setMaxResults($limit);

        return new DoctrineORMPaginator($query);
    }

    protected function loadFixture(FixtureInterface $fixture): void
    {
        $loader = new Loader();
        $loader->addFixture($fixture);
        $purger = new ORMPurger();
        $executor = new ORMExecutor(static::$em, $purger);
        $executor->execute($loader->getFixtures());
    }

    protected static function getEntityClasses(): array
    {
        return [Player::class];
    }

    protected static function getEntityPath(): string
    {
        return __DIR__ . '/Entity';
    }
}
