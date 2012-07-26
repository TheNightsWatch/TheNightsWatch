<?php

class ActiveRecord extends CActiveRecord
{
    private $_sql_format = "Y-m-d H:i:s";

    public function __set($name, $value)
    {
        if($this->_checkTimestamp($name))
        {
            /*
             * If the attribute is stored as a timestamp, we translate whatever
             * the user sets it as to the string format specified in $this->_sql_format,
             * allowing the record to ignore the type of the variable completely.
             */
            if(is_int($value))
                $value = date($this->_sql_format,$value);
            else if($value instanceof DateTime)
                $value = $value->format($this->_sql_format);
            else if(is_string($value))
                $value = date($this->_sql_format,strtotime($value));
        }
        parent::__set($name,$value);
    }

    public function __get($name)
    {
        if($this->_checkTimestamp($name))
        {
            $value = parent::__get($name);
            if($value instanceof CDbCriteria)
            {
                return $value;
            }
            return new DateTime($value);
        }
        return parent::__get($name);
    }

    /**
     * Checks whether the attribute in question is stored as a timestamp in SQL
     * @param string $name
     * @return boolean
     */
    private function _checkTimestamp($name)
    {
        if(!isset($this->attributes[$name])) return false;
        $table = $this->getTableSchema();
        if($table == null) return false;
        $column = $table->getColumn($name);
        if($column == null) return false;
        if(strtoupper($column->dbType) == 'TIMESTAMP') return true;
        return false;
    }
}