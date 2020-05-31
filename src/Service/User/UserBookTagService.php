<?php

namespace App\Service\User;

use App\Entity\User;
use App\Entity\UserBook;
use App\Entity\UserBookTag;
use App\Enum\Status;
use App\Model\BaseFilterModel;
use App\Repository\UserBookTagRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Service\Book\BookService;
use App\Util\ExceptionUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserBookTagService extends AbstractService
{
    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        parent::__construct(UserBookTag::class, $em);
        $this->translator = $translator;
    }

    public function saveUserBookTag(User $user, UserBookTag $userBookTag)
    {
        try {
            $userBookTag->setUser($user);
            $this->save($userBookTag);
            return $userBookTag;
        }
        catch (UniqueConstraintViolationException $error)
        {
            ExceptionUtil::throwException(JsonFailureResponse::build()
            ->setMessage($this->translator->trans('error.user_book.tag.already_exists'))
            ->setStatusCode(Response::HTTP_CONFLICT));
        }
    }

    public function updateUserBookTag(User $user, UserBookTag $userBookTag)
    {
        return $this->saveUserBookTag($user, $userBookTag);
    }

    public function getUserBookTags(User $user, BaseFilterModel $filterModel): Array
    {
         return $this->getRepository()->getUserBookTags($user, $filterModel);
    }

    public function getUserBookTagsCount(User $user, BaseFilterModel $filterModel): int
    {
        return $this->getRepository()->getUserBookTagsCount($user, $filterModel);
    }

    public function getUserBookTag(User $user, int $userBookTagId): UserBookTag
    {
        $userBookTag = $this->getRepository()->findOneBy([
            "id" => $userBookTagId,
            "user" => $user
        ]);

        if(!$userBookTag)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.user_book.tag.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return $userBookTag;
    }

    public function deleteUserBookTag(User $user, int $userBookTagId)
    {
        $userBookList = $this->getUserBookTag($user, $userBookTagId);
        $this->delete($userBookList);
    }

    protected function getRepository(): UserBookTagRepository
    {
        return parent::getRepository();
    }
}
