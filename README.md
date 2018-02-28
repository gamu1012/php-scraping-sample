# php-scraping-sample

PHPで `goutte` を用いたスクレイピングのサンプルリポジトリ

## 基本的な利用方法
```
        $client = new Client();
        $url = 'URL';
        $crawler = $client->request('GET',$url);
        $crawler->filter('h2 > a')->each(function ($node) {
          print $node->text()."\n";
        });
```

## CSSセレクタで指定
```
        // CSSセレクタでの指定
        $crawler->filter('h2 > span')->each(function ($node) {
            echo "{$node->text()}\n";
        });

```

## XPathでの指定
```
        $crawler->filterXPath('//*[@id="mw-content-text"]/div/ul/li')->each(function ($node) {
            echo "{$node->text()}\n";
        });
```

## 単一nodeの取得
```
        // とりあえず最初のnodeがほしい
        $node = $crawler->filter('p > b')->first();
        echo "{$node->text()}\n";
        // もちろんCSSセレクタなので、クラス指定もOK
        $node = $crawler->filter('.mw-headline')->first();
        echo "{$node->text()}\n";
        // ユニークなXPathでの取得
        $node = $crawler->filterXPath('//*[@id="mw-content-text"]/div/ul[10]/li[1]');
        echo "{$node->text()}\n";
```

## 画像一覧がほしい
```
        // 画像一覧 実際にはスキーム省略や相対パスへの対応が必要
        $crawler->filter('img')->each(function ($node) {
            echo "{$node->attr('src')}\n";
        });
```
