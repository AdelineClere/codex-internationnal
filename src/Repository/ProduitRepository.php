<?php
namespace App\Repository;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    
    public function getProductsByCategory($category)
    {
        return $this->createCategoryQB($category)->getQuery()->getResult();
    }
    
    public function createCategoryQB($category)
    {
        return $this->createQueryBuilder('p')
                ->leftJoin('p.category', 'c')
                ->where('c = :category')
                ->setParameter('category', $category);
    }
    
    public function findAllByProduit($search) {
        return $this->createQueryBuilder('p')
                ->innerJoin('p.translations', 'pt')
                ->innerJoin('p.category', 'c')
                ->innerJoin('c.translations', 'ct')
                ->Where('pt.nom LIKE :search ')
                ->setParameter('search', "%$search%")
                ->getQuery()
                ->getResult();
    }
//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}