<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use Intervention\Image\ImageManagerStatic as Image;

class CloneController extends Controller
{
	protected $category, $post;

	public $xaHoi, $giaoThong, $moiTruong, $thoiSu;

	protected $kinhTe, $taiChinh, $kinhDoanh;

	protected $doiSong, $sucKhoe, $dinhDuong;

	protected $giaoDuc, $duHoc, $thiCu;
 
	protected $khoaHoc, $trongNuoc, $thuongThuc, $chuyenLa, $tgdv;

	protected $theThao, $bongDa, $quanVot;

	public function __construct(Category $category, Post $post)
	{
		$this->category = $category;
		$this->post = $post;
	/*Chuyên mục xã hội*/
		$this->xaHoi = config('config.category.xa_hoi.xh'); // chuyên mục xã hội
			$this->giaoThong = config('config.category.xa_hoi.giao_thong'); // chuyên mục con
			$this->moiTruong = config('config.category.xa_hoi.mt_kh');
			$this->thoiSu = config('config.category.xa_hoi.thoi_su');
	/*Chuyên mục kinh tế*/
		$this->kinhTe = config('config.category.kinh_te.kt');
			$this->taiChinh = config('config.category.kinh_te.tai_chinh'); 
			$this->kinhDoanh = config('config.category.kinh_te.kinh_doanh');
	/*Chuyên mục đời sống*/
		$this->doiSong = config('config.category.doi_song.ds');
			$this->sucKhoe = config('config.category.doi_song.sk_yt');
			$this->dinhDuong = config('config.category.doi_song.dd_ld');
	// Chuyên mục giáo dục
		$this->giaoDuc = config('config.category.giao_duc.gd'); // giáo dục
			$this->duHoc = config('config.category.giao_duc.hb_dh'); // học bổng du học
			$this->thiCu = config('config.category.giao_duc.dt_tc'); // đào tạo thi cử
	// Chuyên mục khoa học
		$this->khoaHoc = config('config.category.khoa_hoc.kh'); // khoa học
			$this->trongNuoc = config('config.category.khoa_hoc.trong_nuoc'); // trong nước
			$this->thuongThuc = config('config.category.khoa_hoc.thuong_thuc'); // thường thức
			$this->chuyenLa = config('config.category.khoa_hoc.chuyen_la'); // chuyện lạ
			$this->tgdv = config('config.category.khoa_hoc.tgdv'); // thế giới động vật

	// Chuyên mục thể thao
		$this->theThao = config('config.category.the_thao.tt'); // thể thao
			$this->bongDa = config('config.category.the_thao.bong_da'); // bóng đá
			$this->quanVot = config('config.category.the_thao.quan_vot'); // quần vợt
	}

	public function spaceFirst($length, $string, $k)
	{
		for ($i = 0; $i < $length; $i++) {
			if ($string[$i] == $k) {
				return $i;
				break;
			}
		}
	}

	public function htmlTagClosePosition($length, $string, $k)
	{
		$dem = 0;
		for ($i = 0; $i < $length; $i++) {
			if ($string[$i] == $k) {
				$dem = $dem + 1;
				if ($dem == 2) {
					$dem = $i;
					break;
				}
			}
		}

		return $dem + 1;
	}

