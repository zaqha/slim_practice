<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;

final class SystemConfigCreate extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('system_config', 'id')
        ->addColumn('id', 'integer', ['comment' => '編號','autoincrement' => true])
        ->addColumn('name', 'string', ['comment' => '名稱','length' => 50])
        ->addColumn('value', 'string', ['comment' => '設定值','length' => 500])
        ->addColumn('description', 'string', ['comment' => '名稱','length' => 500])
        ->addColumn('is_deleted', 'boolean', ['comment' => '是否刪除','default' => 0])
        ->addColumn('created_time', 'datetime', ['comment' => '建立日期'])
        ->addColumn('create_user_id', 'string', ['comment' => '建立人','length' => 30])
        ->addColumn('updated_time', 'datetime', ['comment' => '最後更新日','null' => true])
        ->addColumn('update_user_id', 'string', ['comment' => '最後更新人','null' => true,'length' => 30])
        ->create();

        $this->insert('system_config', [
            [
                'name' => 'DepartmentImportApiUrl',
                'value' => '',
                'description' => '單位匯入介接URL',
                'created_time' => date("Y-m-d H:i:s"),
                'create_user_id' => 'SYSTEM'
            ],
        ]);
    }

    protected function down(): void
    {
        $this->table('system_config')->drop();
    }
}
