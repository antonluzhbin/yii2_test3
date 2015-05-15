<?php

namespace app\models;
use \yii\db\Expression;

class Book extends \yii\db\ActiveRecord
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
    
    public function rules()
    {
        return [
            [['name', 'preview', 'date', 'author_id'], 'required'],
            [['name', 'preview'], 'string'],
            [['date'], 'date', 'format' => 'yyyy-MM-dd'],
            [['author_id'], 'integer']
        ];
    }
 
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'books';
    }
 
    /**
     * @return array primary key of the table
     **/
    public static function primaryKey()
    {
        return array('id');
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'created' => 'Дата создания записи',
            'updated' => 'Дата обновления записи',
            'preview' => 'Путь к картинке превью книги',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        );
    }
    
    public function getAll($sort, $order, $filter)
    {
        $order_by = '';
        if ($sort)
        {
            $order_by = ' ORDER BY ' . $sort . ' ' . ($order == 'desc' ? $order : 'asc');
        }
        
        $where = '';
        if ($filter && $filter->author != 0)
        {
            $where .= ' and a.author_id = ' .  $filter->author;
        }
        if ($filter && $filter->name != '')
        {
            $where .= ' and a.name like "%' .  $filter->name . '%"';
        }
        if ($filter && $filter->date_begin != '' && $filter->date_end != '')
        {
            $where .= ' and a.date >= "' . $filter->date_begin . '" and a.date <= "' . $filter->date_end . '"';
        }
        
        $command = static::getDb()->createCommand("select a.id as id, a.name as name, a.created as created, a.preview as preview, " .
            "a.date as date, CONCAT(b.firstname, ' ', b.lastname) as author from books as a, " .
            "authors as b where a.author_id = b.id " . $where . $order_by)->queryAll();
        
        return $command;
    }
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->created = new Expression('NOW()');
            $command = static::getDb()->createCommand("select max(id) as id from book")->queryAll();
            $this->id = $command[0]['id'] + 1;
        }

        $this->updated = new Expression('NOW()');
        return parent::beforeSave($insert);
    }
}

