<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Offer;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PDO;

/**
 * Class OfferRepository
 * @package AppBundle\Repository
 */
class OfferRepository extends EntityRepository
{
    public function createOffer($offer)
    {
        $this->_em->persist($offer);
        $this->_em->flush();

        return $this->getOffer($offer->getId());
    }

    /**
     * @param int $page
     * @param int $maxResult
     * @return array
     */
    public function getOffers($page = 1, $maxResult = 20)
    {
        $conn = $this->_em->getConnection();

        $limitStart = ($page - 1) * $maxResult;

        $query = '  SELECT id, title, description, email, image_url, created_at
                    FROM offer
                    WHERE is_deleted <> 1
                    ORDER BY id DESC 
                    LIMIT :limitStart, :limitEnd';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('limitStart',$limitStart, PDO::PARAM_INT);
        $stmt->bindParam('limitEnd',$maxResult, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOffer(int $id)
    {
        $conn = $this->_em->getConnection();

        $query = '  SELECT id, title, description, email, image_url, created_at
                    FROM offer
                    WHERE id = :id
                    AND is_deleted <> 1
                    LIMIT 1';

        /** @var Statement $stmt */
        $stmt = $conn->prepare($query);
        $stmt->bindParam('id',$id,  PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $offer
     * @return array
     */
    public function updateOffer($offer)
    {
        $this->_em->merge($offer);
        $this->_em->flush();

        return $this->getOffer($offer->getId());
    }

    public function deleteOffer($offerId)
    {
        /** @var Offer $offer */
        $offer = $this->findOneBy(['id' => $offerId, 'isDeleted' => 0]);
        if(!$offer) {
            return false;
        }
        $offer->setIsDeleted(1);
        $this->_em->persist($offer);
        $this->_em->flush();
        return $this->_em->contains($offer);
    }
}
