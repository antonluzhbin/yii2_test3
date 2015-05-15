<?php

namespace app\models;
use \yii\db\Expression;

class Author extends \yii\db\ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
     
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'authors';
    }
 
    /**
     * @return array primary key of the table
     **/
    public static function primaryKey()
    {
        return array('id');
    }
    
    public function getData()
    {
        $command = static::getDb()->createCommand("select id, CONCAT(firstname, ' ', lastname) as author from authors")->queryAll();
        
        $res = Array();
        foreach ($command as $val)
        {
            $res[$val['id']] = $val['author'];
        }
        
        return $res;
    }
}

