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

use base\console\Terminal;

abstract class TextFormat
{
	const SYMBOL = "&";
	
	const BLACK = self::SYMBOL."0";
	const DARK_BLUE = self::SYMBOL."1";
	const DARK_GREEN = self::SYMBOL."2";
	const DARK_AQUA = self::SYMBOL."3";
	const DARK_RED = self::SYMBOL."4";
	const DARK_PURPLE = self::SYMBOL."5";
	const GOLD = self::SYMBOL."6";
	const GRAY = self::SYMBOL."7";
	const DARK_GRAY = self::SYMBOL."8";
	const BLUE = self::SYMBOL."9";
	const GREEN = self::SYMBOL."a";
	const AQUA = self::SYMBOL."b";
	const RED = self::SYMBOL."c";
	const PURPLE = self::SYMBOL."d";
	const YELLOW = self::SYMBOL."e";
	const WHITE = self::SYMBOL."f";
	
	const RESET = self::SYMBOL."r";
	
	const BOLD = self::SYMBOL."l";
	const OBFUSCATED = self::SYMBOL."k";
	const ITALIC = self::SYMBOL."o";
	const UNDERLINE = self::SYMBOL."n";
	const STRIKETHROUGH = self::SYMBOL."m";
	
	/**
	 *  Возвращает очищенный от кода цветов текст.
	 *
	 *  @param string $string
	 *
	 *  @return string
	 */
	static function getCleanedString (string $string)
	{
		$string = preg_replace("/".self::SYMBOL."[0-9a-fklmnor]/i", null, $string);
		$string = preg_replace("/\x1b[\\(\\][[0-9;\\[\\(]+[Bm]/i", null, $string);
		
		return $string;
	}
	
	/**
	 *  Возвращает переведенные коды цвета в ANSI-код.
	 *
	 *  @param string $string
	 *
	 *  @return string
	 */
	static function getConvertedANSI (string $string)
	{
		return TextUtils::replace($string,
		[
			self::BLACK => Terminal::$format["color"]["black"],
			self::DARK_BLUE => Terminal::$format["color"]["dark_blue"],
			self::DARK_GREEN => Terminal::$format["color"]["dark_green"],
			self::DARK_AQUA => Terminal::$format["color"]["dark_aqua"],
			self::DARK_RED => Terminal::$format["color"]["dark_red"],
			self::DARK_PURPLE => Terminal::$format["color"]["dark_purple"],
			self::GOLD => Terminal::$format["color"]["gold"],
			self::GRAY => Terminal::$format["color"]["gray"],
			self::DARK_GRAY => Terminal::$format["color"]["dark_gray"],
			self::BLUE => Terminal::$format["color"]["blue"],
			self::GREEN => Terminal::$format["color"]["green"],
			self::AQUA => Terminal::$format["color"]["aqua"],
			self::RED => Terminal::$format["color"]["red"],
			self::PURPLE => Terminal::$format["color"]["purple"],
			self::YELLOW => Terminal::$format["color"]["yellow"],
			self::WHITE => Terminal::$format["color"]["white"],
			
			self::RESET => Terminal::$format["format"]["reset"],
			
			self::BOLD => Terminal::$format["format"]["bold"],
			self::OBFUSCATED => Terminal::$format["format"]["obfuscated"],
			self::ITALIC => Terminal::$format["format"]["italic"],
			self::UNDERLINE => Terminal::$format["format"]["underline"],
			self::STRIKETHROUGH => Terminal::$format["format"]["strikethrough"],
		]);
	}
}