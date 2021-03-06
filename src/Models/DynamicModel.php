<?php
namespace Lab1353\Monkyz\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Lab1353\Monkyz\Helpers\TablesHelper as HTables;

/**
 * Dynamic model for any tables
 *
 * @method integer count()
 */
class DynamicModel extends Model
{
	protected static $_table;

	//TODO: manage softDeleting: https://laravel.com/docs/5.2/eloquent#soft-deleting
	public $timestamps = false;
	protected $dates = [];

	public function __construct($table='')
	{
		if (!empty($table)) $this->setParameters($table);

		parent::__construct();
	}

	public function setParameters($table)
	{
		$htables = new HTables();
		$fields = $htables->getColumns($table);

		$f_created = false;
		$f_updated = false;
		$f_dates = [];

		foreach ($fields as $field=>$params) {
			if ($params['type']=='key') {
				$f_key_name = $field;
			}
			if ($field=='created_at') $f_created = true;
			if ($field=='updated_at') $f_updated = true;
			if (in_array($params['input'], ['date','datetime'])) $f_dates[] = $field;
		}

		$this->setTable($table);
		$this->timestamps = ($f_created && $f_updated);
		$this->dates = $f_dates;
		$this->setKeyName($f_key_name);
		/*
		$this->primaryKey = $f_key_name;
		$this->keyType = $f_key_type;
		$this->setIncrementing((bool)($f_key_type=='int'));
		$this->dates = $f_dates;
		$this->timestamps = ($f_created && $f_updated);
		 */
	}

	/**
	 * TABLE
	 */
	public function setTable($table)
	{
		self::$_table = $table;
	}
	public function getTable()
	{
		return self::$_table;
	}
}
