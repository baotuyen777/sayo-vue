<?php

namespace App\Services;

use App\Exports\NewsExport;
use App\Models\News;
use Carbon\Carbon;

class NewsService
{
    public $context;

    public function crawl($url, $isSingle = false)
    {
        $this->init();
        $html = file_get_html($url, null, $this->context);
        $this->removeUnuse($html);
        $this->saveImage($html);

        if ($isSingle) {
            $this->crawlPost($url);
            return;
        }
        if (!$html->find('.large-columns-1', 0)) {
            echo $html;
            return false;
        }

        $tags = $html->find('.large-columns-1', 0)->find('.post-item');
        foreach ($tags as $tag) {
            echo '<hr/>';
            $avatarLink = $this->getImageLink($tag);
            $a = $tag->find('a', 0);
            $this->crawlPost($a->href, $avatarLink);
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

    function saveImage($html)
    {
        $this->replaceLayzySrc($html);
        $imgs = $html->find('.large-9 img');
        $storagePath = storage_path('app/public/uploads/hotgirl/');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775);
        }

        foreach ($imgs as $i => $img) {
            $imageSrc = $img->src;

            $path = parse_url($imageSrc, PHP_URL_PATH);
            $filename = basename($path);
            if (strpos($filename, '.') && !file_exists($storagePath . $filename)) {
                $imageData = file_get_contents($imageSrc, false, $this->context);
                file_put_contents($storagePath . $filename, $imageData);
            }
        }
    }

    function replaceLayzySrc($html)
    {
        $imgElements = $html->find('img');
        foreach ($imgElements as $imgElement) {

            $src = preg_match('/\.(jpg|png|webp|jpeg)$/', $imgElement->src) ? $imgElement->src : $imgElement->getAttribute('data-lazy-src');
            if ($imgElement->src == 'https://badova.net/wp-content/uploads/2019/08/logo-badova.png') {
                continue;
            }

            if (!$src) {
                $srcset = $imgElement->getAttribute('srcset');
                if ($srcset) {
                    $src = explode(' ', $srcset[0])[0];
                }
            }

            if (!$src) {
                dd($imgElement);
            }
            $imgElement->src = $src;

            $attr = 'data-lazy-src';
            $attr1 = 'data-lazy-srcset';
            unset($imgElement->$attr, $imgElement->$attr1);
        }

        $html->save();
    }

    public function crawlPost($url, $avatarLink = '')
    {
        $html = file_get_html($url, null, $this->context);
        $this->removeUnuse($html);
        $this->replaceLayzySrc($html);

        $this->saveImage($html);

        $content = $html->find('.single-page');


        $pattern = '/(https:\/\/badova\.net\/[^ ]+\/\d{4}\/\d{2}\/)([^ ]+\.(jpg|png|webp|jpeg))/';

        $replacement = asset('storage/uploads/hotgirl/$2');

        $content = preg_replace($pattern, $replacement, $content);

        $content = str_replace('badova.net', 'sayo.vn', $content);
        $content = str_replace('Badova', 'Sayo', $content);


        $param = [
            'name' => $this->getTitle($html),
            'code' => str_replace(['https://badova.net/', '/'], '', $url),
            'content' => $content[0],
            'category_id' => 1,
            'avatar_link' => $avatarLink,
            'author_id' => 1,
            'created_at' => Carbon::now()
        ];

        $obj = News::where('code', $param['code'])->first();
        echo $param['name'];
        if (!$obj) {
            News::create($param);
            echo ' -------->insert success';
        } else {
            echo ' -------->abort';
        }

    }

    function removeUnuse($html)
    {
        $divToRemove = $html->find('.blog-share', 0);
        if ($divToRemove !== null) {
            $divToRemove->outertext = '';
        }

        $divToRemove = $html->find('.header', 0);

        if ($divToRemove !== null) {
            $divToRemove->outertext = '';
        }

        $html->save();
    }

    function getTitle($html)
    {
        $tag = $html->find('h1', 0);
        return str_replace(['&#8220;', '&#8221;'], '"', $tag->plaintext ?? '');
    }
//    function saveImageInSrcSet($img){
//        dd($img);
//    }

    function getImageLink($html)
    {
//        $html = str_get_html($content);
        $img = $html->find('img', 0);
        $link = $img->src;

        $pattern = '/(https:\/\/badova\.net\/[^ ]+\/\d{4}\/\d{2}\/)([^ ]+\.jpg)/';

        $replacement = asset('storage/uploads/hotgirl/$2');

        return preg_replace($pattern, $replacement, $link);
    }
}
