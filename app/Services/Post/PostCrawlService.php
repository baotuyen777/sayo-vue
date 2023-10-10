<?php

namespace App\Services\Post;

use App\Models\News;
use Carbon\Carbon;

class PostCrawlService
{
    public $context;

    public $html;

    public function crawl($url, $isSingle = false)
    {
        $this->init();
        $this->html = file_get_html($url, null, $this->context);
        $this->removeNode(['.NaviPage', '.des_bottom']);
//        $this->saveImage($html);

        if ($isSingle) {
            $this->crawlPost($url);
            return;
        }

//        $tags = $html->find('.large-columns-1', 0)->find('.post-item');
        $this->html  = $this->html->find('.list_content_bds',0);

        $posts = $this->html->find('.subCateBDS ');

//        echo ($this->html[0]);
        foreach ($posts as $post) {
            echo '<hr/>';
            $avatarLink = $this->getAvatar($post);
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

    function removeNode($selectors)
    {
        foreach ($selectors as $selector) {
            $divToRemove = $this->html->find($selector, 0);
            if ($divToRemove ) {
                $divToRemove->remove();
            }
        }

//        $this->html->save();
    }

//    public function removeNode($selector)
//    {
//        foreach ($this->find($selector) as $node) {
//            $node->outertext = '';
//        }
//
//        $this->load($this->save());
//    }

    function getAvatar($html)
    {
//        $html = str_get_html($content);
        $img = $html->find('img', 0);
        $link = $img->src;
//https://rongbaybizfly.mediacdn.vn//thumb_w/180/rb_up_new/2023/10/08/1804018/rongbay-4197e6ca46fb92a5cbea-pzdlvo-20231008142212.jpg
        $pattern = '/(https:\/\/badova\.net\/[^ ]+\/\d{4}\/\d{2}\/)([^ ]+\.jpg)/';

        $replacement = asset('storage/uploads/bds/$2');

        return preg_replace($pattern, $replacement, $link);
    }
}