	public function test()
	{
		$this->cloneTestVnexpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
		$this->cloneTestVnexpress('https://vnexpress.net/bong-da', $this->bongDa, $this->theThao);
		$this->cloneTestVnexpress('https://vnexpress.net/the-thao/tennis', $this->quanVot, $this->theThao);
		$this->cloneTestVnexpress('https://vnexpress.net/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		$this->cloneTestVnexpress('https://vnexpress.net/giao-duc/du-hoc', $this->duHoc, $this->giaoDuc);
		$this->cloneTestVnexpress('https://vnexpress.net/suc-khoe', $this->sucKhoe, $this->doiSong);
	}

	public function cloneTestVnexpress($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$stt = 0;

		foreach ($html->find('.item-news') as $link) {
			if (!empty(($link->find('.thumb-art')))) {
				$linkFull = $link->find('.thumb-art a', 0)->href;
				$this->testVnexpress($linkFull, $subCategoryId, $categoryId);
			}
		}
	}
	
	public function testVnexpress($link, $subCategoryId, $categoryId)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'vnexpress.net';
		$array = array();
		$listRand = $listImgAndContent = $listImage = array();
		$contentInsert = '';
		try {		
			if ($check == 0) {
				$html = file_get_html($link);
				$title = trim($html->find('.sidebar-1 .title-detail', 0)->plaintext);
				$slug = str_slug($title);
				$summury = trim($html->find('.sidebar-1 .description')[0]->plaintext);
				$content = trim($html->find('.sidebar-1 .fck_detail')[0]->innertext);
				
				$nameImage = str_slug($title);
				$thumbnail = '';
				
				if (!empty($html->find('.header-content span.date')[0])) {
		    		$date = trim(explode(',', $html->find('.header-content span.date')[0]->plaintext)[1]);
			    	$date = str_replace('/', '-', $date). ' ' . date('H:i:s');
			    	$date = date('Y-m-d H:i:s', strtotime($date));
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists('upload/images/' . $folder)) {
				    mkdir('upload/images/' . $folder, 0777, true);
				}
				$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				if (!empty($html->find('.fck_detail .tplCaption'))) {
					foreach ($html->find('.fck_detail .tplCaption') as $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . 'bk';
						try {
							$noteImage = '<p class="note-image">' . $thumb->find('.Image')[0]->plaintext . '</p>';
							if (!empty($thumb->find("meta[itemprop='url']"))) {
								$img = $thumb->find("meta[itemprop='url']", 0)->content;
							} else {
								$img = $thumb->find('img', 0)->src;
							}
							
							// $put_img = file_get_contents($img);
							// file_put_contents(public_path("upload/test/" . $nameImage . '-' . $rand . '.jpg'), $put_img);
							$path = "upload/images/$folder/$nameImage-$rand.jpg";
							$imgTag = "<p class='image-detail'><img src=$path alt=$nameImage></p>";
						} catch (\Exception $e) {
							$imgTag = '';
							$noteImage = '';
						}
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, $rand, $content);
					}
				}

				if (!empty($html->find('.fck_detail .item_slide_show'))) {
					foreach ($html->find('.fck_detail .item_slide_show') as $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . 'bk1';
						try {
							$path = "upload/images/$folder/$nameImage-$rand.jpg";
							$imgTag = "<p class='image-detail'><img src=$path alt=$nameImage></p>";
							$img = $thumb->find('img', 0)->src;
							$noteImage = '<p class="note-image">' . $thumb->find('.Image')[0]->plaintext . '</p>';
						} catch (\Exception $e) {
							$imgTag = '';
							$noteImage = '';
						}
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, $rand, $content);
					}
				}
				//dd($content);
				$dom = new \DOMDocument;
				libxml_use_internal_errors(true);
				$dom->loadHTML('<meta http-equiv="Content-Type" content="charset=utf-8" />' . $content);
				$allElements = $dom->getElementsByTagName('*');
				$elementDistribution = array();
				$stt = 0;
				$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span');

				foreach($allElements as $element){
					$tagName = $element->tagName;

					if (!in_array($tagName, $htmlTagExeption)) {
						if (session()->has($tagName)) {
							$element = session($tagName) + 1;

							if (isset($dom->getElementsByTagName($tagName)->item($element)->textContent) && $dom->getElementsByTagName($tagName)->item($element)->textContent != '') {
								$p = html_entity_decode(trim($dom->getElementsByTagName($tagName)->item($element)->textContent), ENT_QUOTES, 'UTF-8');

								if (count($listRand) > 0) {
									if (isset($listRand[$p]) && $p == $listRand[$p]) {
										$contentInsert = $contentInsert . str_replace($listRand[$p], $listImgAndContent[$p], $p);
									} else {
										$contentInsert = $contentInsert . '<p>' . $p . '</p>';
									}
								} else {
									$contentInsert = $contentInsert . '<p>' . $p . '</p>';
								}
								
								session()->put($tagName, $element);
							}
						} else {
							if (isset($dom->getElementsByTagName($tagName)->item($stt)->textContent) && $dom->getElementsByTagName($tagName)->item($stt)->textContent != '') {
								// $p = trim($dom->getElementsByTagName($tagName)->item($stt)->textContent);
								$p = html_entity_decode(trim($dom->getElementsByTagName($tagName)->item($stt)->textContent), ENT_QUOTES, 'UTF-8');
								
								if (count($listRand) > 0) {
									if (isset($listRand[$p]) && $p == $listRand[$p]) {
										$contentInsert = $contentInsert . str_replace($listRand[$p], $listImgAndContent[$p], $p);
									} else {
										$contentInsert = $contentInsert . '<p>' . $p . '</p>';
									}
								} else {
									$contentInsert = $contentInsert . '<p>' . $p . '</p>';
								}
								session()->put($tagName, $stt);
							}
						}
					}
				}
				//echo $contentInsert;

				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					if (count($listImage) > 0) {
						foreach ($listImage as $key => $img) {
							$put_img = file_get_contents($img);
							file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
						}
					}
					$put_og_image = file_get_contents($og_image);
					file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

					$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
					$this->resizeImage($data, $nameImage . '.jpg');
				}
				echo "Thêm thành công <b>vnexpress</b><br>";
				session()->flush();
			} else {
				echo "Tin này đã thêm<b>vnExpress</b><br>";
			}
		} catch (\Exception $e) {
			echo "Lỗi hàm <b>testVnexpress</b><br>";
		}
	}

	public function createCategory()
	{
    	$data = [
			'xã hội',
			'thể thao',
			'đời sống',
			'thế giới',
			'văn hóa',
			'kinh tế',
			'giao dục',
			'khoa học',
			'công nghệ',
			'pháp luật',
			'giải trí',
			'nhà đất',
		];

		foreach ($data as $category) {
			$this->category->create(
				[
					'name' => $category,
					'slug' => str_slug($category),
				]
			);
		}
	}

	public function clone()
	{
		$this->vietNamPlus();
		$this->vnExpress();
		$this->cafeBiz();
		$this->vietNamNet();
	}

	public function vietNamNet()
	{
		$this->cloneVietNamNet('https://vietnamnet.vn/vn/thoi-su/', $this->thoiSu, $this->xaHoi);
	}

	public function cloneVietNamNet($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://vietnamnet.vn';

		foreach($html->find('.list-content .item') as $link) {
			$linkFull = $domain . $link->find('a')[0]->href;
			$thumbnail = $link->find('a')[0]->find('img')[0]->src;
			$this->getDataVietNamNet($linkFull, $subCategoryId, $categoryId, $thumbnail);
		}
	}

	public function getDataVietNamNet($urlOrigin, $subCate, $categoryId, $thumbnail)
	{
		$urlMd5 = md5($urlOrigin);
    	$check = $this->check($urlMd5, $categoryId);
    	$web = 'vietnamnet.vn';

    	try {
	    	if ($check == 0) {
		    	$data = array();
		    	$html = file_get_html($urlOrigin);
		    	if (!empty($html->find('.ArticleDate')[0])) {
		    		$date = html_entity_decode(trim($html->find('.ArticleDate')[0]->plaintext), ENT_QUOTES, 'UTF-8');
		    		$date = str_replace(' ', '', $date);
		    		$date = trim(str_replace('GMT+7', '', $date));
		    		$date = str_replace('/', '-', $date);
		    		$date = substr($date, 0, 10) . ' '. substr($date, 14);
		    		$date = date('Y-m-d H:i:s', strtotime($date));
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists('upload/images/' . $folder)) {
				    mkdir('upload/images/' . $folder, 0777, true);
				}
				$title = html_entity_decode(trim($html->find('.ArticleDetail h1.title')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$slug = str_slug($title);
				$summury = html_entity_decode(trim($html->find('.ArticleLead p')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = $html->find("meta[name='keywords']", 0)->content;
				$img = $html->find('.ArticleContent img');
			    $content = $html->find('.ArticleContent')[0]->innertext;
			    if (!empty($html->find('.ArticleContent .article-relate'))) {
			    	$content = str_replace($html->find('.ArticleContent .article-relate')[0]->innertext, '', $content);
			    }
			    if (!empty($html->find('.ArticleContent .inner-article'))) {
			    	$content = str_replace($html->find('.ArticleContent .inner-article')[0]->innertext, '', $content);
			    }
			    if (!empty($html->find('.ArticleContent .ArticleLead'))) {
			    	$content = str_replace($html->find('.ArticleContent .ArticleLead')[0]->innertext, '', $content);
			    }
			    
			    $content = html_entity_decode(trim($content), ENT_QUOTES, 'UTF-8');

			    if (count($img) > 0) {
		    		foreach ($img as $src) {
		    			if (empty($src->class) || ($src->class != 'logo-small' && $src->class != 'thumb2')) {
		    				$rand = rand();
			    			$nameImage = $slug . '-' . $rand . '.jpg';
				    		$image = file_get_contents($src->src);
				    		$nameImageArray[] = $nameImage;
				        	file_put_contents(public_path("upload/images/$folder/" . $nameImage), $image);
				    		$content = str_replace($src->src, "upload/images/$folder/" . $nameImage, $content);
		    			}
		    			
			    	}
		    	}
		    	
		    	$rand = rand();
			    $nameImage = $slug . '-' . $rand . '.jpg';

			    $result = $this->insertPost($title, $slug, $summury, $content, $nameImage, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $thumbnail);

			    
			    if(!empty($result)) {
			    	$put_og_image = file_get_contents($og_image);
					file_put_contents(public_path("upload/og_images/" . $nameImage), $put_og_image);

					$data = getimagesize(public_path("upload/og_images/" . $nameImage));
					$this->resizeImage($data, $nameImage);

			    } else {
			    	foreach ($nameImageArray as $image) {
			    		if (file_exists(public_path("upload/images/$folder/$image")))
						{
						    unlink("upload/images/$folder/$image");
						}
			    	}
			    }

			    echo 'Thêm thành công ' . $web . '<br>';
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<br>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi <b>getDataVietNamNet</b>" . $e->getMessage();
    	}
	}

	public function cafeBiz()
	{
		$this->cloneCafeBiz('https://cafebiz.vn/thoi-su.chn', $this->thoiSu, $this->xaHoi);
		$this->cloneCafeBiz('https://cafebiz.vn/cau-chuyen-kinh-doanh.chn', $this->kinhDoanh, $this->kinhTe);
	}

	public function cloneCafeBiz($link, $subCateId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://cafebiz.vn';

		foreach($html->find('.noibat1 ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[0]->href;
				$thumbnail = $link->find('a')[0]->find('img')[0]->src;
				$this->getDataCafeBiz($linkFull, $subCateId, $categoryId, $thumbnail);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneCafeBiz</b>' . $e->getMessage();
			}
		}

		foreach ($html->find('.listtimeline ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[1]->href;
				$thumbnail = $link->find('a')[1]->find('img')[0]->src;
				$this->getDataCafeBiz($linkFull, $subCateId, $categoryId, $thumbnail);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneCafeBiz</b>' . $e->getMessage();
			}
		}
	}

	public function getDataCafeBiz($urlOrigin, $subCate, $categoryId, $thumbnail)
	{
		$urlMd5 = md5($urlOrigin);
    	$check = $this->check($urlMd5, $categoryId);
    	$web = 'cafebiz.vn';

    	try {
    		if ($check == 0) {
		    	$data = array();
		    	$html = file_get_html($urlOrigin);
		    	if (!empty($html->find('.timeandcatdetail .time')[0])) {
		    		$date = trim($html->find('.timeandcatdetail .time')[0]->plaintext);
		    		$date = str_replace('/', '-', $date);
		    		$date = trim(str_replace('AM', '', $date));
		    		$date = date('Y-m-d H:i:s', strtotime($date));
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists('upload/images/' . $folder)) {
				    mkdir('upload/images/' . $folder, 0777, true);
				}
				$title = html_entity_decode(trim($html->find('.newscontent .content .title')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$slug = str_slug($title);
				$summury = html_entity_decode(trim($html->find('.khungdetail .newscontent .detail-single2 .content h2.sapo')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode(trim($html->find('.tags-item')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$img = $html->find('.detail-content img');
			    $content = $html->find('.detail-content')[0]->innertext;
			    $content = str_replace($html->find('.detail-content .source2')[0]->innertext, '', $content);
			    $content = str_replace($html->find('.detail-content script'), '', $content);
			    $content = html_entity_decode(trim($content), ENT_QUOTES, 'UTF-8');

			    if (count($img) > 0) {
		    		foreach ($img as $src) {
		    			$rand = rand();
		    			$nameImage = $slug . '-' . $rand . '.jpg';
			    		$image = file_get_contents($src->src);
			    		$nameImageArray[] = $nameImage;
			        	file_put_contents(public_path("upload/images/$folder/" . $nameImage), $image);
			    		$content = str_replace($src->src, "upload/images/$folder/" . $nameImage, $content);
			    	}
		    	}
		    	$rand = rand();
			    $nameImage = $slug . '-' . $rand . '.jpg';

			    $result = $this->insertPost($title, $slug, $summury, $content, $nameImage, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $thumbnail);

			    
			    if(!empty($result)) {
			    	$put_og_image = file_get_contents($og_image);
					file_put_contents(public_path("upload/og_images/" . $nameImage), $put_og_image);

					$put_thumbnail = file_get_contents($thumbnail);
					file_put_contents(public_path("upload/thumbnails/" . $nameImage), $put_thumbnail);
			    } else {
			    	foreach ($nameImageArray as $image) {
			    		if (file_exists(public_path("upload/images/$folder/$image")))
						{
						    unlink("upload/images/$folder/$image");
						}
			    	}
			    }

			    echo 'Thêm thành công ' . $web . '<br>';
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<br>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi" . $urlOrigin . '<br>';
    	}
		
	}

	public function vnExpress()
	{
		$this->cloneVnExpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
		$this->cloneVnExpress('https://vnexpress.net/suc-khoe', $this->sucKhoe, $this->doiSong);
		$this->cloneVnExpress('https://vnexpress.net/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		$this->cloneVnExpress('https://vnexpress.net/giao-duc/du-hoc', $this->duHoc, $this->giaoDuc);
		$this->cloneVnExpress('https://vnexpress.net/khoa-hoc/trong-nuoc', $this->trongNuoc, $this->khoaHoc);
		$this->cloneVnExpress('https://vnexpress.net/khoa-hoc/thuong-thuc', $this->thuongThuc, $this->khoaHoc);
		$this->cloneVnExpress('https://vnexpress.net/khoa-hoc/the-gioi-dong-vat', $this->tgdv, $this->khoaHoc);
		$this->cloneVnExpress('https://vnexpress.net/khoa-hoc/chuyen-la', $this->chuyenLa, $this->khoaHoc);
		$this->cloneVnExpress('https://vnexpress.net/suc-khoe/dinh-duong', $this->dinhDuong, $this->doiSong);
		$this->cloneVnExpress('https://vnexpress.net/bong-da', $this->bongDa, $this->theThao);
		$this->cloneVnExpress('https://vnexpress.net/the-thao/tennis', $this->quanVot, $this->theThao);

	}

	public function cloneVnExpress($link, $subCate, $categoryId)
	{
		$domain = 'https://vnexpress.net/';
		$html = file_get_html($link);
		$stt = 0;
		foreach ($html->find('.sidebar_1 .list_news .thumb_art') as $link) {
			if (!empty(($link->find('.thumb_5x3')))) {
				//if ($stt++ < 4) {
					$linkFull = $link->find('.thumb_5x3')[0]->href;
					$thumbnail = $link->find('.thumb_5x3 img')[0]->src;
					$this->getDataVnExpress($linkFull, $subCate, $categoryId, $thumbnail);
				//}
				
			}
		}
	}

	public function getDataVnExpress($urlOrigin, $subCate, $categoryId, $thumbnail)
	{
    	try {
    		$urlMd5 = md5($urlOrigin);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'vnexpress.net';

	    	if ($check == 0) {
		    	$data = array();
		    	$html = file_get_html($urlOrigin);
		    	if (!empty($html->find('.clearfix span.time')[0])) {
		    		$date = trim(explode(',', $html->find('.clearfix span.time')[0]->plaintext)[1]);
			    	$date = str_replace('/', '-', $date). ' ' . date('H:i:s');
			    	$date = date('Y-m-d H:i:s', strtotime($date));
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists(public_path('upload/images/' . $folder))) {
		    		mkdir(public_path('upload/images/' . $folder), 0777, true);
		    	}
		    	
		    	if (isset($html->find('.fck_detail')[0])) {
		    		$content = html_entity_decode(trim($html->find('.fck_detail')[0]->innertext), ENT_QUOTES,'UTF-8');
		    		$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
			    	$title = html_entity_decode(trim($html->find('.title_news_detail')[0]->plaintext), ENT_QUOTES, 'UTF-8');
			    	$slug = str_slug($title);
			    	
			    	$src = $html->find('.fck_detail img');
			    	
			    	$og_image = $html->find("meta[property='og:image']", 0)->content;
			    	$summury = html_entity_decode(trim($html->find('.description')[0]->plaintext), ENT_QUOTES, 'UTF-8');

			    	if (count($src) > 0) {
			    		foreach ($src as $src) {
			    			$rand = rand();
			    			$nameImage = str_slug($title) . '-' . $rand . '.jpg';
				    		$nameImageArray[] = $nameImage;
				    		$image = file_get_contents($src->src);
				        	file_put_contents(public_path("upload/images/$folder/" . $nameImage), $image);
				    		$content = str_replace($src->src, "upload/images/$folder/" . $nameImage, $content);
				    	}
			    	}

			    	$rand = rand();
			    	$nameImage = str_slug($title) . '-' . $rand . '.jpg';

			    	$result = $this->insertPost($title, $slug, $summury, $content, $nameImage, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $thumbnail);

			    	if (!empty($result)) {
			    		$put_img = file_get_contents($og_image);
						file_put_contents(public_path("upload/og_images/" . $nameImage), $put_img);

						$data = getimagesize(public_path("upload/og_images/" . $nameImage));
						$this->resizeImage($data, $nameImage);
			    	} else {
						foreach ($nameImageArray as $image) {
				    		if (file_exists(public_path("upload/images/$folder/$image")))
							{
							    unlink(public_path("upload/images/$folder/$image"));
							}
				    	}
			    	}

			    	echo 'Thêm thành công' . '<br>';
		    	}
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<br>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi hàm <b>getDataVnExpress()</b>" . $e->getMessage() . '<br>';
    	}

	}

	public function vietNamPlus()
	{
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/xahoi/giaothong.vnp', $this->giaoThong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/moitruong.vnp', $this->moiTruong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/kinhte/taichinh.vnp', $this->taiChinh, $this->kinhTe);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/doisong/suckhoe.vnp', $this->sucKhoe, $this->doiSong);
	}

	public function cloneVietNamPlus($link, $subCate, $categoryId)
	{
		// try {
			$domain = 'https://www.vietnamplus.vn';
			$html = file_get_html($link);
			foreach ($html->find('.l-content .story') as $link) {
				$linkFull = $domain . $link->find('a')[0]->href;
				$thumbnail = $link->find('.story__thumb img')[0]->src;
				$this->getDataVietNamPlus($linkFull, $subCate, $categoryId, $thumbnail);
			}
		// } catch (\Exception $e) {
		// 	echo "Lỗi hàm <b>cloneVietNamPlus</b>". $e->getMessage() .'<br>';
		// }

	}

    public function getDataVietNamPlus($urlOrigin, $subCate, $categoryId, $thumbnail)
    {
    	try {
    		$urlMd5 = md5($urlOrigin);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'vietnamplus.vn';

	    	if ($check == 0) {
		    	$data = array();
		    	$html = file_get_html($urlOrigin);
		    	$date = $html->find('.details__meta .source time')[0]->datetime;
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists('upload/images/' . $folder)) {
				    mkdir('upload/images/' . $folder, 0777, true);
				}
		    	
		    	if (isset($html->find('.details__content .content')[0])) {
		    		$content = html_entity_decode(trim($html->find('.details__content .content')[0]->innertext), ENT_QUOTES,'UTF-8');
		    		$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
			    	$title = html_entity_decode(trim($html->find('.details__headline')[0]->plaintext));
			    	$slug = str_slug($title);
			    	
			    	$src = $html->find('.details__content .content img');
			    	$rand = rand();
			    	$nameImage = str_slug($title) . '-' . $rand . '.jpg';
			    	$og_image = $html->find("meta[property='og:image:url']", 0)->content;
			    	$summury = html_entity_decode(trim($html->find("meta[name='description']", 0)->content));

			    	if (count($src) > 0) {
			    		foreach ($src as $src) {
			    			$rand = rand();
			    			$nameImage = str_slug($title) . '-' . $rand . '.jpg';
				    		$nameImageArray[] = $nameImage;
				    		$image = file_get_contents($src->src);
				        	file_put_contents(public_path("upload/images/$folder/" . $nameImage), $image);
				    		$content = str_replace($src->src, "upload/images/$folder/" . $nameImage, $content);
				    	}
			    	}


			    	$result = $this->insertPost($title, $slug, $summury, $content, $nameImage, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $thumbnail);

			    	if (!empty($result)) {
			    		$put_img = file_get_contents($og_image);
						file_put_contents(public_path("upload/og_images/" . $nameImage), $put_img);

						$put_thumbnail = file_get_contents($thumbnail);
						file_put_contents(public_path("upload/thumbnails/" . $nameImage), $put_thumbnail);
			    	} else {
			    		foreach ($nameImageArray as $image) {
				    		if (file_exists(public_path("upload/images/$folder/$image")))
							{
							    unlink("upload/images/$folder/$image");
							}
				    	}
			    	}

			    	echo 'Thêm thành công' . '<br>';
		    	}
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<br>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi hàm <b>getData()</b>" . $e->getMessage() . '<br>';
    	}
    	
    }

    public function insertPost($title, $slug, $summury, $content, $nameImage, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $thumbnail)
    {
    	try {
	    	return Post::create(
	    		[
	    			'title' => $title,
	    			'slug' => $slug,
	    			'summury' => $summury,
	    			'content' => $content,
	    			'image' => $nameImage,
	    			'keyword' => $keyword,
	    			'sub_category_id' => $subCate,
	    			'category_id' => $categoryId,
	    			'url_md5' => $urlMd5,
	    			'url_origin' => $urlOrigin,
	    			'web' => $web,
	    			'date' => $date,
	    		]
	    	);
	    	
    	} catch (\Exception $e) {
    		return NULL;
    	}
    }

    public function check($urlMd5, $categoryId)
    {
    	$result = $this->post->where('url_md5', $urlMd5)
    						 ->where('category_id', $categoryId)
    						 ->get();

    	return count($result);
    }

    public function resizeImage($data, $nameImage){
    	$width = $data[0];
        $height = $data[1];
        if ($width > 0) {
        	$heightResize = (360 * $height) / $width;
        	$imageResize = Image::make(public_path("upload/og_images/" . $nameImage));
			$imageResize->resize(360, $heightResize);
		
			return $imageResize->save('upload/thumbnails/' . $nameImage);
        }
    }
}
