<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Ion_Auth extends Seeder
{
    public function run()
    {
        $data = [
            'Наименование' => 'admin',
        ];
        $this->db->table('groups')->insert($data);

        $data = [
            'Наименование' => 'members',
        ];

        $this->db->table('groups')->insert($data);

        $data = [
            'ip_address'=> '127.0.0.1',
            'username'=>'administrator',
            'password'=>'$2y$08$200Z6ZZbp3RAEXoaWcMA6uJOFicwNZaqk4oDhqTUiFXFe63MG.Daa',
            'email'=>'admin@admin.com',
            'activation_selector'=>'',
            'activation_code'=>'',
            'forgotten_password_selector'=>NULL,
            'forgotten_password_code'=>NULL,
            'forgotten_password_time'=>NULL,
            'remember_selector'=>NULL,
            'remember_code'=>NULL,
            'created_on'=>'1268889823',
            'last_login'=>'1268889823',
            'active'=>'1',
            'first_name' => 'Admin',
            'last_name' => 'istrator',
            'company' => 'ADMIN',
            'phone' => '0'
        ];
        $this->db->table('users')->insert($data);

        $data = [
            'user_id' => 1,
            'group_id'=> 1,
        ];

        $this->db->table('users_groups')->insert($data);

        $data = [
            'user_id' => 1,
            'group_id'=> 2,
        ];
        $this->db->table('users_groups')->insert($data);
    }
}