<?php

namespace App\MessageHandler;

use App\Message\ReviewMessage;
use App\Repository\ReviewRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ReviewMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SpamChecker $spamChecker,
        private ReviewRepository $reviewRepository,
    ) {
    }

    /**
     * @param ReviewMessage $message
     * @return void
     */
    public function __invoke(ReviewMessage $message): void
    {
        $review = $this->reviewRepository->find($message->getId());
        if (!$review) {
            return;
        }

        if (2 === $this->spamChecker->getSpamScore($review, $message->getContext())) {
            $review->setState('spam');
        } else {
            $review->setState('published');
        }

        $this->entityManager->flush();
    }
}