<?php


namespace App\Service\Book;


use App\Entity\Rate;
use App\Repository\RateRepository;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RateService extends AbstractService
{
    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        parent::__construct(Rate::class, $em);
        $this->translator = $translator;
    }

    /**
     * @param $bookId
     * @return int
     */
    public function getRateByBookId($bookId)
    {
        return $this->getRepository()->getRateByBookId($bookId);
    }

    protected function getRepository() : RateRepository
    {
        return parent::getRepository();
    }
}