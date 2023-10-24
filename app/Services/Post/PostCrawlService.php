<?php

namespace App\Services\Post;

use App\Models\Files;
use App\Models\News;
use App\Models\Post;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Support\Facades\DB;

class PostCrawlService
{
    public $context;

    public $html;

    public function crawl($url, $isSingle = false)
    {
        $this->init();
        $this->html = file_get_html($url, null, $this->context);
        $this->removeNode(['.NaviPage', '.des_bottom']);

        if ($isSingle) {
//            $img
//            $this->saveImage($,$dir);
//            $this->crawlPost($url);
            return;
        }

        $this->html = $this->html->find('.list_content_bds', 0);

        $posts = $this->html->find('.subCateBDS ');

        foreach ($posts as $i => $post) {
            $img = $post->find('img', 0);
            $imageSrc = $img->src;
            if (strpos($imageSrc, 'no_images')) {
                continue;
            }

            $month = date('Y-m');
            $dir = "{$month}/bds";
            $file = $this->saveImage($imageSrc, $dir);

            if (!$file) {
                continue;
            }

            $avatarLink = asset("storage/{$file['url']}");

            $a = $post->find('.ad_item_id', 0);
            echo $i . '. ' . $avatarLink;
            $this->crawlPost($a->href, $file);
            echo '<hr/>';
            if ($i > 1) {
                break;
            }
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
            if ($divToRemove) {
                $divToRemove->remove();
            }
        }
    }

    function saveImage($imageSrc, $dir = 'crawl')
    {
        $storagePath = storage_path("app/public/uploads/$dir/");
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        if (strpos($imageSrc, 'no_images')) {
            return '';
        }

        $path = parse_url($imageSrc, PHP_URL_PATH);
        $filename = basename($path);

        $param = ['name' => $filename, 'url' => "uploads/$dir/$filename"];
        $fullPath = $storagePath . $filename;
        if (strpos($filename, '.') && !file_exists($fullPath)) {
            $imageData = curlGetContents($imageSrc);
            if ($imageData) {
                file_put_contents($fullPath, $imageData);
                $file = Files::create($param);
                return $file;
            }
        }

        return Files::where('name', $filename)->first();
    }

    function saveGallery($post, $html)
    {
        $gallery = $html->find('.zoom-gallery', 0);
        $imgs = $gallery->find('a');

        $month = date('Y-m');
        $dir = "{$month}/bds";
        $fileIds = [];
        foreach ($imgs as $img) {
            $file = $this->saveImage($img->href, $dir);
            $fileIds[] = $file->id;
        }

        if ($post && $fileIds) {
            $post->files()->sync($fileIds);
        }
    }

    public function crawlPost($url, $avatar)
    {
        $html = file_get_html($url, null, $this->context);

        $html = $html->find('.detail_popup', 0);
        $content = $html->find('.box_infor_ct', 0);
        $description = $html->find('.info_text', 0);

        $title = $this->getTitle($html);
        $param = [
            'name' => $title,
            'code' => vn2code($title) . '-' . time(),
            'content' => $content . $description,
            'category_id' => 1,
            'avatar_id' => $avatar->id,
            'author_id' => 1,
            'created_at' => Carbon::now(),
            'source' => $url,
//            'price' => 100000,
//            'province_id' => 1,
        ];

        $obj = Post::where('source', $url)->first();
        echo $param['name'];
        if (!$obj) {
            $obj = Post::create($param);
            echo '<span style="color: green"> -------->insert success</span>';
            $this->saveGallery($obj, $html);

        } else {
            echo '<span style="color: red"> -------->abort</span>';
        }

    }

    function getTitle($html)
    {
        $tag = $html->find('h1', 0);
        return str_replace(['&#8220;', '&#8221;'], '"', $tag->plaintext ?? '');
    }
}
