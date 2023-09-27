<?php

namespace App\Services;

use App\Exports\NewsExport;
use App\Models\News;
use Carbon\Carbon;

class NewsService
{
    public $context;

    public function crawl($url)
    {

    }
    public function crawlPost($url)
    {
        $this->init();
        $html = file_get_html($url, null, $this->context);
        $this->replaceLayzySrc($html);
        $this->removeUnuse($html);

        $content = $html->find('.single-page');


        $pattern = '/(https:\/\/badova\.net\/[^ ]+\/\d{4}\/\d{2}\/)([^ ]+\.jpg)/';

        $replacement = asset('storage/uploads/hotgirl/$2');

        $content = preg_replace($pattern, $replacement, $content);

        $content = str_replace("https://badova.net/hotgirl/", 'https://sayo.vn/hotgirl/', $content);
        $content = str_replace('<a href="https://badova.net/" target="_blank" rel="noreferrer noopener">Badova</a>', '<a href="https://sayo.vn.net/" target="_blank" rel="noreferrer noopener">Sayo</a>', $content);


        $this->saveImage($html);
        $param = [
            'name' => $this->getTitle($html),
            'code' => str_replace(['https://badova.net/', '/'], '', $url),
            'content' => $content[0],
            'category_id' => 1,
            'avatar_link' => $this->getFirstImage($content[0]),
            'author_id' => 1,
            'created_at' => Carbon::now()
        ];

        $obj = News::where('code', $param['code'])->first();
        echo $param['name'];
        if (!$obj) {
            News::create($param);
            echo ' -------->insert success';
        }else{
            echo ' -------->abort';
        }

    }

    public function init()
    {
        $this->context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                )
            )
        );
    }

    function replaceLayzySrc($html)
    {
        $imgElements = $html->find('img');
        foreach ($imgElements as $imgElement) {
            $dataLazySrc = $imgElement->getAttribute('data-lazy-src');
            $imgElement->src = $dataLazySrc;
            $attr = 'data-lazy-src';
            $attr1 = 'data-lazy-srcset';
            unset($imgElement->$attr, $imgElement->$attr1);
        }

        $html->save();
    }

    function removeUnuse($html)
    {
        $divToRemove = $html->find('.blog-share', 0);
        if ($divToRemove !== null) {
            $divToRemove->outertext = '';
        }

        $html->save();
    }

    function saveImage($html)
    {
        $imgs = $html->find('.single-page img');
        $storagePath = storage_path('app/public/uploads/hotgirl/');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775);
        }

        foreach ($imgs as $img) {
            $imageSrc = $img->src;
            $path = parse_url($imageSrc, PHP_URL_PATH);
            $filename = basename($path);
            if (strpos($filename, '.') && !file_exists($storagePath . $filename)) {
                $imageData = file_get_contents($imageSrc, false, $this->context);
                file_put_contents($storagePath . $filename, $imageData);
            }
        }
    }

    function getTitle($html)
    {
        $tag = $html->find('h1', 0);
        return $tag->plaintext ?? ';';
    }

    function getFirstImage($content)
    {
        $html = str_get_html($content);
        $img = $html->find('img', 0);
        return $img->src;
    }
}
