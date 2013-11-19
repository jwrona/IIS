<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
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
