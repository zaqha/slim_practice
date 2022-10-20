<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;

final class DepartmentCreate extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('department', 'id')
        ->addColumn('id', 'string', ['comment' => '編號','length' => 10])
        ->addColumn('name', 'string', ['comment' => '名稱','length' => 50])
        ->addColumn('is_deleted', 'boolean', ['comment' => '是否刪除','default' => 0])
        ->addColumn('created_time', 'datetime', ['comment' => '建立日期'])
        ->addColumn('create_user_id', 'string', ['comment' => '建立人','length' => 30])
        ->addColumn('updated_time', 'datetime', ['comment' => '最後更新日','null' => true])
        ->addColumn('update_user_id', 'string', ['comment' => '最後更新人','null' => true,'length' => 30])
        ->create();
    }

    protected function down(): void
    {
        $this->table('department')->drop();
    }
}
