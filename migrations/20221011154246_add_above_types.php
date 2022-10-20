<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;
use Phoenix\Database\Element\ColumnSettings;

final class AddAboveTypes extends AbstractMigration
{
    protected function up(): void
    {
        // 災害類別(大項)
        $this->table('disasterAboveType',true)
        ->addColumn('id', 'integer', ['comment' => '編號', 'autoincrement' => true])
        ->addColumn('aboveName','string',['length' => 20,'comment' => '災害名稱_大項'])
        ->addColumn('create_time', 'timestamp', ['default'=>  ColumnSettings::DEFAULT_VALUE_CURRENT_TIMESTAMP , 'comment' => '建立時間'])
        ->create();

        // 災害類別(大項)資料
        $this->insert('disasterAboveType', [
            [   'aboveName' => '路樹災情'],
            [   'aboveName' => '廣告招牌災情'],
            [   'aboveName' => '橋梁災情'],
            [   'aboveName' => '鐵路、高鐵及捷運災情'],
            [   'aboveName' => '積淹水災情'],
            [   'aboveName' => '土石災情'],
            [   'aboveName' => '水利設施災害'],
            [   'aboveName' => '建物毀損'],
            [   'aboveName' => '民生、基礎設施災情'],
            [   'aboveName' => '車輛及交通事故'],
            [   'aboveName' => '環境汙染'],
            [   'aboveName' => '火災'],
            [   'aboveName' => '其他災情'],
        ]);

        // 災害類別(細項)
        $this->table('disasterSubType',true)
        ->addColumn('id', 'integer', ['comment' => '編號', 'autoincrement' => true])
        ->addColumn('subName','string',['length' => 20,'comment' => '災害名稱_細項'])
        ->addColumn('authority','string',['length' => 10,'comment' => '所屬機關'])
        ->addColumn('parent_id','integer',['comment' => '災害類別上層層級'])
        ->addColumn('create_time', 'timestamp', ['default'=>  ColumnSettings::DEFAULT_VALUE_CURRENT_TIMESTAMP , 'comment' => '建立時間'])
        ->create();

         // 災害類別(細項)資料
        $this->insert('disasterSubType', [
            [   'subName' => '路樹災情',
                'authority' => '工程搶修組',
                'parent_id' => 1,],
            [   'subName' => '廣告招牌欲墜',
                'authority' => '工程搶修組',
                'parent_id' => 2,],
            [   'subName' => '廣告招牌掉落',
            'authority' => '工程搶修組',
            'parent_id' => 2,],
            [   'subName' => '道路邊坡坍方/落石',
            'authority' => '工程搶修組',
            'parent_id' => 3,],
            [   'subName' => '道路、隧道施工區受損',
            'authority' => '工程搶修組',
            'parent_id' => 3,],
            [   'subName' => '道路路基流失/坑洞',
            'authority' => '工程搶修組',
            'parent_id' => 3,],
            [   'subName' => '前述以外之道路、隧道災情',
            'authority' => '工程搶修組',
            'parent_id' => 3,],
            
        ]);
    }

    protected function down(): void
    {
        $this->table('disasterAboveType')->drop();
        $this->table('disasterSubType')->drop();
    }
}
