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
	$this->checkLoggedIn();
    }
}
