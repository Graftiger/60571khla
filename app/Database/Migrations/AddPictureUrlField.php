<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addpictureurlfield extends Migration
{
    public function up()
    {
        if ($this->db->tableexists('ingridient'))
        {
            $this->forge->addColumn('ingridient',array(
                'picture_url' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE)
            ));
        }
    }
    public function down()
    {
        $this->forge->dropColumn('ingridient', 'picture_url');
    }
}