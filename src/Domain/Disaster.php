<?php

declare(strict_types = 1);

namespace App\Domain;

use Psr\Log\LoggerInterface;
use App\Repository\DisasterRepository;

class Disaster
{

    public function __construct(LoggerInterface $logger, DisasterRepository $Disaster)
    {
        $this->logger = $logger;
        $this->Disaster = $Disaster;
    }

    public function disasterData(): array
    {
        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->getDisaster();
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

    public function disasterabovetype_search($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->insertAbove($data);
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

    public function above_insert($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->insertAbove($data);
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

    public function sub_insert($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->insertSub($data);
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

    public function disaster_aboveupdate($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->updateDisasterAbove($data);
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

    public function disaster_subupdate($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->updateDisasterSub($data);
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

    public function above_delete($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->deleteAbove($data);
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
    
    public function sub_delete($data): array
    {

        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->deleteSub($data);
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

    public function getFunction($data): array
    {
        $response = array("code"=>99,"string"=>"其他系統錯誤","content"=>"");
        try {
            $SearchData = $this->Disaster->getSubData($data);
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
