<?php

/**
 * Homepage presenter.
 */
class NavigationPresenter extends BasePresenter
{

        /** @var Todo\TaskRepository */
        //private $taskRepository;

        protected function startup()
        {
          parent::startup();

          if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
          }
        }
}