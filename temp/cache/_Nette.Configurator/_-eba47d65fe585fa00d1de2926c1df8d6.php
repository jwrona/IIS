<?php //netteCache[01]000404a:2:{s:4:"time";s:21:"0.94638300 1384951204";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:64:"/home/users/xw/xwrona00/WWW/nette/projekt/app/config/config.neon";i:2;i:1384951010;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:70:"/home/users/xw/xwrona00/WWW/nette/projekt/app/config/config.local.neon";i:2;i:1384863664;}}}?><?php
// source: /home/users/xw/xwrona00/WWW/nette/projekt/app/config/config.neon production
// source: /home/users/xw/xwrona00/WWW/nette/projekt/app/config/config.local.neon 

/**
 * @property Nette\Application\Application $application
 * @property Todo\Authenticator $authenticator
 * @property Nette\Caching\Storages\FileStorage $cacheStorage
 * @property Nette\DI\NestedAccessor $constants
 * @property Nette\DI\Container $container
 * @property Nette\Http\Request $httpRequest
 * @property Nette\Http\Response $httpResponse
 * @property SystemContainer_nette $nette
 * @property Todo\PacientRepository $pacientRepository
 * @property Nette\DI\NestedAccessor $php
 * @property Nette\Application\IRouter $router
 * @property RouterFactory $routerFactory
 * @property Nette\Http\Session $session
 * @property Nette\Security\User $user
 * @property Todo\UvazekRepository $uvazekRepository
 * @property Todo\ZamestnanecRepository $zamestnanecRepository
 */
class SystemContainer extends Nette\DI\Container
{

	public $classes = array(
		'nette\\object' => FALSE, //: nette.cacheJournal, cacheStorage, nette.httpRequestFactory, httpRequest, httpResponse, nette.httpContext, session, nette.userStorage, user, application, nette.presenterFactory, nette.mailer, nette.database, uvazekRepository, pacientRepository, zamestnanecRepository, authenticator, container,
		'nette\\caching\\storages\\ijournal' => 'nette.cacheJournal',
		'nette\\caching\\storages\\filejournal' => 'nette.cacheJournal',
		'nette\\caching\\istorage' => 'cacheStorage',
		'nette\\caching\\storages\\filestorage' => 'cacheStorage',
		'nette\\http\\requestfactory' => 'nette.httpRequestFactory',
		'nette\\http\\irequest' => 'httpRequest',
		'nette\\http\\request' => 'httpRequest',
		'nette\\http\\iresponse' => 'httpResponse',
		'nette\\http\\response' => 'httpResponse',
		'nette\\http\\context' => 'nette.httpContext',
		'nette\\http\\session' => 'session',
		'nette\\security\\iuserstorage' => 'nette.userStorage',
		'nette\\http\\userstorage' => 'nette.userStorage',
		'nette\\security\\user' => 'user',
		'nette\\application\\application' => 'application',
		'nette\\application\\ipresenterfactory' => 'nette.presenterFactory',
		'nette\\application\\presenterfactory' => 'nette.presenterFactory',
		'nette\\application\\irouter' => 'router',
		'nette\\mail\\imailer' => 'nette.mailer',
		'nette\\mail\\sendmailmailer' => 'nette.mailer',
		'nette\\di\\nestedaccessor' => 'nette.database',
		'pdo' => 'nette.database.default',
		'nette\\database\\connection' => 'nette.database.default',
		'todo\\repository' => FALSE, //: uvazekRepository, pacientRepository, zamestnanecRepository,
		'todo\\uvazekrepository' => 'uvazekRepository',
		'todo\\pacientrepository' => 'pacientRepository',
		'todo\\zamestnanecrepository' => 'zamestnanecRepository',
		'routerfactory' => 'routerFactory',
		'nette\\security\\iauthenticator' => 'authenticator',
		'todo\\authenticator' => 'authenticator',
		'nette\\freezableobject' => 'container',
		'nette\\ifreezable' => 'container',
		'nette\\di\\icontainer' => 'container',
		'nette\\di\\container' => 'container',
	);

	public $meta = array();


