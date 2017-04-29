<?php
namespace bot\console;

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

use bot\utils\text\TextFormat;

abstract class Logger
{
	/**
	 *  Отправить сообщение.
	 *
	 *  @param string $message
	 */
	static function info (string $message)
	{
		self::displayMessage($message, TextFormat::WHITE."Инфо");
	}
	
	/**
	 *  Отправить предупреждение.
	 *
	 *  @param string $message
	 */
	static function warning (string $message)
	{
		self::displayMessage($message, TextFormat::AQUA."Внимание");
	}
	
	/**
	 *  Отправить сообщение об ошибке.
	 *
	 *  @param string $message
	 */
	static function error (string $message)
	{
		self::displayMessage($message, TextFormat::RED."Ошибка");
	}
	
	/**
	 *  Отправить дебаг-сообщение.
	 *
	 *  @param string $message
	 */
	static function debug (string $message)
	{
		self::displayMessage($message, TextFormat::GRAY."Дебаг");
	}
	
	/**
	 *  Вывести сообщение в консоль.
	 *
	 *  @param string $message
	 *  @param string $prefix
	 */
	static function displayMessage (string $message, string $prefix)
	{
		$message = "&l&e".date("H:i:s")." &r&b> &l".$prefix." &r&b> &r".$message."&r";
		
		echo TextFormat::getConvertedANSI($message).PHP_EOL;
	}
}