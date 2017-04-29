<?php
namespace base\utils\server;

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

abstract class ServerUtils
{
	const OS_UNDEFINED = 0;
	const OS_WINDOWS = 1;
	const OS_MAC = 2;
	const OS_IOS = 3;
	const OS_ANDROID = 4;
	const OS_LINUX = 5;
	const OS_BSD = 6;
	
	/** @var array - кэшируемые данные. */
	public static $cache = [];
	
	/**
	 *  Вовзращает ОС сервера.
	 *
	 *  @return int
	 */
	static function getOS() : int
	{
		if(!isset(self::$cache["server_os"]))
		{
			if(stripos(PHP_OS, "Win") !== false || PHP_OS === "Msys")
				self::$cache["server_os"] = self::OS_WINDOWS;
			elseif(stripos(PHP_OS, "BSD") !== false || PHP_OS === "DragonFly")
				self::$cache["server_os"] = self::OS_BSD;
			elseif(stripos(PHP_OS, "Linux") !== false)
			{
				if(file_exists("/system/build.prop"))
					self::$cache["server_os"] = self::OS_ANDROID;
				else
					self::$cache["server_os"] = self::OS_LINUX;
			}
			elseif(stripos(PHP_OS, "Darwin") !== false)
			{
				if(strpos(php_uname("m"), "iP") === 0)
					self::$cache["server_os"] = self::OS_IOS;
				else
					self::$cache["server_os"] = self::OS_MAC;
			}
			else
				self::$cache["server_os"] = self::OS_UNDEFINED;
		}
		
		return self::$cache["server_os"];
	}
	
	/**
	 *  Вовзращает IP сервера.
	 *
	 *  @return string
	 */
	static function getIP() : string
	{
		if(!isset(self::$cache["server_ip"]))
		{
			self::$cache["server_ip"] = getHostByName(getHostName());
		}
		
		return self::$cache["server_ip"];
	}
	
	/**
	 *  Вовзращает часовой пояс сервера.
	 *
	 *  @return string
	 */
	static function getTimeZone() : string
	{
		if(!isset(self::$cache["server_timezone"]))
		{
			$detected = date_default_timezone_get();
			
			switch(self::getOS())
			{
				case self::OS_WINDOWS:
					exec("wmic timezone get Caption", $output);
					preg_match("/(UTC)(\+*\-*\d*\d*\:*\d*\d*)/", trim(implode("\n", $output)), $matches);
					
					if(!isset($matches[2]) || !$matches[2])
						self::$cache["server_timezone"] = $detected;
					else
						self::$cache["server_timezone"] = DateUtils::getTimeZoneOffset($matches[2]) ?? $detected;
				break;
				
				case self::OS_LINUX:
					/* Ubuntu / Debian. */
					if(file_exists("/etc/timezone") && $data = file_get_contents("/etc/timezone"))
						return self::$cache["server_timezone"] = trim($data);
					
					/* RHEL / CentOS. */
					elseif(file_exists("/etc/sysconfig/clock"))
					{
						$data = parse_ini_file("/etc/sysconfig/clock");
						
						if(isset($data["ZONE"]))
							return self::$cache["server_timezone"] = trim($data["ZONE"]);
					}
					
					self::$cache["server_timezone"] = DateUtils::getTimeZoneOffset(trim(exec("date +%:z"))) ?? $detected;
				break;
				
				case self::OS_MAC:
					if(is_link("/etc/localtime"))
					{
						$filename = readlink("/etc/localtime");
						
						if(strpos($filename, "/usr/share/zoneinfo/") === 0)
							self::$cache["server_timezone"] = trim(substr($filename, 20));
					}
				break;
				
				default:
					self::$cache["server_timezone"] = $detected;
				break;
			}
		}
		
		return self::$cache["server_timezone"];
	}
	
	/**
	 *  Убить процесс.
	 *
	 *  @param int $pid
	 */
	static function killProcess (int $pid)
	{
		switch(self::getOS())
		{
			case self::OS_WINDOWS:
				exec("taskkill.exe /F /PID ".$pid." > NUL");
			break;
			
			default:
				if(function_exists("posix_kill"))
					posix_kill($pid, SIGKILL);
				else
					exec("kill -9 ".$pid." > /dev/null 2>&1");
			break;
		}
	}
}