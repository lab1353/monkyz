<?php
namespace Lab1353\Monkyz\Helpers;

use File;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

class FileHelper
{
	protected $disk = '';
	protected $disk_params = [];

	public function __construct($disk='')
	{
		$this->setDisk($disk);
	}


	/***********
	 * PRIVATE *
	 ***********/

	/**
	 * Setting the disk of Storage to use
	 * @param string $disknew name of disk to use
	 */
	private function setDisk($disknew)
	{
		$disk = config('filesystems.default');
		$disks = array_keys(config('filesystems.disks'));

		if (in_array($disknew, $disks)) {
			$disk = $disknew;
		}

		$this->disk = $disk;
		$this->disk_params = config('filesystems.disks.'.$disk);
		if (empty($this->disk_params['driver'])) $this->disk_params['driver'] = '';
	}


	/***************
	 * DIRECTORIES *
	 ***************/

	public static function countFilesInFolder($folder)
	{
		$files = self::filesInFolder($folder);
		return count($files);
	}

	public static function filesInFolder($folder)
	{
		return File::files($folder);
	}

	public static function cleanDirectory($folder)
	{
		return File::cleanDirectory($folder);
	}


	/***********
	 * CONVERT *
	 ***********/

	/**
	 * Convert bytes to human readable
	 * @param  integer $bytes    bytes to convert
	 * @param  integer $decimals number of decimals
	 * @return string            the readable string
	 */
	public static function bytes2human($bytes, $decimals = 2) {
		$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}


	/*******
	 * URL *
	 *******/

	public function getUrlFileTypeIcon($file_name)
	{
		if (empty($file_name)) {
			return '';
		} else {
			$path = 'vendor/monkyz/images/ext/';
			$icon = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)).'.png';

			return asset($path.$icon);
		}
	}

	public function getUrlFromParams($params, $file)
	{
		$path = $params['file']['path'];

		$disk = $params['file']['disk'];
		$this->setDisk($disk);

		return $this->generateUrl($path, $file);
	}

	public function generateUrl($path, $file_name)
	{
		$url = '';
		if (!empty($file_name)) {
			$disk = $this->disk;
			$path = str_finish($path, '/');

			$cache_key = 'monkyz-images-url_'.$disk.'_'.str_slug($path).'_'.str_slug($file_name);

			if (Cache::has($cache_key)) {
				$url = Cache::get($cache_key);
			} else {
				try {
					$url = Storage::disk($disk)->url($path.$file_name);
				} catch (Exception $e) {
					$adapter = Storage::disk($disk)->getAdapter();
					if (!empty($adapter)) {
						$client = $adapter->getClient();
						if (!empty($client)) {
							$path = str_start($path, '/');
							$url = $client->createTemporaryDirectLink($path.$file_name);
							if (is_array($url)) $url = $url[0];
						}
					}
				}

				Cache::put($cache_key, $url, (int)config('monkyz.cache_minutes', 60));
			}
		}

		return $url;
	}


	/**********
	 * DELETE *
	 **********/

	public function delete($params, $file)
	{
		$path = $params['file']['path'];
		$path = str_finish($path, '/');

		$disk = $params['file']['disk'];
		$this->setDisk($disk);
		$driver = $this->disk_params['driver'];

		if ($driver!='local') {
			$path = str_start($path, '/');
		}
		return Storage::disk($disk)->delete($path.$file);
	}
}