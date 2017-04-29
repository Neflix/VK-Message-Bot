<?php

#
#           • - - - - - - - - - - - - - - - - - - - - - • - - - - - - - - - - - - - - - - - •
#           |                                           |                                   |
#           |      █  █  ███  ███  █    ███  ██ ██      |      ███   ███   ███  █████       |
#           |      ██ █  █    █    █     █    ███       |      █    █   █  █      █         |
#           |      █ ██  ███  ███  █     █     █        |      ███  █   █  ███    █         |
#           |      █  █  █    █    █     █    ███       |        █  █   █  █      █         |
#           |      █  █  ███  █    ███  ███  ██ ██      |      ███   ███   █      █         |
#           |                                           |                                   |
#           • - - - - - - - - - - - - - - - - - - - - - • - - - - - - - - - - - - - - - - - •
#
#           @link https://github.com/Neflix/
#

namespace
{
	use spl\ClassLoader;
	
	use base\Core;
	
	use base\console\Logger;
	use base\console\Terminal;
	
	use base\utils\ExceptionHandler;
	use base\utils\server\ServerUtils;
	
	interface Loader
	{
		/* Требуемая версия PHP */ 
		const VERSION_PHP = "7.0";
		
		/* Требуемое SAPI PHP */ 
		const SAPI_PHP = "cli";
		
		/* Требуемые расширения PHP */
		const PHP_EXTENSIONS =
		[
			"pthreads",
			"mbstring",
			"curl",
			"json",
			"yaml",
		];
		
		/* Конфигурация PHP */
		const PHP_INI_SETTINGS =
		[
			"default_charset" => "UTF-8",
			"display_errors" => 1,
			"display_startup_errors" => 1,
			"allow_url_fopen" => 1,
			"memory_limit" => -1,
			"max_execution_time" => 0,
		];
	}
	
	gc_enable();
	error_reporting(-1);
	
	foreach(Loader::PHP_INI_SETTINGS as $param => $value)
		ini_set($param, $value);
	
	/* Время старта. */
	define("VKBOT_START_TIME", microtime(true));
	
	/* Начальное потребление памяти. */
	define("VKBOT_START_MEMORY", memory_get_usage());
	
	/* Домашняя папка. */
	define("VKBOT_DIR", getcwd().DIRECTORY_SEPARATOR);
	
	/* Подключение классов исключений. */
	require_once VKBOT_DIR."src/spl/Exceptions.php";
	
	/* Подключение автозагрузчика классов. */
	require_once VKBOT_DIR."src/spl/ClassLoader.php";
	
	ClassLoader::register();
	ClassLoader::addPath(VKBOT_DIR."src/");
	
	/* Установка обработчика исключений. */
	set_exception_handler([ExceptionHandler::class, "handle"]);
	
	/* Установка часового пояса. */
	ini_set("date.timezone", $timezone = ServerUtils::getTimeZone());
	date_default_timezone_set($timezone);
	
	/* Инициализация консоли. */
	Terminal::init();
	Terminal::setTitle("Starting...");
	
	$error = false;
	
	if(version_compare(Loader::VERSION_PHP, PHP_VERSION) === 1)
	{
		$error = true;
		Logger::error("Версия PHP должна быть не ниже &e".Loader::VERSION_PHP.".");
	}
	
	if(PHP_SAPI !== Loader::SAPI_PHP)
	{
		$error = true;
		Logger::error("Необходимо использовать &ePHP ".Loader::SAPI_PHP.".");
	}
	
	foreach(Loader::PHP_EXTENSIONS as $extension)
		if(!extension_loaded($extension))
		{
			$error = true;
			Logger::error("Не установлено расширение: &e".$extension.".");
		}
	
	if($error)
	{
		Terminal::setTitle("Startup error!");
		exit(1);
	}
	
	unset($error);
	
	Core::start();
}