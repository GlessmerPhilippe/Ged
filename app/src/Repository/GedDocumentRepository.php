<?php

namespace App\Repository;

use App\Entity\GedDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GedDocument>
 */
class GedDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GedDocument::class);
    }

    /**
     * Search documents by multiple optional criteria.
     *
     * @param array $criteria
     *      Possible keys: title, date, tags, person (array), categorie, ItemCategorie
     * @return GedDocument[]
     */
    public function searchByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.person', 'p')
            ->leftJoin('d.categorie', 'c')
            ->leftJoin('d.ItemCategorie', 'ic')
            ->addSelect('p', 'c', 'ic');

        if (!empty($criteria['title'])) {
            $qb->andWhere('d.title LIKE :title')
               ->setParameter('title', '%' . $criteria['title'] . '%');
        }

        if (!empty($criteria['date'])) {
            $qb->andWhere('d.date = :date')
               ->setParameter('date', $criteria['date']);
        }

        if (!empty($criteria['tags'])) {
            // Assuming tags is a comma separated string, search for any tag in the array
            $tags = array_map('trim', explode(',', $criteria['tags']));
            $orX = $qb->expr()->orX();
            foreach ($tags as $key => $tag) {
                $orX->add('JSON_CONTAINS(d.tags, :tag' . $key . ') = 1');
                $qb->setParameter('tag' . $key, json_encode($tag));
            }
            $qb->andWhere($orX);
        }

        if (!empty($criteria['person']) && is_array($criteria['person'])) {
            $qb->andWhere('p.id IN (:personIds)')
               ->setParameter('personIds', $criteria['person']);
        }

        if (!empty($criteria['categorie'])) {
            $qb->andWhere('c.id = :categorieId')
               ->setParameter('categorieId', $criteria['categorie']);
        }

        if (!empty($criteria['ItemCategorie'])) {
            $qb->andWhere('ic.id = :itemCategorieId')
               ->setParameter('itemCategorieId', $criteria['ItemCategorie']);
        }

        return $qb->getQuery()->getResult();
    }
}
