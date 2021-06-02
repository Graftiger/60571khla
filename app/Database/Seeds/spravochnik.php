<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Spravochnik extends Seeder
{
    public function run()
    {
        $data = [

            'Наименование' => 'Литры',
            'Единицы измерения' => 1,
            "user_id" => 1,
        ];
        $this->db->table('ingridient')->insert($data);

        $data = [

            'Наименование' => 'Граммы',
            'Единицы измерения' => 0,
            "user_id" => 1,
        ];
        $this->db->table('ingridient')->insert($data);

        $data = [

            'Наименование'=> 'Вода',
            'rate' => '12'
        ];
        $this->db->table('activity_type')->insert($data);

        $data = [

            'Наименование'=> 'Овощи/фрукты',
            'rate' => '6'
        ];
        $this->db->table('activity_type')->insert($data);

        $data = [

            'Наименование'=> 'Сахар',
            'rate' => '10'
        ];
        $this->db->table('activity_type')->insert($data);

        $data = [

            'Наименование'=> 'Использовано в десертах',
            'date' => '2021-01-24',
            'activity_type_id' => 1,
            'rate' => '10',
            'rating_id' => 2,
        ];
        $this->db->table('activity')->insert($data);

        $data = [

            'Наименование'=> 'Использовано в выпечке',
            'date' => '2021-01-25',
            'activity_type_id' => 2,
            'rate' => '5',
            'rating_id' => 2,
        ];
        $this->db->table('activity')->insert($data);

        $data = [

            'Наименование'=> 'Использовано в мясном',
            'date' => '2021-01-28',
            'activity_type_id' => 3,
            'rate' => '4',
            'rating_id' => 1,
        ];
        $this->db->table('activity')->insert($data);

    }
}
