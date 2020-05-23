<?php


namespace App\Service\Book;


use App\Entity\Rate;
use App\Entity\User;
use App\Repository\RateRepository;
use App\Service\AbstractService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RateService extends AbstractService
{
    private $bookService;
    private $translator;

    public function __construct(EntityManagerInterface $em, BookService $bookService, TranslatorInterface $translator)
    {
        parent::__construct(Rate::class, $em);
        $this->bookService = $bookService;
        $this->translator = $translator;
    }

    /**
     * @param User $user
     * @param $bookId
     * @param $value
     */
    public function upsertRate(User $user, $bookId, $value)
    {
        $book = $this->bookService->getBook($bookId);
        $rate =  $this->getRepository()->findOneBy([
            'user' => $user,
            'book' => $book
        ]);
        if ($rate) {
            $rate->setValue($value);
        } else {
            $rate = new Rate();
            $rate->setBook($book);
            $rate->setUser($user);
            $rate->setValue($value);
        }
        $this->save($rate);
    }

    protected function getRepository(): RateRepository
    {
        return parent::getRepository();
    }
}