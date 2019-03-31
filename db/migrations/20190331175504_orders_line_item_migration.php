<?php


use Phinx\Migration\AbstractMigration;

class OrdersLineItemMigration extends AbstractMigration
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
        $table = $this->table('orders_line_items');
        $table->addColumn('order_id', 'integer');
        $table->addColumn('product_id', 'integer');
        $table->addColumn('type', 'integer');
        $table->addColumn('quantity', 'integer');
        $table->addColumn('price', 'integer');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}
