<?php


use Phinx\Migration\AbstractMigration;

class UsersMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', ['limit' => 60]);
        $table->addColumn('password', 'string', ['limit' => 255]);
        $table->addColumn('email', 'string', ['limit' => 100]);
        $table->addColumn('name', 'string', ['limit' => 200]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('updated', 'datetime', ['null' => TRUE]);
        $table->addIndex(['username', 'email'], ['unique' => TRUE]);
        $table->create();
    }
}
