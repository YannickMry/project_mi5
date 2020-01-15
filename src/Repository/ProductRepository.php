<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Requête permettant de récupérer des objets en base de donnée comprenant 
     * dans le libelle ou dans le texte notre mot/phrase de notre variable texte 
     * transmise en paramètre
     *
     * @param string $texte Texte à rechercher
     * @return void
     */
    public function findByProductNameAndText(string $texte){
        return $this->createQueryBuilder('p')
            ->where('p.texte LIKE :texte OR p.libelle LIKE :libelle')
            ->setParameters(['libelle' => $texte.'%', 'texte' => '%'.$texte.'%'])
            ->orderBy('p.libelle', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findBestSale($maxResults)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('SUM(l.quantite) as nbVente')
            ->join('p.ligneCommandes', 'l')
            ->orderBy('nbVente', 'DESC')
            ->groupBy('p.id')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
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
    public function findOneBySomeField($value): ?Product
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
