<?php


namespace App\Services;



use App\Models\MessageHistory;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class NsApiHistoryHandler
{
    /**
     * @var
     */
    private $manager;

    /**
     * NsApiHistoryHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $numberFrom
     * @param $numberTo
     * @param $type
     * @param $message
     * @param null $status
     * @param null $platform
     * @return bool|Response
     */
    public function addMessage($numberFrom , $numberTo, $type, $message, $status = null, $platform = null)
    {
       $messageHistory = new MessageHistory();

       $messageHistory->setNumberFrom($numberFrom);
       $messageHistory->setNumberTo($numberTo);
       $messageHistory->setType($type);
       $messageHistory->setMessage($message);
       $messageHistory->setPlatform($platform);
       $messageHistory->setStatus($status);
        try {
            $this->manager->persist($messageHistory);

        } catch (ORMException $e) {
            return new Response($e->getMessage());
        }

        try {
            $this->manager->flush();
        } catch (OptimisticLockException $e) {

            return new Response($e->getMessage());
        } catch (ORMException $e) {

            return new Response($e->getMessage());
        }

        return true;
    }

}