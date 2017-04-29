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

use bot\utils\server\ServerUtils;

abstract class Terminal
{
	/** @var array - коды форматирования текста. */
	static $format =
	[
		"color" =>
		[
			"black" => "",
			"dark_blue" => "",
			"dark_green" => "",
			"dark_aqua" => "",
			"dark_red" => "",
			"dark_purple" => "",
			"gold" => "",
			"gray" => "",
			"dark_gray" => "",
			"blue" => "",
			"green" => "",
			"aqua" => "",
			"red" => "",
			"purple" => "",
			"yellow" => "",
			"white" => "",
		],
		
		"format" =>
		[
			"reset" => "",
			
			"bold" => "",
			"obfuscated" => "",
			"italic" => "",
			"underline" => "",
			"strikethrough" => "",
		],
	];
	
	/**
	 *  Инициализация.
	 */
	static function init()
	{
		if(!self::isFormatting())
			return;
		
		switch(ServerUtils::getOS())
		{
			case ServerUtils::OS_LINUX:
			case ServerUtils::OS_MAC:
			case ServerUtils::OS_BSD:
				self::$format["format"]["reset"] = `tput sgr0`;
				
				self::$format["format"]["bold"] = `tput bold`;
				self::$format["format"]["obfuscated"] = `tput smacs`;
				self::$format["format"]["italic"] = `tput sitm`;
				self::$format["format"]["underline"] = `tput smul`;
				self::$format["format"]["strikethrough"] = "\x1b[9m";
				
				$colors = (int) `tput colors`;
				if($colors > 8)
				{
					self::$format["color"]["black"] = $colors >= 256 ? `tput setaf 16` : `tput setaf 0`;
					self::$format["color"]["dark_blue"] = $colors >= 256 ? `tput setaf 19` : `tput setaf 4`;
					self::$format["color"]["dark_green"] = $colors >= 256 ? `tput setaf 34` : `tput setaf 2`;
					self::$format["color"]["dark_aqua"] = $colors >= 256 ? `tput setaf 37` : `tput setaf 6`;
					self::$format["color"]["dark_red"] = $colors >= 256 ? `tput setaf 124` : `tput setaf 1`;
					self::$format["color"]["dark_purple"] = $colors >= 256 ? `tput setaf 127` : `tput setaf 5`;
					self::$format["color"]["gold"] = $colors >= 256 ? `tput setaf 214` : `tput setaf 3`;
					self::$format["color"]["gray"] = $colors >= 256 ? `tput setaf 145` : `tput setaf 7`;
					self::$format["color"]["dark_gray"] = $colors >= 256 ? `tput setaf 59` : `tput setaf 8`;
					self::$format["color"]["blue"] = $colors >= 256 ? `tput setaf 63` : `tput setaf 12`;
					self::$format["color"]["green"] = $colors >= 256 ? `tput setaf 83` : `tput setaf 10`;
					self::$format["color"]["aqua"] = $colors >= 256 ? `tput setaf 87` : `tput setaf 14`;
					self::$format["color"]["red"] = $colors >= 256 ? `tput setaf 203` : `tput setaf 9`;
					self::$format["color"]["purple"] = $colors >= 256 ? `tput setaf 207` : `tput setaf 13`;
					self::$format["color"]["yellow"] = $colors >= 256 ? `tput setaf 227` : `tput setaf 11`;
					self::$format["color"]["white"] = $colors >= 256 ? `tput setaf 231` : `tput setaf 15`;
				}
				else
				{
					self::$format["color"]["black"] = self::$format["color"]["dark_gray"] = `tput setaf 0`;
					self::$format["color"]["red"] = self::$format["color"]["dark_red"] = `tput setaf 1`;
					self::$format["color"]["green"] = self::$format["color"]["dark_green"] = `tput setaf 2`;
					self::$format["color"]["yellow"] = self::$format["color"]["gold"] = `tput setaf 3`;
					self::$format["color"]["blue"] = self::$format["color"]["dark_blue"] = `tput setaf 4`;
					self::$format["color"]["purple"] = self::$format["color"]["dark_purple"] = `tput setaf 5`;
					self::$format["color"]["aqua"] = self::$format["color"]["dark_aqua"] = `tput setaf 6`;
					self::$format["color"]["gray"] = self::$format["color"]["white"] = `tput setaf 7`;
				}
			break;
			
			case ServerUtils::OS_WINDOWS:
			case ServerUtils::OS_ANDROID:
				self::$format["format"]["reset"] = "\x1b[m";
				
				self::$format["format"]["bold"] = "\x1b[1m";
				self::$format["format"]["obfuscated"] = "";
				self::$format["format"]["italic"] = "\x1b[3m";
				self::$format["format"]["underline"] = "\x1b[4m";
				self::$format["format"]["strikethrough"] = "\x1b[9m";
				
				self::$format["color"]["black"] = "\x1b[38;5;16m";
				self::$format["color"]["dark_blue"] = "\x1b[38;5;19m";
				self::$format["color"]["dark_green"] = "\x1b[38;5;34m";
				self::$format["color"]["dark_aqua"] = "\x1b[38;5;37m";
				self::$format["color"]["dark_red"] = "\x1b[38;5;124m";
				self::$format["color"]["dark_purple"] = "\x1b[38;5;127m";
				self::$format["color"]["gold"] = "\x1b[38;5;214m";
				self::$format["color"]["gray"] = "\x1b[38;5;145m";
				self::$format["color"]["dark_gray"] = "\x1b[38;5;59m";
				self::$format["color"]["blue"] = "\x1b[38;5;63m";
				self::$format["color"]["green"] = "\x1b[38;5;83m";
				self::$format["color"]["aqua"] = "\x1b[38;5;87m";
				self::$format["color"]["red"] = "\x1b[38;5;203m";
				self::$format["color"]["purple"] = "\x1b[38;5;207m";
				self::$format["color"]["yellow"] = "\x1b[38;5;227m";
				self::$format["color"]["white"] = "\x1b[38;5;231m";
			break;
		}
	}
	
	/**
	 *  Установить заголовок окна консоли.
	 *
	 *  @param string $label
	 */
	static function setTitle (string $label)
	{
		echo "\x1b]0;".$label."\x07";
	}
	
	/**
	 *  Возвращает значение поддержки форматирования консоли.
	 *
	 *  @return bool
	 */
	static function isFormatting() : bool
	{
		return ServerUtils::getOS() !== ServerUtils::OS_WINDOWS && getenv("TERM") && (!function_exists("posix_ttyname") || !defined("STDOUT") || posix_ttyname(STDOUT) !== false);
	}
}