<?php

namespace App\Services\Post;

use App\Models\Files;
use App\Models\Pdw\District;
use App\Models\Pdw\Province;
use App\Models\Pdw\Ward;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PostCrawlService
{
    public $context;

    public $html;

    public $provinces = [];
    public $districts = [];
    public $wards = [];

    public function crawl($url)
    {
        $this->init($url);

        $posts = $this->html->find('.subCateBDS ');
        foreach ($posts as $i => $post) {
            $img = $post->find('img', 0);
            $imageSrc = $img->src;
            if (strpos($imageSrc, 'no_images')) {
                continue;
            }

            $month = date('Y-m');
            $dir = "{$month}/bds/thumb";
            $file = $this->saveImage($imageSrc, $dir);

            if (!$file) {
                continue;
            }

            $avatarLink = asset("storage/{$file['url']}");

            $a = $post->find('.ad_item_id', 0);
            echo $i . '. ' . $avatarLink;
            $this->crawlPost($a->href, $file);
            echo '<hr/>';
//            if ($i > 2) {
//                break;
//            }
        }
    }

    function filterCollection($collection, $text)
    {
        return $collection->filter(function ($item) use ($text) {
            return stristr($item['name'], $text) !== false;
        });
    }

    public function init($url)
    {
        $this->context = stream_context_create(array("http" => array("header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36")));
        $this->html = file_get_html($url, null, $this->context);
        $this->removeNode(['.NaviPage', '.des_bottom']);

        $this->html = $this->html->find('.list_content_bds', 0);

        $this->provinces = Province::get()->keyBy('id');
        $this->districts = District::get()->keyBy('id');
        $this->wards = Ward::get()->keyBy('id');
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
        $filename = str_replace('rongbay', 'rba', basename($path));

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

        $price = $content->find('ul', 0)->find('li', 0)->find('span', 0);

        if (strpos($price, 'Thoả thuận')) {
            return;
        }
        $price = str_replace(' Triệu/tháng', '', $price);

        echo(str_replace(',', '.', $price));
        $price = intval(floatval(strip_tags(str_replace(',', '.', $price))) * 1000000);
        echo $price;
        $acreage = '';
        if ($content->find('ul', 0) ) {
           return;
        }

        $acreage = trim(strip_tags(str_replace(['m', '<sup>2</sup>'], '', ($acreage)))) ?? 0;

        [$provinceId, $districtId, $wardId, $address] = $this->getLocation($content);

        $author = $this->getAuthor($html, [$provinceId, $districtId, $wardId, $address]);
        //TODO: save author
        $param = [
            'name' => $title,
            'code' => vn2code($title) . '-' . time(),
            'content' => $content . $description,
            'category_id' => 1,
            'avatar_id' => $avatar->id,
            'created_at' => Carbon::now(),
            'source' => $url,
            'price' => $price,
            'province_id' => $provinceId,
            'district_id' => $districtId,
            'ward_id' => $wardId,
            'address' => $address,
            'attr' => json_encode(['acreage' => $acreage]),
            'status' => 2,
            'author_id' => $author->id ?? 1,
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

    function getAuthor($html, $location)
    {
        $phone = trim($html->find('.show_mobile', 0)->plaintext);
        $name = $html->find('.name_store', 0)->plaintext;
        $user = User::where('phone', '=', $phone)->first();
        if ($user) {
            return $user;
        }
        [$provinceId, $districtId, $wardId, $address] = $location;

        $param = [
            'name' => $name,
            'phone' => $phone,
            'username' => vn2code($name) . time(),
            'password' => Hash::make('sayo.vn'),
            'departments_id' => 5,// crawl user
            'status' => STATUS_PENDING,
            'role' => ROLE_CUSTOMER,
//            'avatar_id' => 1,
            'created_at' => Carbon::now(),
            'province_id' => $provinceId,
            'district_id' => $districtId,
            'ward_id' => $wardId,
            'address' => $address,
        ];
        $user = User::create($param);
        return $user;
    }

    function getLocation($html)
    {
        $location = $html->find('.cl_666', 0)->plaintext;
        $location = str_replace(['- Xem bản đồ  ', 'Địa chỉ:   ', 'Q.', 'TP.'], '', $location);
        $locations = array_reverse(explode(', ', $location));

        if (!$locations) {
            return [];
        }
        return [
            $this->filterCollection($this->provinces, $locations[0])->first()->id ?? null,
            $this->filterCollection($this->districts, $locations[1] ?? 0)->first()->id ?? null,
            $this->filterCollection($this->wards, $locations[2] ?? 0)->first()->id ?? null,
            $locations[3] ?? $locations[2] ?? ''
        ];
    }

    function getTitle($html)
    {
        $tag = $html->find('h1', 0);
        return str_replace(['&#8220;', '&#8221;'], '"', $tag->plaintext ?? '');
    }
}
