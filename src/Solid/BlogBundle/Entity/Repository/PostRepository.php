<?php

namespace Solid\BlogBundle\Entity\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @return Query
     */
    public function getQueryForGet()
    {
        return $this->createQueryBuilder('p')
                ->leftJoin('p.author', 'a')
                ->where('p.deletedAt IS NULL')
                ->addOrderBy('p.createdAt', 'DESC')
                ->getQuery();
    }

    /**
     * @param string $slug
     *
     * @return \Solid\BlogBundle\Entity\Post
     */
    public function getArticleBySlug($slug = '')
    {
        return $this->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param string $name
     *
     * @return \Solid\BlogBundle\Entity\Post | null
     */
    public function getArticleByName($name = '')
    {
        try {
             $this->createQueryBuilder('p')
                ->where('p.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }


}
