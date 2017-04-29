<?php
namespace base\utils;

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

use base\console\Logger;

use base\utils\file\FileUtils;

use base\utils\text\TextUtils;
use base\utils\text\TextFormat;

abstract class ExceptionHandler
{
	/**
	 *  Обработка непойманного исключения.
	 *
	 *  @param \Throwable $exception
	 */
	static function handle (\Throwable $exception)
	{
		$error_message = $exception->getMessage();
		$error_code = $exception->getCode();
		$error_file = $exception->getFile();
		$error_line = $exception->getLine();
		
		$message =
		[
			"Необработанное исключение:",
			"",
			"&l&cСообщение &r&b> &f".$error_message,
			"&l&cКод ошибки &r&b> &f".$error_code.".",
			"&l&cФайл &r&b> &f".FileUtils::getCleanedPath($error_file).".",
			"&l&cСтрока &r&b> &f".$error_line.".",
			"",
		];
		
		Logger::error(TextUtils::wrapping(...$message));
	}
}