	public function __construct()
	{
		parent::__construct(array(
			'appDir' => '/home/users/xw/xwrona00/WWW/nette/projekt/app',
			'wwwDir' => '/homes/eva/xw/xwrona00/WWW/nette/projekt/www',
			'debugMode' => FALSE,
			'productionMode' => TRUE,
			'environment' => 'production',
			'consoleMode' => FALSE,
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => 'Nette\\DI\\Container',
			),
			'tempDir' => '/home/users/xw/xwrona00/WWW/nette/projekt/app/../temp',
		));
	}


	/**
	 * @return Nette\Application\Application
	 */
	protected function createServiceApplication()
	{
		$service = new Nette\Application\Application($this->getService('nette.presenterFactory'), $this->getService('router'), $this->getService('httpRequest'), $this->getService('httpResponse'));
		$service->catchExceptions = TRUE;
		$service->errorPresenter = 'Error';
		Nette\Application\Diagnostics\RoutingPanel::initializePanel($service);
		return $service;
	}


	/**
	 * @return Todo\Authenticator
	 */
	protected function createServiceAuthenticator()
	{
		$service = new Todo\Authenticator($this->getService('zamestnanecRepository'));
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\FileStorage
	 */
	protected function createServiceCacheStorage()
	{
		$service = new Nette\Caching\Storages\FileStorage('/home/users/xw/xwrona00/WWW/nette/projekt/app/../temp/cache', $this->getService('nette.cacheJournal'));
		return $service;
	}


	/**
	 * @return Nette\DI\NestedAccessor
	 */
	protected function createServiceConstants()
	{
		$service = new Nette\DI\NestedAccessor($this, 'constants');
		return $service;
	}


	/**
	 * @return Nette\DI\Container
	 */
	protected function createServiceContainer()
	{
		return $this;
	}


	/**
	 * @return Nette\Http\Request
	 */
	protected function createServiceHttpRequest()
	{
		$service = $this->getService('nette.httpRequestFactory')->createHttpRequest();
		if (!$service instanceof Nette\Http\Request) {
			throw new Nette\UnexpectedValueException('Unable to create service \'httpRequest\', value returned by factory is not Nette\\Http\\Request type.');
		}
		return $service;
	}


	/**
	 * @return Nette\Http\Response
	 */
	protected function createServiceHttpResponse()
	{
		$service = new Nette\Http\Response;
		return $service;
	}


	/**
	 * @return Nette\DI\NestedAccessor
	 */
	protected function createServiceNette()
	{
		$service = new Nette\DI\NestedAccessor($this, 'nette');
		return $service;
	}


	/**
	 * @return Nette\Forms\Form
	 */
	public function createNette__basicForm()
	{
		$service = new Nette\Forms\Form;
		return $service;
	}


	/**
	 * @return Nette\Callback
	 */
	protected function createServiceNette__basicFormFactory()
	{
		$service = new Nette\Callback($this, 'createNette__basicForm');
		return $service;
	}


	/**
	 * @return Nette\Caching\Cache
	 */
	public function createNette__cache($namespace = NULL)
	{
		$service = new Nette\Caching\Cache($this->getService('cacheStorage'), $namespace);
		return $service;
	}


	/**
	 * @return Nette\Callback
	 */
	protected function createServiceNette__cacheFactory()
	{
		$service = new Nette\Callback($this, 'createNette__cache');
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\FileJournal
	 */
	protected function createServiceNette__cacheJournal()
	{
		$service = new Nette\Caching\Storages\FileJournal('/home/users/xw/xwrona00/WWW/nette/projekt/app/../temp');
		return $service;
	}


	/**
	 * @return Nette\DI\NestedAccessor
	 */
	protected function createServiceNette__database()
	{
		$service = new Nette\DI\NestedAccessor($this, 'nette.database');
		return $service;
	}


	/**
	 * @return Nette\Database\Connection
	 */
	protected function createServiceNette__database__default()
	{
		$service = new Nette\Database\Connection('mysql:unix_socket=/var/run/mysql/mysql.sock;dbname=xwrona00', 'xwrona00', 'a6tumrem', NULL);
		$service->setCacheStorage($this->getService('cacheStorage'));
		Nette\Diagnostics\Debugger::$blueScreen->addPanel('Nette\\Database\\Diagnostics\\ConnectionPanel::renderException');
		$service->setDatabaseReflection(new Nette\Database\Reflection\DiscoveredReflection($this->getService('cacheStorage')));
		return $service;
	}


	/**
	 * @return Nette\Http\Context
	 */
	protected function createServiceNette__httpContext()
	{
		$service = new Nette\Http\Context($this->getService('httpRequest'), $this->getService('httpResponse'));
		return $service;
	}


	/**
	 * @return Nette\Http\RequestFactory
	 */
	protected function createServiceNette__httpRequestFactory()
	{
		$service = new Nette\Http\RequestFactory;
		$service->setEncoding('UTF-8');
		return $service;
	}


	/**
	 * @return Nette\Latte\Engine
	 */
	public function createNette__latte()
	{
		$service = new Nette\Latte\Engine;
		return $service;
	}


	/**
	 * @return Nette\Callback
	 */
	protected function createServiceNette__latteFactory()
	{
		$service = new Nette\Callback($this, 'createNette__latte');
		return $service;
	}


	/**
	 * @return Nette\Mail\Message
	 */
	public function createNette__mail()
	{
		$service = new Nette\Mail\Message;
		$service->setMailer($this->getService('nette.mailer'));
		return $service;
	}


	/**
	 * @return Nette\Callback
	 */
	protected function createServiceNette__mailFactory()
	{
		$service = new Nette\Callback($this, 'createNette__mail');
		return $service;
	}


	/**
	 * @return Nette\Mail\SendmailMailer
	 */
	protected function createServiceNette__mailer()
	{
		$service = new Nette\Mail\SendmailMailer;
		return $service;
	}


	/**
	 * @return Nette\Application\PresenterFactory
	 */
	protected function createServiceNette__presenterFactory()
	{
		$service = new Nette\Application\PresenterFactory('/home/users/xw/xwrona00/WWW/nette/projekt/app', $this);
		return $service;
	}


	/**
	 * @return Nette\Templating\FileTemplate
	 */
	public function createNette__template()
	{
		$service = new Nette\Templating\FileTemplate;
		$service->registerFilter($this->createNette__latte());
		$service->registerHelperLoader('Nette\\Templating\\Helpers::loader');
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\PhpFileStorage
	 */
	protected function createServiceNette__templateCacheStorage()
	{
		$service = new Nette\Caching\Storages\PhpFileStorage('/home/users/xw/xwrona00/WWW/nette/projekt/app/../temp/cache', $this->getService('nette.cacheJournal'));
		return $service;
	}


	/**
	 * @return Nette\Callback
	 */
	protected function createServiceNette__templateFactory()
	{
		$service = new Nette\Callback($this, 'createNette__template');
		return $service;
	}


	/**
	 * @return Nette\Http\UserStorage
	 */
	protected function createServiceNette__userStorage()
	{
		$service = new Nette\Http\UserStorage($this->getService('session'));
		return $service;
	}


	/**
	 * @return Todo\PacientRepository
	 */
	protected function createServicePacientRepository()
	{
		$service = new Todo\pacientRepository($this->getService('nette.database.default'));
		if (!$service instanceof Todo\PacientRepository) {
			throw new Nette\UnexpectedValueException('Unable to create service \'pacientRepository\', value returned by factory is not Todo\\PacientRepository type.');
		}
		return $service;
	}


	/**
	 * @return Nette\DI\NestedAccessor
	 */
	protected function createServicePhp()
	{
		$service = new Nette\DI\NestedAccessor($this, 'php');
		return $service;
	}


	/**
	 * @return Nette\Application\IRouter
	 */
	protected function createServiceRouter()
	{
		$service = $this->getService('routerFactory')->createRouter();
		if (!$service instanceof Nette\Application\IRouter) {
			throw new Nette\UnexpectedValueException('Unable to create service \'router\', value returned by factory is not Nette\\Application\\IRouter type.');
		}
		return $service;
	}


	/**
	 * @return RouterFactory
	 */
	protected function createServiceRouterFactory()
	{
		$service = new RouterFactory;
		return $service;
	}


	/**
	 * @return Nette\Http\Session
	 */
	protected function createServiceSession()
	{
		$service = new Nette\Http\Session($this->getService('httpRequest'), $this->getService('httpResponse'));
		$service->setExpiration('15 days');
		return $service;
	}


	/**
	 * @return Nette\Security\User
	 */
	protected function createServiceUser()
	{
		$service = new Nette\Security\User($this->getService('nette.userStorage'), $this);
		return $service;
	}


	/**
	 * @return Todo\UvazekRepository
	 */
	protected function createServiceUvazekRepository()
	{
		$service = new Todo\UvazekRepository($this->getService('nette.database.default'));
		return $service;
	}


	/**
	 * @return Todo\ZamestnanecRepository
	 */
	protected function createServiceZamestnanecRepository()
	{
		$service = new Todo\ZamestnanecRepository($this->getService('nette.database.default'));
		return $service;
	}


	public function initialize()
	{
		date_default_timezone_set('Europe/Prague');
		Nette\Caching\Storages\FileStorage::$useDirectories = TRUE;

		$this->getService("session")->exists() && $this->getService("session")->start();
		header('X-Frame-Options: SAMEORIGIN');
	}

}



/**
 * @property Nette\Database\Connection $default
 */
class SystemContainer_nette_database
{



}



/**
 * @method Nette\Forms\Form createBasicForm()
 * @property Nette\Callback $basicFormFactory
 * @method Nette\Caching\Cache createCache()
 * @property Nette\Callback $cacheFactory
 * @property Nette\Caching\Storages\FileJournal $cacheJournal
 * @property SystemContainer_nette_database $database
 * @property Nette\Http\Context $httpContext
 * @method Nette\Latte\Engine createLatte()
 * @property Nette\Callback $latteFactory
 * @method Nette\Mail\Message createMail()
 * @property Nette\Callback $mailFactory
 * @property Nette\Mail\SendmailMailer $mailer
 * @property Nette\Application\PresenterFactory $presenterFactory
 * @method Nette\Templating\FileTemplate createTemplate()
 * @property Nette\Caching\Storages\PhpFileStorage $templateCacheStorage
 * @property Nette\Callback $templateFactory
 * @property Nette\Http\UserStorage $userStorage
 */
class SystemContainer_nette
{



}
