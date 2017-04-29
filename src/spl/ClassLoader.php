<?php
namespace spl;

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

abstract class ClassLoader
{
	/** @var string[] */
	static $dirs;
	
	/**
	 *  Регистрация функции автозагрузки.
	 */
	static function register()
	{
		spl_autoload_register([self::class, "loadClass"]);
	}
	
	/**
	 *  Добавление директории для поиска класса.
	 *
	 *  @param string $dir
	 */
	static function addPath (string $dir)
	{
		self::$dirs[] = $dir;
	}
	
	/**
	 *  Загрузка класса.
	 *
	 *  @param string $class
	 *
	 *  @throws \ClassNotExistException
	 */
	static function loadClass (string $class)
	{
		$file = self::getClassFile($class);
		
		if($file === null || ((include $file) && !class_exists($class, false) && !interface_exists($class, false) && !trait_exists($class, false)))
			throw new \ClassNotExistException ("Класс ".$class." не найден.");
	}
	
	/**
	 *  Возвращает путь к файлу класса.
	 *
	 *  @param string $class
	 *
	 *  @return string|null
	 */
	static function getClassFile (string $class)
	{
		$class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
		
		foreach(self::$dirs as $dir)
		{
			if(file_exists($file = $dir.DIRECTORY_SEPARATOR.$class.".php"))
				return $file;
		}
		
		return null;
	}
}