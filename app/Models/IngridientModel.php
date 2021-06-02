<?php namespace App\Models;
use CodeIgniter\Model;
class IngridientModel extends Model
{
    protected $table = 'ingridient'; //таблица, связанная с моделью
    //Перечень задействованных в модели полей таблицы
    protected $allowedFields = ['Наименование', 'Единицы измерения'];
    public function getingridient($id = null)
    {
        if (!isset($id)) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
    public function getIngridientWithUser($id = null)
    {
        $builder = $this->select('*')->join('users','ingridient.user_id = users.id')->like('Наименование', $search,'both', null, true)->orlike($search,'both',null,true);
        if (!is_null($id))
        {
            return $builder->where(['ingridient.id' => $id])->first();
        }
        return $builder->findAll();
    }
}