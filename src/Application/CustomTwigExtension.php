<?php

declare(strict_types=1);

namespace App\Application;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CustomTwigExtension extends AbstractExtension
{
    private $sysTitle;
    private $baseHref;

    public function __construct(string $sysTitle, string $installDir)
    {
        $this->sysTitle = $sysTitle;
        $this->baseHref = '/' . $installDir . '/';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::class;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'getLatestFile',

                /**
                 * @param $filepath
                 * This function generates a new file path with last-modified timestamp
                 * to support better better client caching via Expires header:
                 * i.e:
                 * css/style.css -> css/style.css?20220801155243
                 *
                 * Usage in template files:
                 * i.e:
                 * <link rel="stylesheet" href="{{ getLatestFile('css/style.css') }}">
                 *
                 * @return mixed
                 */
                function ($filepath) {
                    if (file_exists($filepath)) {
                        clearstatcache();
                        echo $filepath . date("?YmdHis", filemtime($filepath));
                    } else {
                        echo $filepath;
                    }
                }
            ),
            new TwigFunction(
                'base_href',

                /**
                 * prints the base href
                 * to be used in <base href="{{ base_href() }}"/> in a twig file
                 * so that all links and refs will be relative to this
                 **/
                function () {
                    echo $this->baseHref;
                }
            ),
            new TwigFunction(
                'sys_title',

                /**
                 * prints the system title
                 * to be used (usually) in <title>{{ page_title }} | {{ sys_title() }}</title> in a twig file
                 */
                function () {
                    echo $this->sysTitle;
                }
            ),
        ];
    }
}
