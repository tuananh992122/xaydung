<?php
class Cacher extends Memcached {
	static public $memcacheObj = NULL;
	static function cache() {
		if (self::$memcacheObj == NULL) {
			self::$memcacheObj = new Memcached();
			self::$memcacheObj->addServer("localhost",11211);
		}
		return self::$memcacheObj;
	}
	static function flushCache() {
		if (self::$memcacheObj == NULL) {
			self::cache();
		}
		return self::$memcacheObj->flush();
	}
	static function getCache($key) {
		if (self::$memcacheObj == NULL) {
			self::cache();
		}
		return self::$memcacheObj->get($key);
	}
	static function delCache($key) {
		if (self::$memcacheObj == NULL) {
			self::cache();
		}
		return self::$memcacheObj->delete($key);
	}
	static function setCache($key,$data,$time) {
		if (self::$memcacheObj == NULL) {
			self::cache();
		}
		return self::$memcacheObj->set($key,$data,$time);
	}
	static function getResultCodeCache() {
		if (self::$memcacheObj == NULL) {
			self::cache();
		}
		return self::$memcacheObj->getResultCode();
	}
}
?>