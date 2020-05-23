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
        try
        {
            $newRate = new Rate();
            $newRate->setBook($book);
            $newRate->setUser($user);
            $newRate->setValue($value);
            $this->save($newRate);
        }
        catch (UniqueConstraintViolationException $exception)
        {
            $rate =  $this->getRepository()->findOneBy([
                'user' => $user,
                'book' => $book
            ]);
            $rate->setValue($value);
            $this->save($rate);
        }
    }

    protected function getRepository(): RateRepository
    {
        return parent::getRepository();
    }
}