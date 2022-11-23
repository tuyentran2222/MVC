<?php
    namespace core;

    class Database{
        private $pdo;

        public function __construct($host, $dbname, $user_name, $password){
            $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $user_name, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        /**
         * @desc: prepare sql
         * @param string sql
         * @return PDOStatement|false
         */
        public function prepare($sql){
            return $this->pdo->prepare($sql);
        }

        /**
         * @desc execute sql select or delete with $params
         * @param string $sql: sql query
         * @param array $params
         * @return \PDOStatement $stmt
         */ 
        public function exec($sql, $params){
            $stmt = static::prepare($sql);
            foreach ($params as $key => $value){
				$stmt->bindValue(":$key", $value);
			}
			$stmt->execute();
			return $stmt;
        }

         /**
         * @desc execute sql insert or update with $params
         * @param string $sql: sql query
         * @param array $params
         * @return boolean
         */
        public function save($sql, $params){
            $stmt = static::prepare($sql);
            foreach ($params as $key => $value){
				$stmt->bindValue(":$key", $value);
			}
		    return $stmt->execute();
        }
    }

