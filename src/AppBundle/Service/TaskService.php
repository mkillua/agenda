<?php
/**
 * Created by PhpStorm.
 * User: viking
 * Date: 15/11/16
 * Time: 12:41
 */

namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\Task;

class TaskService
{
    protected $em;
    protected $container;


    /**
     * @InjectParams
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createTask($params)
    {
        $product = new Task();
        $product->setName($params['name']);
        $product->setStatus($params['status']);
        $product->setUser($params['user']);
        $product->setDate(new \DateTime());
        $this->em->persist($product);
        return $this->em->flush();
    }

    public function getAllTasks()
    {
        return $this->em->getRepository('AppBundle:Task')->findAll();
    }

    public function removeTask($taskId)
    {
        $task =  $this->em->getRepository('AppBundle:Task')->find($taskId);
        $this->em->remove($task);
        return $this->em->flush();
    }
}