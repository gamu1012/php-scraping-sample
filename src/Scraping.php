<?php

namespace Gamu1012\Scraping\Sample;

/**
 * Created by PhpStorm.
 * User: gamu1012
 * Date: 2018/02/28
 * Time: 22:34
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Goutte\Client;

class Scraping
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Crawler constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     */
    public function scraping($url)
    {
        $crawler = $this->client->request('GET', $url);
        // CSSセレクタでの指定
        $crawler->filter('h2 > span')->each(function ($node) {
            echo "{$node->text()}\n";
        });
        // XPathでの指定
        $crawler->filterXPath('//*[@id="mw-content-text"]/div/ul/li')->each(function ($node) {
            echo "{$node->text()}\n";
        });

        // とりあえず最初のnodeがほしい
        $node = $crawler->filter('p > b')->first();
        echo "{$node->text()}\n";
        // もちろんCSSセレクタなので、クラス指定もOK
        $node = $crawler->filter('.mw-headline')->first();
        echo "{$node->text()}\n";
        // ユニークなXPathでの取得
        $node = $crawler->filterXPath('//*[@id="mw-content-text"]/div/ul[10]/li[1]');
        echo "{$node->text()}\n";

        // 画像一覧
        $crawler->filter('img')->each(function ($node) {
            echo "{$node->attr('src')}\n";
        });

        // 日本という文字をふくむものだけ取得
        $crawler
            ->filterXPath('//*[@id="mw-content-text"]/div/ul/li')
            ->reduce(function ($node, $i) {
                return strpos($node->text(), '日本') !== false;
            })
            ->each(function ($node) {
                echo "{$node->text()}\n";
            });
    }
}

$s = new Scraping(new Client());
$s->scraping('https://ja.wikipedia.org/wiki/%E4%B8%96%E7%95%8C%E4%B8%80%E3%81%AE%E4%B8%80%E8%A6%A7');
