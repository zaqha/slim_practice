<?php

declare(strict_types=1);

namespace App\Application\Actions\DisasterType;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Settings\SettingsInterface;
use Psr\Log\LoggerInterface;
use App\Domain\Disaster;
use App\Domain\FileHandling;
use Slim\Views\Twig;

class DisasterTypeAction
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
        Disaster $Disaster,
        Twig $twig,
        FileHandling $FileHandling
    ) {
        $this->settings = $settings;
        $this->logger = $logger;
        $this->Disaster = $Disaster;
        $this->FileHandling = $FileHandling;
        $this->twig = $twig;
    }
    // 取得災情類別管理大項
    public function __invoke(Request $request, Response $response): Response
    {
        $res = $this->Disaster->disasterData();
        return $this->twig->render(
            $response->withStatus(200),
            'disasterType/disasterTypePage.twig',
            [
                'session' => $_SESSION,
                'hidden' => '',
                'disasterabovetype' => $res['content']
            ]
        );
    }
    // 取得災情類別管理細項
    public function getsubName(Request $request, Response $response, $args): Response
    {
        $subFunctionList = $this->Disaster->getFunction($args['roleId']);
        return $this->twig->render(
            $response->withStatus(200),
            'disasterType/SubdisasterfunctionTab.twig',
            [
                'session' => $_SESSION,
                'roleId' => $args['roleId'],
                'subFunctionList' => $subFunctionList['content'],
            ]
        );
    }

    public function search(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (isset($FormData['id']) && strlen($FormData['id']) > 10) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '編號欄位長度過長'
            );
        } else if (isset($FormData['name']) && strlen($FormData['name']) > 50) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '名稱欄位長度過長'
            );
        } else if (isset($FormData['is_deleted']) && !in_array($FormData['is_deleted'], array('0', '1'))) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '是否刪除欄位內容錯誤'
            );
        } else {
            $res = $this->Department->department_search($FormData);
        }


        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function aboveInsert(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['name'])) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '大項名稱未輸入'
            );
        } else {
            $res = $this->Disaster->above_insert($FormData['name']);
        }


        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response;
    }

    public function subInsert(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();
        $res = $this->Disaster->sub_insert($FormData);


        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response;
        // ->withHeader('Content-Type', 'application/json')
        // ->withStatus(200);
    }

    public function aboveUpdate(Request $request, Response $response, array $args)
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['aboveName'])) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '大項名稱未輸入'
            );
        } else {
            $res = $this->Disaster->disaster_aboveupdate($FormData);
        }

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response;
    }

    public function subUpdate(Request $request, Response $response, array $args)
    {
        $FormData = $request->getParsedBody();

        if (!isset($FormData['subName'])) {
            $res = array(
                'code' => 99,
                'string' => '輸入內容錯誤，請重新輸入',
                'content' => '細項名稱未輸入'
            );
        } else {
            $res = $this->Disaster->disaster_subupdate($FormData);
        }

        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response;
    }

    public function aboveDelete(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();
        $res = $this->Disaster->above_delete($FormData);
        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    
    public function subDelete(Request $request, Response $response, array $args): Response
    {
        $FormData = $request->getParsedBody();
        $res = $this->Disaster->sub_delete($FormData);
        $json = json_encode($res, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

}
