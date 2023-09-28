<?php

namespace App\Services\Post;

use App\Models\News;
use Carbon\Carbon;

class PostCrawlService
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

        $tags = $html->find('.large-columns-1', 0)->find('.post-item');
        foreach ($tags as $tag) {
            echo '<hr/>';
            $avatarLink = $this->getImageLink($tag);
            $a = $tag->find('a', 0);
            $this->crawlPost($a->href, $avatarLink);
        }


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

    public function init()
    {
        $this->context = stream_context_create(array("http" => array("header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36")));
    }
}
