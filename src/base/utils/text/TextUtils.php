<?php
namespace base\utils\text;

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

abstract class TextUtils
{
	/**
	 *  Возвращает текст с переносами.
	 *
	 *  @param string ...$text
	 *
	 *  @return string
	 */
	static function wrapping (string ...$text) : string
	{
		return implode(PHP_EOL, $text);
	}
	
	/**
	 *  Возвращает замененную строку.
	 *  Меняет в тексте все ключи массива на их значение.
	 *
	 *  @param string $str
	 *  @param array  $words
	 *
	 *  @return string
	 */
	static function replace (string $str, array $words) : string
	{
		return str_replace(array_keys($words), array_values($words), $str);
	}
}