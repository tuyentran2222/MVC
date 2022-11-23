<?php
	namespace core;

	use core\Model;

	abstract class DBModel extends Model{
		/**
		 * @desc get database table name
		 */
		abstract public static function tableName();

		/**
		 * @desc get attributes of object
		 */
		abstract public function attributes();

		/**
		 * @desc insert a record into database
		 * @return boolean return true if insert successfully, otherwise return false;
		 */
		public function save(){
			$table = $this->tableName();
			$object_id = $this->id;
			
			$params_value=[];
			$attributes = $this->attributes();
			foreach ($attributes as $attribute){
				$params_value[$attribute] = $this->{$attribute};
			}
			if (!$object_id){
				$params = array_map(function($attribute){
					return ":" .$attribute;
				}, $attributes);

				$sql = "INSERT INTO $table (" . implode(',', $attributes) . ") values (" . implode(',', $params) . ")";
				return Application::$app->database->save($sql, $params_value);
			}

			$params = array_map(function($attribute){
				return $attribute." = :" .$attribute;
			}, $attributes);

			$search_array = ["id" => $object_id];
			$where_values = array_values($search_array);
			$where_keys = array_keys($search_array);
			$where_params = array_map(function($where_key, $where_value){
				return $where_key." = '". $where_value. "'";
			}, $where_keys, $where_values);
			$sql = "update $table set ". implode(' , ', $params) ." where " . implode(" and ", $where_params);
			return Application::$app->database->save($sql, $params_value);
		}

		/**
		 * @desc find a record from database
		 * @param array $where condition to query
		 * @return object|boolean return object if found, otherwise return false;
		 */
		public static function findOne($where){
			$table = static::tableName();
			$keys = array_keys($where);
			$params = array_map(function($attribute){
				return $attribute." = :" .$attribute;
			}, $keys);

			$sql = "select * from $table where " . implode(' and ', $params);
			$stmt = Application::$app->database->exec($sql, $where);
			$res = $stmt->fetchObject(static::class);
			return $res;
		}

		/**
		 * @desc update records
		 * @param array $attributes values array to update
		 * @param array $where condition array to query
		 * @return boolean return true if update successfully, otherwise return false;
		 */
		public static function update($attributes, $where){
			$table = static::tableName();
			$keys = array_keys($attributes);

			$params = array_map(function($attribute){
				return $attribute." = :" .$attribute;
			}, $keys);

			$where_values = array_values($where);
			$where_keys = array_keys($where);
			$where_params = array_map(function($where_key, $where_value){
				return $where_key." = '". $where_value. "'";
			}, $where_keys, $where_values);

			$sql = "update $table set ". implode(' , ', $params) ." where " . implode(" and ", $where_params);
			return Application::$app->database->exec($sql, $attributes);
		}

		/**
		 * @desc delete records
		 * @param array $where condition array to delete
		 * @return boolean return true if delete successfully, otherwise return false;
		 */
		public static function delete($where){
			$table = static::tableName();
			$keys = array_keys($where);

			$params = array_map(function($attribute){
				return $attribute." = :" .$attribute;
			}, $keys);

			$sql = "delete from $table where " . implode(" and ", $params);
			return Application::$app->database->exec($sql, $where);
		}
	}