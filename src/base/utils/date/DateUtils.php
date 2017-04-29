<?php
namespace base\utils\date;

#
#           • - - - - - - - - - - - - - - - - - - - - - - - - - - - • - - - - - - - - - - - - - - - - - - - - - •
#           |                                                       |                                           |
#           |      █   █  ███  █  █  ███  ████  █    █  █  ███      |      ███  █  █   ███  ███  █  █  ███      |
#           |      ██ ██   █   ██ █  █    █  █  █    █  █  █        |      █    ██ █  █      █   ██ █  █        |
#           |      █ █ █   █   █ ██  ███  ████  █    █  █  ███      |      ███  █ ██  █      █   █ ██  ███      |
#           |      █   █   █   █  █  █    █     █    █  █    █      |      █    █  █  █  █   █   █  █  █        |
#           |      █   █  ███  █  █  ███  █     ███  ████  ███      |      ███  █  █   ███  ███  █  █  ███      |
#           |                                                       |                                           |
#           • - - - - - - - - - - - - - - - - - - - - - - - - - - - • - - - - - - - - - - - - - - - - - - - - - •
#
#           Software for MCPE servers.
#
#           @author MinePlus
#           @website http://www.MinePlus.ru/
#

use server\utils\text\TextUtils;

abstract class DateUtils
{
	/**
	 *  Возвращает часовой пояс по сдвигу от UTC.
	 *
	 *  @param string $offset - сдвиг от UTC.
	 *
	 *  @return string|null
	 */
	static function getTimeZoneOffset (string $offset)
	{
		if(strpos($offset, "-") !== false)
		{
			$negativeOffset = true;
			$offset = str_replace("-", null, $offset);
		}
		elseif(strpos($offset, "+") !== false)
		{
			$negativeOffset = false;
			$offset = str_replace("+", null, $offset);
		}
		else
			return null;
		
		$parsed = date_parse($offset);
		$offset = $parsed["hour"] * 3600 + $parsed["minute"] * 60 + $parsed["second"];
		
		if($negativeOffset)
			$offset = -abs($offset);
		
		foreach(timezone_abbreviations_list() as $zones)
		{
			foreach($zones as $timezone)
			{
				if($timezone["offset"] === $offset)
					return $timezone["timezone_id"];
			}
		}
		
		return null;
	}
	
	/**
	 *  Возвращает год.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getYear (int $time = 0) : string
	{
		return date("Y", $time <= 0 ? time() : $time);
	}
	
	/**
	 *  Возвращает номер месяца.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getMonth (int $time = 0) : string
	{
		return date("m", $time <= 0 ? time() : $time);
	}
	
	/**
	 *  Возвращает день.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getDay (int $time = 0) : string
	{
		return date("d", $time <= 0 ? time() : $time);
	}
	
	/**
	 *  Возвращает номер недели.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getWeek (int $time = 0) : string
	{
		$week = date("w", $time <= 0 ? time() : $time);
		
		if($week == 0)
			$week = 7;
		
		return (string) $week;
	}
	
	/**
	 *  Возвращает часы.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getHours (int $time = 0) : string
	{
		return date("H", $time <= 0 ? time() : $time);
	}
	
	/**
	 *  Возвращает минуты.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getMinutes (int $time = 0) : string
	{
		return date("i", $time <= 0 ? time() : $time);
	}
	
	/**
	 *  Возвращает секунды.
	 *
	 *  @param int $time
	 *
	 *  @return string
	 */
	static function getSeconds (int $time = 0) : string
	{
		return date("s", $time <= 0 ? time() : $time);
	}
}