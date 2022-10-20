<?php
declare(strict_types=1);

namespace App\Application\Actions\Department;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Settings\SettingsInterface;
use Psr\Log\LoggerInterface;
use App\Domain\Department;
use App\Domain\FileHandling;

class DepartmentAction
{
    protected LoggerInterface $logger;
    protected SettingsInterface $settings;
    protected Request $request;
    protected Response $response;
    protected array $args;
    protected $res = array();

    public function __construct(
        LoggerInterface $logger,
        SettingsInterface $settings,
        Department $Department,
        FileHandling $FileHandling
    )
    {
        $this->settings = $settings;
        $this->logger = $logger;
        $this->Department = $Department;
        $this->FileHandling = $FileHandling;
    }

    public function search(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (isset($FormData['id']) && strlen($FormData['id']) > 10) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長');
        }
        else if (isset($FormData['name']) && strlen($FormData['name']) > 50) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位長度過長');
        }
        else if (isset($FormData['is_deleted']) && !in_array($FormData['is_deleted'],array('0','1'))) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '是否刪除欄位內容錯誤');
        }
        else {
            $res = $this->Department->department_search($FormData);
        }
        

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function insert(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位未輸入');
        }
        else if (empty($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位內容不可為空');
        }
        else if (!isset($FormData['name'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位未輸入');
        }
        else if (empty($FormData['name'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位內容不可為空');
        }
        else if (strlen($FormData['id']) > 10) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長');
        }
        else if (strlen($FormData['name']) > 50) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位長度過長');
        }
        else {
            $check_id = $this->Department->department_search(array('id' => $FormData['id']));
            $check_name = $this->Department->department_search(array('name' => $FormData['name']));
            if ($check_id['code'] == 0 && !empty($check_id['content'])) {
                $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位重複');
            }
            else if ($check_name['code'] == 0 && !empty($check_name['content'])) {
                $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位重複');
            }
            else {
                $res = $this->Department->department_insert($FormData);
            }
            
        }
        

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位未輸入');
        }
        else if (empty($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位內容不可為空');
        }
        else if (!isset($FormData['name'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位未輸入');
        }
        else if (empty($FormData['name'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位內容不可為空');
        }
        else if (strlen($FormData['id']) > 10) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長');
        }
        else if (strlen($FormData['name']) > 50) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位長度過長');
        }
        else {
            $check_id = $this->Department->department_search(array('id' => $FormData['id']));
            $check_name = $this->Department->department_search(array('name' => $FormData['name']));
            if ($check_id['code'] == 0 && empty($check_id['content'])) {
                $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '未查詢到該編號欄位資料');
            }
            else if ($check_name['code'] == 0 && !empty($check_name['content'])) {
                $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位重複');
            }
            else {
                $res = $this->Department->department_update($FormData);
            }
            
        }
        

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位未輸入');
        }
        else if (empty($FormData['id'])) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位內容不可為空');
        }
        else if (strlen($FormData['id']) > 10) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長');
        }
        else {
            $check_id = $this->Department->department_search(array('id' => $FormData['id']));
            if ($check_id['code'] == 0 && empty($check_id['content'])) {
                $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '未查詢到該編號欄位資料');
            }
            else {
                $res = $this->Department->department_delete($FormData);
            }
            
        }
        

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function import(Request $request, Response $response, array $args): Response
    {
        //如果有EXCEL就走EXCEL
        if (!empty($request->getUploadedFiles())) {
            $FileData = $request->getUploadedFiles();
            
            $mediaType = $FileData['file']->getClientMediaType();
            $size = $FileData['file']->getSize();
            $name = $FileData['file']->getClientFilename();
            $last_name = explode(".",$name);
            $last_name = end($last_name);
            //判斷類型
            if (in_array($last_name,array("xlsx","xls"))) {
                //分析資料
                $excel_data = $this->FileHandling->excel_parse($FileData['file']->getFilePath());
                //判斷資料
                foreach ($excel_data as $key => $value) {
                    // 第一個資料丟棄
                    if ($key == 0) { continue; }
                    if (!isset($value[0])) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行編號欄位未輸入');
                        break;
                    }
                    else if (empty($value[0])) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行編號欄位內容不可為空');
                        break;
                    }
                    else if (!isset($value[1])) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行名稱欄位未輸入');
                        break;
                    }
                    else if (empty($value[1])) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行名稱欄位內容不可為空');
                        break;
                    }
                    else if (strlen($value[0]) > 10) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行編號欄位長度過長');
                        break;
                    }
                    else if (strlen($value[1]) > 50) {
                        $res = array('code' => 99,
                            'string' => '輸入內容錯誤，請重新輸入',
                            'content' => '第'.($key+1).'行名稱欄位長度過長');
                        break;
                    }
                    else {
                        $check_id = $this->Department->department_search(array('id' => $value[0]));
                        $check_name = $this->Department->department_search(array('name' => $value[1]));
                        if ($check_id['code'] == 0 && !empty($check_id['content'])) {
                            $res = array('code' => 99,
                                'string' => '輸入內容錯誤，請重新輸入',
                                'content' => '第'.($key+1).'行編號欄位重複');
                            break;
                        }
                        else if ($check_name['code'] == 0 && !empty($check_name['content'])) {
                            $res = array('code' => 99,
                                'string' => '輸入內容錯誤，請重新輸入',
                                'content' => '第'.($key+1).'行名稱欄位重複');
                            break;
                        }
                    }
                }
                //儲存資料
                if (empty($res)) {
                    foreach ($excel_data as $key => $value) {
                        // 第一個資料丟棄
                        if ($key == 0) { continue; }
                        $insert_data = array('id' => $value[0],'name' => $value[1]);
                        $res = $this->Department->department_insert($insert_data);
                    }
                }
            } else {
                $res = array('code' => 99,
                    'string' => '輸入內容錯誤，請重新輸入',
                    'content' => '檔案僅限excel格式');
            }
        } else if (!empty($_SESSION['system_config']['DepartmentImportApiUrl'])) {
            //如果有介接URL就走介接
            $url = $_SESSION['system_config']['DepartmentImportApiUrl']; 
  
            $ch = curl_init(); //建立CURL連線
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $reData = curl_exec($ch);
            curl_close($ch); //關閉CURL連線
            $reData = json_decode($reData,true);
            
            foreach ($reData as $key => $value) {
                if (!isset($value['id'])) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行編號欄位未輸入');
                    break;
                }
                else if (empty($value['id'])) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行編號欄位內容不可為空');
                    break;
                }
                else if (!isset($value['name'])) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行名稱欄位未輸入');
                    break;
                }
                else if (empty($value['name'])) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行名稱欄位內容不可為空');
                    break;
                }
                else if (strlen($value['id']) > 10) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行編號欄位長度過長');
                    break;
                }
                else if (strlen($value['name']) > 50) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行名稱欄位長度過長');
                    break;
                }
                else if (!isset($value['is_deleted'])) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'行是否刪除欄位未輸入');
                    break;
                }
                else if (!in_array($value['is_deleted'],array('0','1'))) {
                    $res = array('code' => 99,
                        'string' => '輸入內容錯誤，請重新輸入',
                        'content' => '第'.($key+1).'是否刪除欄位內容錯誤');
                }
            }
            //儲存資料
            if (empty($res)) {
                foreach ($reData as $key => $value) {
                    $res = $this->Department->department_duplicate($value);
                }
            }

        } else {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '請上傳檔案或是設定介接路徑');
        }
        
        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }

    public function export(Request $request, Response $response, array $args): Response
    {
        
        $FormData = $request->getParsedBody();

        if (isset($FormData['id']) && strlen($FormData['id']) > 10) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長');
        }
        else if (isset($FormData['name']) && strlen($FormData['name']) > 50) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位長度過長');
        }
        else if (isset($FormData['is_deleted']) && !in_array($FormData['is_deleted'],array('0','1'))) {
            $res = array('code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '是否刪除欄位內容錯誤');
        }
        else {
            $search = $this->Department->department_export($FormData);
            if ($search['code'] == 0) {
                $title = array('編號','名稱','是否刪除(0為否,1為是)');
                $tempFile = $this->FileHandling->excel_export($title,$search['content']);
                $res = array('code' => 0,
                    'string' => '成功',
                    'content' => $tempFile);
            } else {
                $res = $search;
            }
            
        }
        

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
    }
}
