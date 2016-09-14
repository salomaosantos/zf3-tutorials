<?php

namespace Blog\Controller;

use Blog\Model\PostRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use InvalidArgumentException;

class ListController extends AbstractActionController
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;


    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postRepository->findAllPosts(),
        ]);
    }

	public function detailAction()
	{
	    $id = $this->params()->fromRoute('id');

	    try {
	        $post = $this->postRepository->findPost($id);
	    } catch (\InvalidArgumentException $ex) {
	        return $this->redirect()->toRoute('blog');
	    }

	    return new ViewModel([
	        'post' => $post,
	    ]);
	}     
}