<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Spravochnik extends Migration
{
    public function up()
    {
        // activity_type
        if (!$this->db->tableexists('ingridient'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'Наименование' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
                'Единицы измерения' => array('type' => 'INT', 'null' => FALSE),
                'created_at' => array('type' => 'TIMESTAMP'),
                'since' => array('type' => 'DATETIME', 'null' => TRUE),
                'user_id' => array('type' => 'int', 'null' => TRUE),
            ));
            $this->forge->addForeignKey('user_id','users','id','RESTRICT','RESRICT');
            // create table
            $this->forge->createtable('ingridient', TRUE);
        }

        if (!$this->db->tableexists('activity_type'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'Наименование' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
                'Единицы измерения' => array('type' => 'TEXT', 'null' => FALSE),
                'rate' => array('type' => 'INT', 'null' => FALSE)
            ));
            // create table
            $this->forge->createtable('activity_type', TRUE);
        }

        // activity_type
        if (!$this->db->tableexists('activity'))
        {
            // Setup Keys
            $this->forge->addkey('id', TRUE);

            $this->forge->addfield(array(
                'id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'Наименование' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
                'date' => array('type' => 'DATE', 'null' => FALSE),
                'rate' => array('type' => 'INT', 'null' => FALSE),
                'activity_type_id' => array('type' => 'INT', 'unsigned' => TRUE),
                'rating_id' => array('type' => 'INT', 'unsigned' => TRUE)
            ));
            $this->forge->addForeignKey('activity_type_id','activity_type','id','RESTRICT','RESRICT');
            $this->forge->addForeignKey('rating_id','rating','id','RESTRICT','RESRICT');
            // create table
            $this->forge->createtable('activity', TRUE);
        }
    }

    //--------------------------------------------------------------------

    public function down()
    {

        $this->forge->droptable('activity');
        $this->forge->droptable('ingridient');
        $this->forge->droptable('activity_type');
    }
}