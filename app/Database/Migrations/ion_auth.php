<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IonAuth extends Migration
{

    public function up()
    {
        // groups
        if (!$this->db->tableexists('groups'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'Наименование' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => FALSE),
            ));
            // create table
            $this->forge->createtable('groups', TRUE);
        }

        // users
        if (!$this->db->tableexists('users'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'ip_address' => array('type' => 'VARCHAR', 'constraint' => '45', 'null' => FALSE),
                'username' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
                'password' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
                'email' => array('type' => 'VARCHAR', 'constraint' => '254', 'null' => FALSE, 'unique'=>'TRUE'),
                'activation_selector' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'unique'=>'TRUE'),
                'activation_code' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
                'forgotten_password_selector' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'unique'=>'TRUE'),
                'forgotten_password_code' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
                'forgotten_password_time' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE),
                'remember_selector' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'unique'=>'TRUE'),
                'remember_code' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
                'created_on' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => FALSE),
                'last_login' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE),
                'active' => array('type' => 'tinyint', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE),
                'first_name' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
                'last_name' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
                'company' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
                'phone' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => TRUE)
            ));
            // create table
            $this->forge->createtable('users', TRUE);
        }

        // users_groups
        if (!$this->db->tableexists('users_groups'))
        {
            // Setup keys
            $this->forge->addkey('id', TRUE);

            // Build Schema
            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'user_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE),
                'group_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE)
            ));

            $this->forge->addForeignKey('user_id','users','id','RESTRICT','RESRICT');
            $this->forge->addForeignKey('group_id','groups','id','RESTRICT','RESRICT');
            // create table
            $this->forge->createtable('users_groups', TRUE);
        }

        if (!$this->db->tableexists('login_attempts'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'ip_address' => array('type' => 'VARCHAR', 'constraint' => '45', 'null' => FALSE),
                'login' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
                'time' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => FALSE)
            ));
            // create table
            $this->forge->createtable('login_attempts', TRUE);

        }

    }
    //--------------------------------------------------------------------
    public function down()
    {
        $this->forge->droptable('users_groups');
        $this->forge->droptable('groups');
        $this->forge->droptable('users');
        $this->forge->droptable('login_attempts');
    }
}
