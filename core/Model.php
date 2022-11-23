<?php
    namespace core;

    use helper\Email;

    abstract class Model {
        public const RULE_REQUIRED = 'required';
        public const RULE_EMAIL = 'email';
        public const RULE_MIN = 'min';
        public const RULE_MAX = 'max';
        public const RULE_MATCH = 'match';
        public const RULE_UNIQUE = 'unique';
        public $errors = [];

        /**
         * @desc get validate rules
         * @return array rules array
         */
        abstract public function getRules();

        // abstract public function release();
        /**
         * @desc create new object from data array
         * @param array $data
         * @return $object
         */
        public static function fromData($data) {
            $object = new static();
            foreach ($data as $key => $value) {
                if (property_exists($object, $key)) {
                    $object->{$key} = $value;
                }
            }
            return $object;
        }

        /**
         * @desc load properties from data array into object.
         * @param array $data data is used to load properties.
         * @return void
         */
        public function loadData($data) {
            foreach ($data as $key => $value) {
                //Checks if the object or class has a property
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

        /**
         * validate all attributes defined
         * @return boolean return true if has error, otherwise return false.
         */
        public function validate() {
            return $this->validateRules($this->getRules());
        }

        /**
         * validate data with rules
         * @param array $rules
         * @return boolean return true if has error, otherwise return false.
         */
        public function validateRules($rules) {
            foreach ($rules  as $attribute => $rules) {
                $value = $this->{$attribute};
                foreach($rules as $rule) {
                    $ruleName = $rule;
                    if (!is_string($ruleName)) {
                        $ruleName = $ruleName[0];
                    }

                    if ($ruleName === self::RULE_REQUIRED && !$value) {
                        $this->addError($attribute, $ruleName);
                    }

                    if ($ruleName === self::RULE_MIN && (strlen($value) < $rule[$ruleName])) {
                        $this->addError($attribute, $ruleName, ['min' => $rule[$ruleName]]);
                    }

                    if ($ruleName === self::RULE_MAX && (strlen($value) > $rule[$ruleName])) {
                        $this->addError($attribute, $ruleName,  ['max' => $rule[$ruleName]]);
                    }

                    if ($ruleName === self::RULE_EMAIL && !Email::isEmail($value)) {
                        $this->addError($attribute, $ruleName);
                    }

                    if ($ruleName === self::RULE_MATCH && ($value !== $this->{$rule[$ruleName]})) {
                        $this->addError($attribute, $ruleName,  ['match' => $rule[$ruleName]]);
                    }

                    if ($ruleName === self::RULE_UNIQUE) {
                        $className = $rule['class'];
                        $tableName  = $className::tableName();
                        $sql_query = "select * from $tableName where $attribute = :$attribute";
                        $statement = Application::$app->database->exec($sql_query, [$attribute => $value]);
                        $res = $statement->fetchObject();

                        if  ($res) {
                            $this->addError($attribute, $ruleName, ['unique' => $attribute]);
                        }
                    }
                }
            }
            return empty($this->errors);
        }


        /**
         * @desc get errors of attribute
         * @param string $attribute
         * @return array|boolean return errors if has error else return false
         */
        public function getErrors($attribute) {
            return $this->errors[$attribute] ?? false;
        }
        
        /**
         * @desc: get all errors when validate
         * @return array
         */
        private function getErrorsDesc() {
            return [
                self::RULE_EMAIL => 'This field must be valid email address',
                self::RULE_MAX => 'Max length of this field must be {max}',
                self::RULE_MIN => 'Min length of this field must be {min}',
                self::RULE_REQUIRED => 'This field is required.',
                self::RULE_MATCH => 'This field must be same as {match}',
                self::RULE_UNIQUE => 'Record with this {unique} already exist'
            ];
        }
    

        /**
         * @desc add error to object and replace rule name by value of rule name if necessary
         * @param string $attribute
         * @param string $ruleName
         * @param array option
         * @return void
         */
        private function addError($attribute, $ruleName, $option = '') {
            $message = $this->getErrorsDesc()[$ruleName];
            if ($option) {
                $message = str_replace("{{$ruleName}}", $option[$ruleName], $message);
            }
            $this->errors[$attribute][] = $message;
        }
    }
