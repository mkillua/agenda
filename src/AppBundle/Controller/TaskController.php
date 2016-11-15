<?php
/**
 * Created by PhpStorm.
 * User: viking
 * Date: 15/11/16
 * Time: 12:41
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\TaskService;

class TaskController extends Controller
{
    private $message;

    /**
     * @Route("task/new",name="create_task")
     * @Method("POST")
     */
    public function createTask(Request $request)
    {
        $taskService = $this->get('TaskService');
        $taskService->createTask($request->request->all());
        return $this->redirectToRoute('index_route', ['message' => 'tarefa criada com sucesso']);
    }

    /**
     * @Route("/",name="index_route")
     * @Method("GET")
     */
    public function index(Request $request)
    {
        if ($request->query->get('message')) {
            $this->message = $request->query->get('message');
        }
        return $this->render('task/create.html.twig', ['message' => $this->message]);
    }

    /**
     * @Route("/task",name="all_tasks")
     * @Method("GET")
     */
    public function getAllTasks(Request $request)
    {
        $taskService = $this->get('TaskService');
        $tasks = $taskService->getAllTasks();

        if ($request->query->get('message')) {
            $this->message = $request->query->get('message');
        }
        return $this->render('task/list.html.twig', ['tasks' => $tasks,'message'=>$this->message]);
    }

    /**
     * @Route("/task/remove/{id}",name="remove_task")
     * @Method("GET")
     */
    public function deleteTask($id)
    {
        $taskService = $this->get('TaskService');
        $tasks = $taskService->removeTask($id);
        return $this->redirectToRoute('all_tasks', ['message' => 'Tarefa Excluida com sucesso']);
    }
}