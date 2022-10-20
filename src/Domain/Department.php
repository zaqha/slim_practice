<?php

declare(strict_types = 1);

namespace App\Domain;

use Psr\Log\LoggerInterface;
use App\Repository\DepartmentRepository;

class Department
{

    public function __construct(LoggerInterface $logger, DepartmentRepository $Department)
    {
        $this->logger = $logger;
        $this->Department = $Department;
    }

    public function department_search($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->getDepartment("*",$data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

    public function department_insert($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->insertDepartment($data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

    public function department_update($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->updateDepartment($data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

    public function department_delete($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->deleteDepartment($data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

    public function department_duplicate($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->duplicateDepartment($data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

    public function department_export($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Department->getDepartment("id, name, is_deleted",$data);
            $response['code'] = 0;
            $response['string'] = "成功";
            $response['content'] = $SearchData;
        } catch (\PDOException $e) {
            $response['code'] = 2;
            $response['string'] = "資料庫查詢錯誤";
            $response['content'] = $e;
        } catch (\Exception $e) {
            $response['code'] = 3;
            $response['string'] = "其他系統錯誤";
            $response['content'] = $e;
        }
        return $response;
    }

}
