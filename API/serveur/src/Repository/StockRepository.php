<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Stock::class);
        $this->manager = $manager;
    }

    public function saveStock($book, $count, $library, $adress, $city, $zip_code)
    {
        $newStock = new Stock();

        $newStock
            ->setCount($count)
            ->setLibrary($library)
            ->setAdress($adress)
            ->setCity($city)
            ->setZipCode($zip_code)
            ->setBook($book);

        $this->manager->persist($newStock);
        $this->manager->flush();
    }

    public function updateStockCount(Stock $stock)
    {
        $count = $stock->getCount() - 1;
        $stock->setCount($count);
        $this->manager->persist($stock);
        $this->manager->flush();
    }

    public function findStock($book, $stock)
    {
        $q = $this->createQueryBuilder('p')
            ->where('p.book = :book')
            ->andWhere('p.id = :stock')
            ->andWhere("p.count >= :count")
            ->setParameter('book', $book)
            ->setParameter('stock', $stock)
            ->setParameter('count', 1);

        $query = $q->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }

}
