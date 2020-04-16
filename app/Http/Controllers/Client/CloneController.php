<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Post;
use Intervention\Image\ImageManagerStatic as Image;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use Nesk\Puphpeteer\Resources\ElementHandle;
use Sunra\PhpSimple\HtmlDomParser;
use VIPSoft\Unzip\Unzip;

class CloneController extends Controller
{
	protected $category, $post;

	protected $xaHoi, $giaoThong, $moiTruong, $thoiSu, $theGioi;

	protected $kinhTe, $taiChinh, $kinhDoanh;

	protected $doiSong, $sucKhoe, $dinhDuong, $tinhYeu;

	protected $giaoDuc, $duHoc, $thiCu;
 
	protected $khoaHoc, $trongNuoc, $thuongThuc, $chuyenLa, $tgdv;

	protected $theThao, $bongDa, $quanVot;

	protected $quanSu, $tuLieu, $phanTich;

	protected $phapLuat, $anNinh, $hinhSu;

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
			$this->tinhYeu = config('config.category.doi_song.ty_hn');
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
	// Chuyên mục thê giới
		$this->theGioi = config('config.category.the_gioi.tg');
			$this->quanSu = config('config.category.the_gioi.quan_su');
			$this->tuLieu = config('config.category.the_gioi.tu_lieu');
			$this->phanTich = config('config.category.the_gioi.phan_tich');
	// Chuyên mục pháp luật
		$this->phapLuat = config('config.category.phap_luat.pl');
			$this->anNinh = config('config.category.phap_luat.an_ninh');
			$this->hinhSu = config('config.category.phap_luat.hinh_su');
	}

	public function test()
	{
		// $this->laoDong();
		// $this->testVnexpress();
		// $this->testCafeBiz();
		// $this->vietNamPlus();
		// $this->vietNamNet();
		//$this->congAnNhanDan();
		//$this->bao24h();
		//$this->tuoiTre();
		//$this->qdnd();
		//$this->nongNghiep();
		//$this->nguoiDuaTin();
		//$this->sucKhoeDoiSong();
		//$this->bongDa();
		$this->nhanDan();
	}

	public function nhanDan()
	{
		$this->cloneNhanDan('https://nhandan.com.vn/y-te', $this->sucKhoe, $this->doiSong);
	}

	public function sucKhoeDoiSong()
	{
		$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/y-hoc-co-truyen-c9/', $this->sucKhoe, $this->doiSong);
	}

	public function testVnexpress()
	{
		$this->cloneTestVnexpress('https://vnexpress.net/the-gioi/quan-su', $this->quanSu, $this->theGioi);
		$this->cloneTestVnexpress('https://vnexpress.net/the-gioi/phan-tich', $this->phanTich, $this->theGioi);
		$this->cloneTestVnexpress('https://vnexpress.net/the-gioi/tu-lieu', $this->tuLieu, $this->theGioi);
		$this->cloneTestVnexpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
		$this->cloneTestVnexpress('https://vnexpress.net/bong-da', $this->bongDa, $this->theThao);
		$this->cloneTestVnexpress('https://vnexpress.net/the-thao/tennis', $this->quanVot, $this->theThao);
		$this->cloneTestVnexpress('https://vnexpress.net/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		$this->cloneTestVnexpress('https://vnexpress.net/giao-duc/du-hoc', $this->duHoc, $this->giaoDuc);
		$this->cloneTestVnexpress('https://vnexpress.net/suc-khoe', $this->sucKhoe, $this->doiSong);
	}

	public function nguoiDuaTin()
	{
		$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		// $this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/an-ninh-hinh-su', $this->hinhSu, $this->phapLuat);
	}

	public function nongNghiep()
	{
		$this->cloneNongNghiep('https://nongnghiep.vn/an-ninh-nong-thon/', $this->anNinh, $this->phapLuat);
	}

	public function congAnNhanDan()
	{
		$this->cloneAnNinhNhanDan('http://cand.com.vn/ban-tin-113/', $this->hinhSu, $this->phapLuat);
		$this->cloneAnNinhNhanDan('http://cand.com.vn/y-te/', $this->sucKhoe, $this->doiSong);
	}

	public function qdnd()
	{
		$this->cloneQdnd('https://www.qdnd.vn/phap-luat/an-ninh-trat-tu', $this->anNinh, $this->phapLuat);
	}

	public function tuoiTre()
	{
		$this->cloneTuoiTre('https://tuoitre.vn/khoa-hoc/thuong-thuc.htm', $this->thuongThuc, $this->khoaHoc);
	}

	public function vietNamPlus()
	{
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/xahoi/giaothong.vnp', $this->giaoThong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/moitruong.vnp', $this->moiTruong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/kinhte/taichinh.vnp', $this->taiChinh, $this->kinhTe);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/doisong/suckhoe.vnp', $this->sucKhoe, $this->doiSong);
	}

	public function vietNamNet()
	{
		$this->cloneVietNamNet('https://vietnamnet.vn/vn/kinh-doanh/tai-chinh/', $this->taiChinh, $this->kinhTe);
	}

	public function testCafeBiz()
	{
		$this->cloneTestCafeBiz('https://cafebiz.vn/thoi-su.chn', $this->thoiSu, $this->xaHoi);
		$this->cloneTestCafeBiz('https://cafebiz.vn/cau-chuyen-kinh-doanh.chn', $this->kinhDoanh, $this->kinhTe);
	}

	public function laoDong()
	{
		$this->cloneLaoDong('https://laodong.vn/bong-da-quoc-te/', $this->bongDa, $this->theThao);
	}

	public function bao24h()
	{
		$this->cloneBao24h('https://www.24h.com.vn/bong-da-c48.html', $this->bongDa, $this->theThao);
	}

	public function cloneNguoiDuaTin($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://www.nguoiduatin.vn';

		foreach ($html->find('.more-articles .col .box-news') as $link) {
			try {
				$linkFull = $domain . $link->find('a', 0)->href;
				$thumbnail = $link->find('img', 0)->src;
				$this->getDataNguoiDuaTin($linkFull, $subCategoryId, $categoryId, $thumbnail);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneNguoiDuaTin</b> ' . $e->getMessage() . '<hr>';
			}
		}
	}

	public function bongDa()
	{
		$this->cloneBongDa('http://www.bongda.com.vn/tin-moi-nhat/', $this->bongDa, $this->theThao);
	}

	public function getPage ($url) {
		$useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
		$timeout= 120;
		$dir            = dirname(__FILE__);
		$cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_ENCODING, "" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_AUTOREFERER, true );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
		$content = curl_exec($ch);
		if(curl_errno($ch))
		{
		    echo 'error:' . curl_error($ch);
		}
		else
		{
		    return $content;        
		}
		
		curl_close($ch);
	}

	public function cloneNongNghiep($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.list-news-home .news-home-item') as $link) {
			try {
				$linkFull = $link->find('a', 0)->href;
				$thumbnail = $link->find('img', 0)->attr['data-src'];
				$date = trim($link->find('.news-push-date', 0)->plaintext);
				$date = str_replace('-', '', $date);
				$date = str_replace('/', '-', $date);
				$date = date('Y-m-d H:i:s', strtotime($date));
				$this->getDataNongNghiep($linkFull, $subCategoryId, $categoryId, $thumbnail, $date);	
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneNongNghiep</b>' . $e->getMessage() . '<hr>';
			}
		}
	}

	public function cloneQdnd($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.ctrangc3 .pcontent3') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$this->getDataQdnd($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function cloneAnNinhNhanDan($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.listnews .article') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$this->getDataAnNinhNhanDan($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function cloneBongDa($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		
		foreach ($html->find('.list_top_news li') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;
			$this->getDataBongDa($linkFull, $subCategoryId, $categoryId, $thumbnail);
			break;
		}
	}

	public function cloneTuoiTre($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://tuoitre.vn';

		foreach ($html->find('.list-news-content .news-item') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;
			$this->getDataTuoiTre($linkFull, $subCategoryId, $categoryId, $thumbnail);
		}
	}

	public function cloneVietNamNet($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://vietnamnet.vn';

		foreach($html->find('.list-content .item') as $link) {
			$linkFull = $domain . $link->find('a')[0]->href;
			$this->getDataVietNamNet($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function cloneVietNamPlus($link, $subCategoryId, $categoryId)
	{
		try {
			$domain = 'https://www.vietnamplus.vn';
			$html = file_get_html($link);
			foreach ($html->find('.l-content .story') as $link) {
				$linkFull = $domain . $link->find('a')[0]->href;
				$thumbnail = $link->find('.story__thumb img')[0]->src;
				$this->getDataVietNamPlus($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
		} catch (\Exception $e) {
			echo "Lỗi hàm <b>cloneVietNamPlus</b>". $e->getMessage() .'<hr>';
		}
	}

	public function cloneLaoDong($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.aside-container .list-main-content li') as $link) {
			try {
				$linkFull = $link->find('a', 0)->href;
				$this->getDataLaoDong($linkFull, $subCategoryId, $categoryId);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneLaoDong</b><hr>' . $e->getMessage() . '<hr>';
			}
		}
	}

	public function cloneTestCafeBiz($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://cafebiz.vn';

		foreach($html->find('.noibat1 ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[0]->href;
				$thumbnail = $link->find('a')[0]->find('img')[0]->src;
				$this->getDataTestCafeBiz($linkFull, $subCategoryId, $categoryId, $thumbnail);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneTestCafeBiz</b>' . $e->getMessage() . '<hr>';
			}
		}

		foreach ($html->find('.listtimeline ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[1]->href;
				$thumbnail = $link->find('a')[1]->find('img')[0]->src;
				$this->getDataTestCafeBiz($linkFull, $subCategoryId, $categoryId, $thumbnail);
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneTestCafeBiz</b>' . $e->getMessage() . '<hr>';
			}
		}
	}

	public function cloneTestVnexpress($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$stt = 0;

		foreach ($html->find('.item-news') as $link) {
			if (!empty(($link->find('.thumb-art')))) {
				$linkFull = $link->find('.thumb-art a', 0)->href;
				$this->getDataTestVnexpress($linkFull, $subCategoryId, $categoryId);
				break;
			}
		}
	}

	public function cloneBao24h($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.postx .bxDoiSbIt') as $link)
		{
			try {
				$linkFull = $link->find('a', 0)->href;

				if (!empty($link->find('.updTm'))) {
					$time = $link->find('.updTm', 0)->plaintext;
					$time = str_replace('|', '', $time);
					$time = str_replace('/', '-', $time);
					$time = date('Y-m-d H:i:s', strtotime($time));
				} else {
					$time = date('Y-m-d H:i:s');
				}
				
				$this->getDataBao24h($linkFull, $subCategoryId, $categoryId, $time);
				//break;
				
			} catch (\Exception $e) {
				echo "Lỗi hàm <b>cloneBao24h</b>" . $e->getMessage() . '<hr>';
			}
		}		
	}

	public function cloneSucKhoeDoiSong($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.list_news_home li') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;
			$this->getDataSucKhoeDoiSong($linkFull, $subCategoryId, $categoryId, $thumbnail);
		}
	}

	public function cloneNhanDan($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://nhandan.com.vn';

		foreach ($html->find('.hotnew-container .media') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $domain . $link->find('img', 0)->src;
			$this->getDataNhanDan($linkFull, $subCategoryId, $categoryId, $thumbnail, $domain);
		}
	}

	public function getDataNhanDan($link, $subCategoryId, $categoryId, $thumbnail, $domain)
	{
		try {
			$thumbnail = '';
			$web = 'nhandan.com.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.item-container .date-created'))) {
					$date = $html->find('.item-container .date-created', 0)->plaintext;
					$date1 = trim(explode(',', $date)[1]);
					$date2 = trim(explode(',', $date)[2]);
					$date = $date1 . ' ' . $date2;
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = html_entity_decode($html->find("meta[name='title']", 0)->content);
	    		$summury = trim(html_entity_decode($html->find('.sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$content = trim(html_entity_decode($html->find('.item-container', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $domain . $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);

				if (!empty($html->find('.handy'))) {
					$content = str_replace($html->find('.handy', 0)->outertext, '', $content);
				}
				if (!empty($html->find('.social-box'))) {
					$content = str_replace($html->find('.social-box', 0)->outertext, '', $content);
				}
				$content = str_replace($summury, '', $content);

				if (!empty($html->find('.item-container .content-box'))) {
	    			foreach ($html->find('.item-container .content-box') as $thumb)
	    			{
	    				try {
	    					$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->outertext;

		    				if ($thumb->find('.image-caption')) {
								$noteImage = '<p class="note-image">' . $thumb->find('.image-caption', 0)->plaintext . '</p>';
							} else {
								$noteImage = '';
							}

							if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $domain . $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}

	    		$htmlTagExeption = array('article', 'figure', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
				$contentInsert = str_replace(trim($title), '', $contentInsert);
	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);
				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}

				echo "Thêm thành công <b>nhandan.com.vn</b><hr>";
			} else {
				echo 'Tin này đã thêm <b>nhandan.com.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataNhanDan</b><hr>' . $e->getMessage();
		}
	}

	public function getDataBongDa($link, $subCategoryId, $categoryId, $thumbnail)
	{
		// $Path = public_path('upload/images/2020-04/chinh.zip');
  //       \Zipper::make($Path)->extractTo(public_path('upload/images/2020-04/test.jpg'));

		try {
			$web = 'bongda.com.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.info_detail .time_comment'))) {
					$date = trim($html->find('.info_detail .time_comment', 0)->plaintext);
					$date1 = explode(' ', $date)[0];
					$date2 = explode(' ', $date)[3];
					$date = $date1 . ' ' . $date2;
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.time_detail_news', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.sapo_detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(str_replace('BongDa.com.vn', '', $summury));
	    		$content = trim(html_entity_decode($html->find('.news_details', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
				
				if (!empty($html->find('.news_details .expNoEdit'))) {
	    			foreach ($html->find('.news_details .expNoEdit') as $thumb)
	    			{
	    				try {
	    					$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->innertext;

		    				if ($thumb->find('.expEdit')) {
								$noteImage = '<p class="note-image">' . trim(html_entity_decode($html->find('.expEdit', 0)->plaintext, ENT_QUOTES, 'UTF-8')) . '</p>';
							} else {
								$noteImage = '';
							}

							if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}

	    		if (!empty($html->find('.new_relation_top'))) {
	    			foreach ($html->find('.new_relation_top') as $relate) {
	    				$content = str_replace($relate->outertext, '', $content);
	    			}
	    		}

	    		$htmlTagExeption = array('article', 'figure', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);
				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}

				echo "Thêm thành công <b>bongda.com.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataBongDa</b>' . $e->getMessage() . '<hr>';
		}
	}

	public function getDataSucKhoeDoiSong($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'suckhoedoisong.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.post-time'))) {
					$date = $html->find('.post-time', 0)->plaintext;
					$date = trim(str_replace('GMT+7', '', $date));
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.title-detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.sapo_detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = str_replace('Suckhoedoisong.vn - ', '', $summury);
	    		$content = trim(html_entity_decode($html->find('#content_detail_news', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);

				if (!empty($html->find('#content_detail_news p img'))) {
	    			foreach ($html->find('#content_detail_news p img') as $thumb)
	    			{
	    				try {
	    					$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->outertext;

		    				if (!empty($html->find('#content_detail_news .chuthichanhSKDS'))) {
								$noteImage = '<p class="note-image">' . $html->find('#content_detail_news .chuthichanhSKDS', 0)->plaintext . '</p>';
								$content = str_replace($html->find('#content_detail_news .chuthichanhSKDS', 0)->outertext, '', $content);
							} else {
								$noteImage = '';
							}
							$img = $thumb->src;
							$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}
	    		$htmlTagExeption = array('article', 'figure', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}
				
				echo "Thêm thành công <b>nguoiduatin.vn</b><hr>";
			} else {
				echo 'Tin này đã thêm <b>suckhoedoisong.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataSucKhoeDoiSong</b>' . $e->getMessage() . '<hr>';
		}
	}

	public function getDataNguoiDuaTin($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'nguoiduatin.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);
				if (!empty($html->find('.contents'))) {
					if (!empty($html->find('.contents .datetime .fs2'))) {
						$date = $html->find('.contents .datetime .fs2', 0)->plaintext;
						$date = trim(explode(',', $date)[1]);
						$date = str_replace('|', '', $date);
						$date = str_replace('/', '-', $date);
						$date = date('Y-m-d H:i:s', strtotime($date));
					} else {
						$date = date('Y-m-d H:i:s');
					}
					$folder = date('Y-m', strtotime($date));
		    		$this->createFolder($folder);
		    		$title = trim(html_entity_decode($html->find('.contents .title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
		    		$summury = trim(html_entity_decode($html->find('.contents .sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
		    		$content = trim(html_entity_decode($html->find('.contents .article-content', 0)->innertext, ENT_QUOTES, 'UTF-8'));
		    		$slug = $nameImage = str_slug($title);
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = '';


					if (!empty($html->find('ul.tags'))) {
						foreach ($html->find('.tags li') as $tag)
						{
							$keyword = $keyword . $tag->plaintext . ',';
						}
					}

		    		if (!empty($html->find('.article-content .tplCaption'))) {
		    			foreach ($html->find('.article-content .tplCaption') as $thumb)
		    			{
		    				try {
		    					$rand = rand();
			    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
			    				$thumbItem = $thumb->innertext;

			    				if (!empty($thumb->find('figcaption.Image'))) {
									$noteImage = '<p class="note-image">' . $thumb->find('figcaption.Image', 0)->plaintext . '</p>';
								} else {
									$noteImage = '';
								}
								if (!empty($thumb->find('img'))) {
									$img = $thumb->find('img', 0)->src;
									$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
								} else {
									$img = '';
									$imgTag = '';
								}
			    			} catch (\Exception $e) {
			    				$imgTag = '';
								$noteImage = '';
			    			}
			    			$listRand[$rand] = $rand;
							$listImgAndContent[$rand] = $imgTag . $noteImage;
							$listImage[$rand] = $img;
							$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
		    			}
		    		}
		    		$content = str_replace($summury, '', $content);
		    		$htmlTagExeption = array('article', 'figure', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
					$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
					session()->flush();
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
		    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

					if (!empty($result)) {
						$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
					}
					
					echo "Thêm thành công <b>nguoiduatin.vn</b><hr>";
				}
			} else {
					echo "Tin này đã thêm <b>nguoiduatin.vn</b><hr>";
				}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataNguoiDuaTin</b> " . $e->getMessage() . '<hr>';
		}
	}

	public function getDataNongNghiep($link, $subCategoryId, $categoryId, $thumbnail, $date)
	{
		try {
			$web = 'nongnghiep.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.detail-content .main-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.detail-content .main-intro', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$content = trim(html_entity_decode($html->find('.detail-content .content', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);

	    		if (!empty($html->find('.content .adv'))) {
	    			$content = str_replace($html->find('.content .adv', 0)->outertext, '', $content);
	    		}

	    		if (!empty($html->find('.content .expNoEdit'))) {
	    			foreach ($html->find('.content .expNoEdit') as $thumb)
	    			{
	    				try {
	    					$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->innertext;

		    				if (!empty($thumb->find('.expEdit'))) {
								$noteImage = '<p class="note-image">' . $thumb->find('.expEdit', 0)->plaintext . '</p>';
							} else {
								$noteImage = '';
							}
							if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->attr['data-src'];
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}
	    		$htmlTagExeption = array('figure', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}
				
				echo "Thêm thành công <b>nongnghiep.vn</b><hr>";
			} else {
				echo "Tin này đã thêm <b>nongnghiep.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataNongNghiep</b>" . $e->getMessage() . '<hr>';
		}
	}

	public function getDataQdnd($link, $subCategoryId, $categoryId)
	{
		try {
			$thumbnail = '';
			$web = 'qdnd.vn';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.post-head .post-subinfo'))) {
					$date = trim($html->find('.post-head .post-subinfo', 0)->plaintext);
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));

				} else {
					$date = date('Y-m-d H:i:s');
				}
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.post-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.post-summary', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$content = trim(html_entity_decode($html->find('.post-content', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = '';
			
				if (!empty($html->find('.post-tag a[itemprop="keywords"]'))) {
					foreach ($html->find('.post-tag a[itemprop="keywords"]') as $tag) {
						$keyword = $keyword . $tag->plaintext . ',';
					}
				}

				if (!empty($html->find('.post-content .imgEditor'))) {
	    			foreach ($html->find('.post-content .imgEditor') as $thumb) {
		    			try {
	    					$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->innertext;

		    				if (!empty($thumb->find('.alt_imgEditor'))) {
								$noteImage = '<p class="note-image">' . $thumb->find('.alt_imgEditor', 0)->plaintext . '</p>';
							} else {
								$noteImage = '';
							}
							if (!empty($thumb->find('.imgtelerik'))) {
								$img = $thumb->find('.imgtelerik', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}
	    		$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}
				
				echo "Thêm thành công <b>qdnd.vn</b><hr>";
			} else {
				echo "Tin này đã thêm <b>qdnd.vn</b><hr>";
			}

		} catch (\Exception $e) {
			echo "Lỗi <b>getDataQdnd</b><hr>" . $e->getMessage();
		}
	}

	public function getDataTuoiTre($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$urlMd5 = md5($link);
	    	$web = 'tuoitre.vn';
	    	$listRand = $listImgAndContent = $listImage = array();
	    	$check = $this->check($urlMd5, $categoryId);

	    	if ($check == 0) {
	    		$html = file_get_html($link);

	    		if (!empty($html->find('.date-time', 0)->plaintext)) {
	    			$date = trim($html->find('.date-time', 0)->plaintext);
	    			$date = str_replace('/', '-', $date);
	    			$date = str_replace('GMT+7', '', $date);
	    			$date = date('Y-m-d H:i:s', strtotime($date));
	    		} else {
	    			$date = date('Y-m-d H:i:s');
	    		}
	    		$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.content-detail .article-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.main-content-body .sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$content = trim(html_entity_decode($html->find('.main-content-body .content', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
	    		$keyword = $html->find("meta[name='keywords']", 0)->content;
	    		$keyword = str_replace(';', ',', $keyword);
				$og_image = $html->find("meta[property='og:image']", 0)->content;

				if (!empty($html->find('div[type="RelatedOneNews"]'))) {
					foreach ($html->find('div[type="RelatedOneNews"]') as $relateNews) {
						$content = str_replace($relateNews->outertext, '', $content);
					}
				}

				if (!empty($html->find('.content .VCSortableInPreviewMode'))) {
	    			foreach ($html->find('.content .VCSortableInPreviewMode') as $thumb) {
		    			try {
		    				if ($thumb->type == 'Photo') {
		    					$rand = rand();
			    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
			    				$thumbItem = $thumb->innertext;

			    				if (!empty($thumb->find('.PhotoCMS_Caption'))) {
									$noteImage = '<p class="note-image">' . $thumb->find('.PhotoCMS_Caption', 0)->plaintext . '</p>';
								} else {
									$noteImage = '';
								}
								if (!empty($thumb->find('img'))) {
									$img = $thumb->find('img', 0)->src;
									$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
								} else {
									$img = '';
									$imgTag = '';
								}
		    				}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}

				$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();

	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}
				
				echo "Thêm thành công <b>tuoitre.vn</b><hr>";
	    	} else {
	    		echo "Tin này đã thêm <b>tuoitre.vn</b><hr>";
	    	}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>getDataTuoiTre</b>' . $e->getMessage() . '<hr>';
		}
	}

	public function getDataAnNinhNhanDan($link, $subCategoryId, $categoryId)
	{
		try {
			$thumbnail = '';
			$urlMd5 = md5($link);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'cand.com.vn';
	    	$listRand = $listImgAndContent = $listImage = array();
	    	$check = $this->check($urlMd5, $categoryId);

	    	if ($check == 0) {
	    		$html = file_get_html($link);

	    		if (!empty($html->find('.box-widget .timepost', 0)->plaintext)) {
	    			$date = trim($html->find('.box-widget .timepost', 0)->plaintext);
	    			$date = str_replace('/', '-', $date);
	    			$date = date('Y-m-d H:i:s', strtotime($date));
	    		} else {
	    			$date = date('Y-m-d H:i:s');
	    		}
	    		$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.box-widget .titledetail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$summury = trim(html_entity_decode($html->find('.box-widget .desnews', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$content = trim(html_entity_decode($html->find('.box-widget .post-content', 0)->innertext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = '';

				if (!empty($html->find('.box-widget .tags'))) {
					foreach ($html->find('.box-widget .tags li') as $key => $tag) {
						if ($key > 0) {
							$keyword = $keyword . $tag->plaintext . ',';
						}
					}
				}

	    		if (!empty($html->find('.box-widget .post-content .contref'))) {
	    			foreach ($html->find('.box-widget .post-content .contref') as $ul) {
	    				$content = str_replace($ul->outertext, '', $content);
	    			}
	    		}
	    		
	    		if (!empty($html->find('.box-widget .post-content .contentimg'))) {
	    			foreach ($html->find('.box-widget .post-content .contentimg') as $thumb) {
		    			try {
		    				$rand = rand();
		    				$path = "upload/images/$folder/$nameImage-$rand.jpg";
		    				$thumbItem = $thumb->innertext;

		    				if (!empty($thumb->find('.note'))) {
								$noteImage = '<p class="note-image">' . $thumb->find('.note', 0)->plaintext . '</p>';
							} else {
								$noteImage = '';
							}
							if (!empty($thumb->find('.img img'))) {
								$img = $thumb->find('.img img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
		    			} catch (\Exception $e) {
		    				$imgTag = '';
							$noteImage = '';
		    			}
		    			$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
	    			}
	    		}

	    		$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'ul', 'script', 'ins');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();

	    		$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$this->uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder);
				}

				echo "Thêm thành công <b>cand.com.vn</b><hr>";
	    	} else {
	    		echo "Tin đã thêm <b>cand.com.vn</b><hr>";
	    	}

		} catch (\Exception $e) {
			echo "Lỗi <b>getDataAnNinhNhanDan</b>" . $e->getMessage() . '<hr>';
		}
	}

	public function getDataBao24h($link, $subCategoryId, $categoryId, $date)
	{
		try {
			$web = '24h.com.vn';
			$urlMd5 = md5($link);
			$listRand = $listImgAndContent = $listImage = array();
			$check = $this->check($urlMd5, $categoryId);
			$thumbnail = '';

			if ($check == 0) {
				$html = file_get_html($link);
				$folder = date('Y-m', strtotime($date));
				$this->createFolder($folder);
				$title = trim(html_entity_decode($html->find('#left #article_body #article_title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$summury = trim(html_entity_decode($html->find('#left #article_body #article_sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$content = $html->find('#left .nwsHt', 0)->innertext;
				$slug = $nameImage = str_slug($title);
				$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
				$og_image = $html->find("meta[property='og:image']", 0)->content;

				if (!empty($html->find('#left .bv-lq'))) {
					$content = str_replace($html->find('#left .bv-lq', 0)->outertext, '', $content);
				}
				if (!empty($html->find('#left .linkOrigin'))) {
					$content = str_replace($html->find('#left .linkOrigin', 0)->outertext, '', $content);
				}
				if (!empty($html->find('#left .sbNws'))) {
					$content = str_replace($html->find('#left .sbNws', 0)->outertext, '', $content);
				}
				if (!empty($html->find('#left #article_title'))) {
					$content = str_replace($html->find('#left #article_title', 0)->outertext, '', $content);
				}
				if (!empty($html->find('#left .updTm'))) {
					$content = str_replace($html->find('#left .updTm', 0)->outertext, '', $content);
				}
				if (!empty($html->find('#left #article_sapo'))) {
					$content = str_replace($html->find('#left #article_sapo', 0)->outertext, '', $content);
				}
				if (!empty($html->find('div[style="margin: 0 auto;background-color:#FFFFFF;width:687px;"]'))) {
					foreach ($html->find('div[style="margin: 0 auto;background-color:#FFFFFF;width:687px;"]') as $div) {
						$content = str_replace($div->outertext, '', $content);
					}
				}
				if (!empty($html->find('div[style="margin: 0 auto;background-color:#FFFFFF;width:686px;"]'))) {
					foreach ($html->find('div[style="margin: 0 auto;background-color:#FFFFFF;width:686px;"]') as $div) {
						$content = str_replace($div->outertext, '', $content);
					}
				}

				if (!empty($html->find('#left .news-image'))) {
					foreach ($html->find('#left .news-image') as $thumb) {
						$thumbItem = $thumb->outertext;
						$rand = rand() . '0';
						try {
							$path = "upload/images/$folder/$nameImage-$rand.jpg";
							$img = $thumb->src;
							list($width, $height) = getimagesize($img);

							if ($width > 1) {
								$img = $thumb->src;
							} else {
								$img = $thumb->attr['data-original'];
							}
							$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
						} catch (\Exception $e) {
							$imgTag = '';
							$img = '';
						}
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, $rand, $content);
					}
				}
				//dd($listImage);
				//echo $content;
				if (!empty($html->find('#left .img_chu_thich_0407'))) {
					foreach ($html->find('#left .img_chu_thich_0407') as $note) {
						$noteImage = $note->plaintext;
						$rand = rand() . '1';
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = '<p class="note-image">' . $noteImage . '</p>';
						$content = str_replace($noteImage, $rand, $content);
					}
				}
				//dd($content);

				$htmlTagExeption = array('iframe', 'html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody', 'script');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$arrContextOptions=array(
					    "ssl"=>array(
					        "verify_peer"=>false,
					        "verify_peer_name"=>false,
					    ),
					);  
					if (count($listImage) > 0) {
						foreach ($listImage as $key => $img) {
							if ($img != '') {
								$put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
								file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
							}
							
						}
					}
					$put_og_image = file_get_contents($og_image, false, stream_context_create($arrContextOptions));
					file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

					$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
					$this->resizeImage($data, $nameImage . '.jpg');
				}

				echo "Thêm thành công <b>24h.com.vn</b><hr>";
			} else {
				echo "Tin này đã thêm <b>24h.com.vn</b><hr>";
			}	
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataBao24h</b>" . $e->getMessage() . '<hr>';
		}
	}

	public function getDataVietNamPlus($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$urlMd5 = md5($link);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'vietnamplus.vn';
	    	$listRand = $listImgAndContent = $listImage = array();

			if ($check == 0) {
		    	$html = file_get_html($link);

		    	if (!empty($html->find('.details__meta .source time'))) {
		    		$date = $html->find('.details__meta .source time', 0)->datetime;
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	
		    	$folder = date('Y-m', strtotime($date));
		    	$this->createFolder($folder);
		    	
		    	if (!empty($html->find('.details__content .content'))) {
		    		$content = html_entity_decode(trim($html->find('.details__content .content')[0]->innertext), ENT_QUOTES,'UTF-8');
		    		$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
			    	$title = html_entity_decode(trim($html->find('.details__headline')[0]->plaintext));
			    	$nameImage = $slug = str_slug($title);
			    	$og_image = $html->find("meta[property='og:image:url']", 0)->content;
			    	$summury = html_entity_decode(trim($html->find("meta[name='description']", 0)->content));

			    	if (!empty($html->find('.details__content .article-photo'))) {
						foreach ($html->find('.details__content .article-photo') as $thumb) {
							$thumbItem = $thumb->innertext;
							$rand = rand() . '0';
							try {
								$path = "upload/images/$folder/$nameImage-$rand.jpg";

								if (!empty($thumb->find('span'))) {
									$noteImage = '<p class="note-image">' . $thumb->find('span', 0)->plaintext . '</p>';
								} else {
									$noteImage = '';
								}

								if (!empty($thumb->find('img'))) {
									$img = $thumb->find('img', 0)->src;
									$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage' title='$title'></p>";
								} else {
									$img = '';
									$imgTag = '';
								}
							} catch (\Exception $e) {
								$imgTag = '';
								$noteImage = '';
							}
							$listRand[$rand] = $rand;
							$listImgAndContent[$rand] = $imgTag . $noteImage;
							$listImage[$rand] = $img;
							$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
						}
					}

					if (!empty($html->find('.details__content .vnpplayer'))) {
						foreach ($html->find('.details__content .vnpplayer') as $video) {
							$rand = rand() . '1';
							$videoItem = $video->innertext;
							$listRand[$rand] = $rand;
							$listImgAndContent[$rand] = '<p class="detail-video">' . $videoItem . '</p>';
							$content = str_replace($videoItem, '<p>' . $rand . '</p>', $content);
						}
					}

					$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody');
					$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
					session()->flush();
					$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

					if (!empty($result)) {
						$arrContextOptions=array(
						    "ssl"=>array(
						        "verify_peer"=>false,
						        "verify_peer_name"=>false,
						    ),
						);  
						if (count($listImage) > 0) {
							foreach ($listImage as $key => $img) {
								if ($img != '') {
									$put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
									file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
								}
								
							}
						}
						$put_og_image = file_get_contents($og_image, false, stream_context_create($arrContextOptions));
						file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

						$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
						$this->resizeImage($data, $nameImage . '.jpg');
					}

					echo "Thêm thành công <b>vietNamPlus.vn</b><hr>";
			    }
			} else {
				echo "Tin này đã thêm <b>Vietnamplus.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataVietNamPlus</b>' . $e->getMessage() . '<hr>';
		}
	}
	
	public function getDataTestVnexpress($link, $subCategoryId, $categoryId)
	{
		$link = 'https://vnexpress.net/benh-nhan-262-tung-tiep-xuc-hon-100-nguoi-4083773.html';
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
		    	$this->createFolder($folder);
				$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;

				if (!empty($html->find('.fck_detail .tplCaption'))) {
					foreach ($html->find('.fck_detail .tplCaption') as $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . '0';
						try {
							$path = "upload/images/$folder/$nameImage-$rand.jpg";

							if (!empty($thumb->find('.Image'))) {
								$noteImage = '<p class="note-image">' . $thumb->find('.Image')[0]->plaintext . '</p>';
							} else {
								$noteImage = '';
							}

							if (!empty($thumb->find("meta[itemprop='url']"))) {
								$img = $thumb->find("meta[itemprop='url']", 0)->content;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage'></p>";
							} else if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
						} catch (\Exception $e) {
							$imgTag = '';
							$noteImage = '';
						}
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						if (strlen($thumbItem) > 2) {
							$content = str_replace($thumbItem, $rand, $content);
						}
					}
				}

				if (!empty($html->find('.fck_detail .item_slide_show'))) {
					foreach ($html->find('.fck_detail .item_slide_show') as $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . '1';
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

				//dd($listImage);

				$dom = new \DOMDocument;
				libxml_use_internal_errors(true);
				$dom->loadHTML('<meta http-equiv="Content-Type" content="charset=utf-8" />' . $content);
				$allElements = $dom->getElementsByTagName('*');
				$elementDistribution = array();
				$stt = 0;
				$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody');

				foreach($allElements as $element){
					$tagName = $element->tagName;

					if (!in_array($tagName, $htmlTagExeption)) {
						if (session()->has($tagName)) {
							$element = session($tagName) + 1;
						} else {
							$element = $stt;
						}
						if (isset($dom->getElementsByTagName($tagName)->item($element)->textContent) || $dom->getElementsByTagName($tagName)->item($element)->textContent != '') {
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
					}
				}
				session()->flush();

				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					if (count($listImage) > 0) {
						foreach ($listImage as $key => $img) {
							if ($img != '') {
								$put_img = file_get_contents($img);
								file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
							}
							
						}
					}
					$put_og_image = file_get_contents($og_image);
					file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

					$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
					$this->resizeImage($data, $nameImage . '.jpg');
				}
				echo "Thêm thành công <b>vnexpress</b><hr>";
				
			} else {
				echo "Tin này đã thêm<b>vnExpress</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi hàm <b>testVnexpress</b><hr>" . $e->getMessage();
		}
	}

	public function getDataLaoDong($link, $subCategoryId, $categoryId)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'laodong.vn';
		$array = array();
		$listRand = $listImgAndContent = $listImage = array();
		$contentInsert = '';
		$html = file_get_html($link);
		$thumbnail = '';

		try {
			if ($check == 0) {
				if (!empty($html->find('.article-meta .time time'))) {
					$date = $html->find('.article-meta .time time', 0)->plaintext;
					$date = str_replace('/', '-', $date);
					$date = str_replace('|', '', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}

				$folder = date('Y-m', strtotime($date));
				$this->createFolder($folder);
				$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$summury = html_entity_decode(trim($html->find('.left-sidebar .abs', 0)->plaintext), ENT_QUOTES, 'UTF-8');
				$content = trim($html->find('.left-sidebar .article-content', 0)->innertext);
				$title = trim(html_entity_decode($html->find('.title h1', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$nameImage = $slug = str_slug($title);

				if (!empty($html->find('.left-sidebar .article-content .for-reading-mode'))) {
					$content = str_replace($html->find('.left-sidebar .article-content .for-reading-mode', 0)->innertext, '', $content);
				}

				if (!empty($html->find('.left-sidebar .insert-center-image'))) {
					foreach ($html->find('.left-sidebar .insert-center-image') as $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . '0';
						try {
							$path = "upload/images/$folder/$nameImage-$rand.jpg";

							if (!empty($thumb->find('.image-caption'))) {
								$noteImage = '<p class="note-image">' . $thumb->find('.image-caption', 0)->plaintext . '</p>';
							} else {
								$noteImage = '';
							}
							if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
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

				$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody');
				$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
				session()->flush();
				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					$arrContextOptions=array(
					    "ssl"=>array(
					        "verify_peer"=>false,
					        "verify_peer_name"=>false,
					    ),
					);  
					if (count($listImage) > 0) {
						foreach ($listImage as $key => $img) {
							if ($img != '') {
								$put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
								file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
							}
							
						}
					}
					$put_og_image = file_get_contents($og_image, false, stream_context_create($arrContextOptions));
					file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

					$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
					$this->resizeImage($data, $nameImage . '.jpg');
				}

				echo "Thêm thành công <b>Laodong.vn</b><hr>";

			} else {
				echo "Tin này đã thêm <b>Laodong.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataLaoDong()</b>" . $e->getMessage() . '<hr>';
		}
	}

	public function getDataVietNamNet($link, $subCategoryId, $categoryId)
	{
		$thumbnail = '';
		$urlMd5 = md5($link);
    	$check = $this->check($urlMd5, $categoryId);
    	$web = 'vietnamnet.vn';
    	$listRand = $listImgAndContent = $listImage = array();
		$html = file_get_html($link);

		if ($check == 0) {
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
	    	$this->createFolder($folder);
			$title = html_entity_decode(trim($html->find('.ArticleDetail h1.title')[0]->plaintext), ENT_QUOTES, 'UTF-8');
			$nameImage = $slug = str_slug($title);
			$summury = html_entity_decode(trim($html->find('.ArticleLead p')[0]->plaintext), ENT_QUOTES, 'UTF-8');
			$og_image = $html->find("meta[property='og:image']", 0)->content;
			$keyword = $html->find("meta[name='keywords']", 0)->content;
			$content = $html->find('.ArticleContent')[0]->innertext;

			if (!empty($html->find('.ArticleContent .ArticleLead'))) {
				$content = str_replace($html->find('.ArticleLead', 0)->outertext, '', $content);
			}

			if (!empty($html->find('.ArticleContent .article-relate'))) {
				$content = str_replace($html->find('.ArticleContent .article-relate', 0)->outertext, '', $content);
			}

			if (!empty($html->find('.ArticleContent .inner-article'))) {
				$content = str_replace($html->find('.ArticleContent .inner-article', 0)->outertext, '', $content);
			}

			if (!empty($html->find('.ArticleContent .box-taitro'))) {
				$content = str_replace($html->find('.ArticleContent .box-taitro', 0)->outertext, '', $content);
			}

			if (!empty($html->find('.ArticleContent .FmsArticleBoxStyle'))) {
				foreach ($html->find('.ArticleContent .ImageBox') as $thumb) {
					$thumbItem = $thumb->outertext;
					$rand = rand() . '0';
					try {
						$path = "upload/images/$folder/$nameImage-$rand.jpg";

						if (!empty($thumb->find('.FmsArticleBoxStyle-Content'))) {
							$noteImage = '<p class="note-image">' . html_entity_decode($thumb->find('.FmsArticleBoxStyle-Content', 0)->plaintext, ENT_QUOTES, 'UTF-8') . '</p>';
						} else {
							$noteImage = '';
						}

						if (!empty($thumb->find('img'))) {
							$img = $thumb->find('img', 0)->src;
							$imgTag = "<p class='image-detail'>
											<img src=$path alt='$nameImage' title='$title'>
										</p>";
						} else {
							$img = '';
							$imgTag = '';
						}
					} catch (\Exception $e) {
						$imgTag = '';
						$noteImage = '';
					}
					$listRand[$rand] = $rand;
					$listImgAndContent[$rand] = $imgTag . $noteImage;
					$listImage[$rand] = $img;
					$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
				}
			}

			if (!empty('.ArticleContent .infographic')) {
				foreach ($html->find('.ArticleContent .infographic') as $thumb) {
					$thumbItem = $thumb->outertext;
					$rand = rand() . '1';
					try {
						$path = "upload/images/$folder/$nameImage-$rand.jpg";
						$imgTag = "<p class='image-detail'><img src=$path alt=$nameImage></p>";
						$img = $thumb->src;
					} catch (\Exception $e) {
						$imgTag = '';
						$img = '';
					}
					$listRand[$rand] = $rand;
					$listImgAndContent[$rand] = $imgTag;
					$listImage[$rand] = $img;
					$content = str_replace($thumbItem, $rand, $content);
				}
			}

			$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'font', 'b', 'table', 'tr', 'td', 'tbody');
			$contentInsert = $this->getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage);
			session()->flush();
			$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

			if (!empty($result)) {
				$arrContextOptions=array(
				    "ssl"=>array(
				        "verify_peer"=>false,
				        "verify_peer_name"=>false,
				    ),
				);  
				if (count($listImage) > 0) {
					foreach ($listImage as $key => $img) {
						if ($img != '') {
							$put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
							file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
						}
						
					}
				}
				$put_og_image = file_get_contents($og_image, false, stream_context_create($arrContextOptions));
				file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

				$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
				$this->resizeImage($data, $nameImage . '.jpg');
			}
			echo "Thêm thành công <b>Vietnamnet</b><hr>";
		} else {
			echo "Tin đã thêm <b>Vietnamnet</b><hr>";
		}    	
	}

	public function getContentInsert($content, $htmlTagExeption, $listRand, $listImgAndContent, $listImage)
	{
		$contentInsert = '';
		$dom = new \DOMDocument;
		libxml_use_internal_errors(true);
		$dom->loadHTML('<meta http-equiv="Content-Type" content="charset=utf-8" />' . $content);
		$allElements = $dom->getElementsByTagName('*');
		$elementDistribution = array();
		$stt = 0;

		foreach($allElements as $element){
			$tagName = $element->tagName;

			if (!in_array($tagName, $htmlTagExeption)) {
				if (session()->has($tagName)) {
					$element = session($tagName) + 1;
				} else {
					$element = $stt;
				}
				if (isset($dom->getElementsByTagName($tagName)->item($element)->textContent) || $dom->getElementsByTagName($tagName)->item($element)->textContent != '') {
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
			}
		}

		return html_entity_decode($contentInsert, ENT_QUOTES, 'UTF-8');
	}

	public function getDataTestCafeBiz($link, $subCategoryId, $categoryId, $thumbnail)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'cafebiz.vn';
		$array = array();
		$listRand = $listImgAndContent = $listImage = array();
		$contentInsert = '';
		$html = file_get_html($link);

		try {
			if ($check == 0) {
				if (!empty($html->find('.timeandcatdetail .time')[0])) {
		    		$date = trim($html->find('.timeandcatdetail .time')[0]->plaintext);
		    		$date = str_replace('/', '-', $date);
		    		$date = trim(str_replace('AM', '', $date));
		    		$date = date('Y-m-d H:i:s', strtotime($date));
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
				$title = html_entity_decode(trim($html->find('.newscontent .content .title')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$slug = $nameImage = str_slug($title);
				$summury = html_entity_decode(trim($html->find('.khungdetail .newscontent .detail-single2 .content h2.sapo')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$og_image = $html->find("meta[property='og:image']", 0)->content;
				$keyword = html_entity_decode(trim($html->find('.tags-item')[0]->plaintext), ENT_QUOTES, 'UTF-8');
			    $content = $html->find('.detail-content')[0]->innertext;
		    	$folder = date('Y-m', strtotime($date));

		    	if (!file_exists('upload/images/' . $folder)) {
				    mkdir('upload/images/' . $folder, 0777, true);
				}
				// dd($html->find('.detail-content .VCSortableInPreviewMode img', 0)->src);
				// dd(1);
				if (!empty($html->find('.detail-content .VCSortableInPreviewMode'))) {
					foreach ($html->find('.detail-content .VCSortableInPreviewMode') as $key => $thumb) {
						$thumbItem = $thumb->innertext;
						$rand = rand() . '0';
						try {
							$path = "upload/images/$folder/$nameImage-$rand.jpg";
							if (!empty($thumb->find('p'))) {
								if (!empty($thumb->find('img'))) {
									$noteImage = '<p class="note-image">' . $thumb->find('p', 0)->plaintext . '</p>';
								} else {
									$noteImage = '<p>' . $thumb->find('p', 0)->plaintext . '</p>';
								}
							} else {
								$noteImage = '';
							}

							if (!empty($thumb->find('img'))) {
								$img = $thumb->find('img', 0)->src;
								$imgTag = "<p class='image-detail'><img src=$path alt='$nameImage'></p>";
							} else {
								$img = '';
								$imgTag = '';
							}
							
							
						} catch (\Exception $e) {
							$imgTag = '';
							$noteImage = '';
						}
						$listRand[$rand] = $rand;
						$listImgAndContent[$rand] = $imgTag . $noteImage;
						$listImage[$rand] = $img;
						$content = str_replace($thumbItem, '<p>' . $rand . '</p>', $content);
					}
				}
				//dd($listImage);

				if (!empty($html->find('.p-source'))) {
					$p_source = $html->find('.p-source', 0)->innertext;
					$content = str_replace($p_source, '', $content);
				}
				//dd($content);
				$dom = new \DOMDocument;
				libxml_use_internal_errors(true); // đối với những thẻ html lạ
				$dom->loadHTML('<meta http-equiv="Content-Type" content="charset=utf-8" />' . $content);
				$allElements = $dom->getElementsByTagName('*');
				$elementDistribution = array();
				$stt = 0;
				$htmlTagExeption = array('html', 'head', 'meta', 'body', 'strong', 'em', 'a', 'span', 'i', 'div', 'script', 'b', 'font', 'table', 'tr');
				
				foreach($allElements as $elementItem) {
					$tagName = $elementItem->tagName;

					if (!in_array($tagName, $htmlTagExeption)) {
						if (session()->has($tagName)) {
							$element = session($tagName) + 1;
						} else {
							$element = $stt;
						}

						if (isset($dom->getElementsByTagName($tagName)->item($element)->textContent) || $dom->getElementsByTagName($tagName)->item($element)->textContent != '') {
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
					}
				}
				session()->flush();

				$result = $this->insertPost($title, $slug, $summury, $contentInsert, $nameImage . '.jpg', $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $thumbnail);

				if (!empty($result)) {
					if (count($listImage) > 0) {
						foreach ($listImage as $key => $img) {
							if ($img != '') {
								$put_img = file_get_contents($img);
								file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
							}
						}
					}
					$put_og_image = file_get_contents($og_image);
					file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

					$put_thumbnail = file_get_contents($thumbnail);
					file_put_contents(public_path("upload/thumbnails/" . $nameImage . '.jpg'), $put_thumbnail);
				}
				echo "Thêm thành công <b>cafeBiz</b><hr>";
				
			} else {
				echo "Tin này đã thêm<b>cafeBiz</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>testCafeBiz</b>' . $e->getMessage() . '<hr>';
		}
	}

	public function clone()
	{
		$this->vietNamPlus();
		$this->vnExpress();
		$this->cafeBiz();
		$this->vietNamNet();
	}

	public function vietNamNet1()
	{
		$this->cloneVietNamNet1('https://vietnamnet.vn/vn/thoi-su/', $this->thoiSu, $this->xaHoi);
	}

	public function cloneVietNamNet1($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://vietnamnet.vn';

		foreach($html->find('.list-content .item') as $link) {
			$linkFull = $domain . $link->find('a')[0]->href;
			$thumbnail = $link->find('a')[0]->find('img')[0]->src;
			$this->getDataVietNamNet1($linkFull, $subCategoryId, $categoryId, $thumbnail);
		}
	}

	public function getDataVietNamNet1($urlOrigin, $subCate, $categoryId, $thumbnail)
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

			    echo 'Thêm thành công ' . $web . '<hr>';
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<hr>';
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

			    echo 'Thêm thành công ' . $web . '<hr>';
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<hr>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi" . $urlOrigin . '<hr>';
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

			    	echo 'Thêm thành công' . '<hr>';
		    	}
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<hr>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi hàm <b>getDataVnExpress()</b>" . $e->getMessage() . '<hr>';
    	}

	}

	public function vietNamPlus1()
	{
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/xahoi/giaothong.vnp', $this->giaoThong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/moitruong.vnp', $this->moiTruong, $this->xaHoi);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/kinhte/taichinh.vnp', $this->taiChinh, $this->kinhTe);
		$this->cloneVietNamPlus('https://www.vietnamplus.vn/doisong/suckhoe.vnp', $this->sucKhoe, $this->doiSong);
	}

	public function cloneVietNamPlus1($link, $subCate, $categoryId)
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

    public function getDataVietNamPlus1($urlOrigin, $subCate, $categoryId, $thumbnail)
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

			    	echo 'Thêm thành công' . '<hr>';
		    	}
	    	} else {
	    		echo "Tin này đã được thêm - " . $web . '<hr>';
	    	}
    	} catch (\Exception $e) {
    		echo "Lỗi hàm <b>getData()</b>" . $e->getMessage() . '<hr>';
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
    		return $e->getMessage();
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

    public function createFolder($folder)
    {
    	if (!file_exists('upload/images/' . $folder)) {
		    mkdir('upload/images/' . $folder, 0777, true);
		}
    }

    public function uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder)
	{
		$arrContextOptions=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);  

		if (count($listImage) > 0) {
			foreach ($listImage as $key => $img) {
				if ($img != '') {
					$img = str_replace(' ', '%20', $img);
					$put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
					file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
				}
			}
		}
		$put_og_image = file_get_contents(str_replace(' ', '%20', $og_image), false, stream_context_create($arrContextOptions));
		file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

		if ($thumbnail == '') {
			$data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
		
			return $this->resizeImage($data, $nameImage . '.jpg');
		} else {
			$thumbnail = str_replace(' ', '%20', $thumbnail);
			$put_thumbnail = file_get_contents($thumbnail, false, stream_context_create($arrContextOptions));
			
			return file_put_contents(public_path("upload/thumbnails/" . $nameImage . '.jpg'), $put_thumbnail);
		}
		
	}
}
