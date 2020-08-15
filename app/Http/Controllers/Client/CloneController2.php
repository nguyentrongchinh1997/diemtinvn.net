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
use App\Model\Value;
use App\Model\Gold;
use App\Model\Oil;
use App\Model\NewsDay;

class CloneController2 extends Controller
{
	protected $category, $post;

	protected $xaHoi, $giaoThong, $moiTruong, $thoiSu;

	protected $theThao, $bongDa, $quanVot;

	protected $doiSong, $sucKhoe, $dinhDuong, $tinhYeu;

	protected $theGioi, $quanSu, $tuLieu, $phanTich;

	protected $vanHoa, $ngheThuat, $amThuc, $duLich;

	protected $kinhTe, $taiChinh, $kinhDoanh, $laoDong, $chungKhoan;

	protected $giaoDuc, $duHoc, $thiCu;
 
	protected $khoaHoc, $trongNuoc, $thuongThuc, $chuyenLa, $tgdv;

	protected $congNghe, $cntt, $sanPham;

	protected $phapLuat, $anNinh, $hinhSu;

	protected $giaiTri, $dienAnh, $thoiTrang, $amNhac;

	protected $nhaDat, $quanLy, $khongGian;

	protected $server;

	public function __construct(Category $category, Post $post)
	{
		$this->server = 'https://diembao24h.s3-ap-southeast-1.amazonaws.com/';
		$this->category = $category;
		$this->post = $post;
	/*Chuyên mục xã hội*/
		$this->xaHoi = 1;
			$this->thoiSu = 1;
			$this->giaoThong = 2;
			$this->moiTruong = 3;
			
	// Chuyên mục thể thao
		$this->theThao = 2;
			$this->bongDa = 5;
			$this->quanVot = 6;
			$this->monKhac = 37;
	/*Chuyên mục đời sống*/
		$this->doiSong = 3;
			$this->dinhDuong = 7;
			$this->tinhYeu = 8;
			$this->sucKhoe = 9;
	// Chuyên mục thê giới
		$this->theGioi = 4;
			$this->quanSu = 28;
			$this->tuLieu = 29;
			$this->phanTich = 30;
	// chuyên mục văn hóa
		$this->vanHoa = 5;
			$this->ngheThuat = 23;
			$this->amThuc = 24;
			$this->duLich = 25;
	/*Chuyên mục kinh tế*/
		$this->kinhTe = 6;
			$this->laoDong = 19;
			$this->taiChinh = 20;
			$this->chungKhoan = 21;
			$this->kinhDoanh = 22;	
	// Chuyên mục giáo dục
		$this->giaoDuc = 7;
			$this->duHoc = 17;
			$this->thiCu = 18;
	// Chuyên mục khoa học
		$this->khoaHoc = 8;
			$this->trongNuoc = 36;
			$this->thuongThuc = 33;
			$this->chuyenLa = 32;
			$this->tgdv = 31;
	// chuyên mục công nghệ
		$this->congNghe = 9;
			$this->cntt = 15;
			$this->sanPham = 16;
	// Chuyên mục pháp luật
		$this->phapLuat = 10;
			$this->anNinh = 13;
			$this->hinhSu = 14;
	// chuyên mục giải trí
		$this->giaiTri = 11;
			$this->amNhac = 10;
			$this->thoiTrang = 11;
			$this->dienAnh = 12;
			$this->sao = 38;
	// chuyên mục nhà đất
		$this->nhaDat = 12;
			$this->quanLy = 26;
			$this->khongGian = 27;
	}

	public function clone()
	{
		$value = Value::findOrFail(1);
		$a = $value->value;
	
		switch ($a) {
		    case 0 : $this->xaHoi(); break;
		    case 1 : $this->theThao(); break;
		    case 2 : $this->doiSong(); break;
		    case 3 : $this->theGioi(); break;
		    case 4 : $this->vanHoa(); break;
		    case 5 : $this->kinhTe(); break;
		    case 6 : $this->giaoDuc(); break;
		    case 7 : $this->khoaHoc(); break;
		    case 8 : $this->congNghe(); break;
		    case 9 : $this->phapLuat(); break;
		    case 10 : $this->giaiTri(); break;
		    case 11: $this->nhaDat(); break;
		    case 12: $this->priceGoldToday(); $this->oil(); break;
		}
		if ($a == 12) {
			$value->value = 0;
			$value->save();
		} else {
			$value->value = $a + 1;
			$value->save();
		}
	}

	public function priceGoldToday()
	{
		$html = file_get_html('http://sjc.com.vn/giavang/textContent.php');
		$stt = 0;
		Gold::getQuery()->delete();
		foreach ($html->find('.bx1 table tr') as $tr) {
			$dem = $stt++;
			if ($dem > 0 && $dem < 10) {
				$this->getDataPriceGoldToday($tr);
			}
		}
	}

	public function getDataPriceGoldToday($tr)
	{
		foreach ($tr->find('td') as $td)
		{
			$list[] = $td->plaintext;
		}

		return Gold::create([
			'type' => $list[0],
			'buy' => $list[1],
			'sell' => $list[2],
		]);
	}

	public function oil()
    {
    	try {
    		$html = file_get_html('https://www.petrolimex.com.vn/');
	    	$date = date('Y-m-d');
	    	$check = Oil::where('date', $date)->first();

	    	if (isset($check)) {
	    		echo "Dữ liệu ngày này đã được thêm";
	    	} else {
	    		foreach ($html->find('#vie_p6_PortletContent .list-table>div') as $div) {
		    		foreach ($div->find('div') as $key => $row) {
		    			$name = $div->find('div')[0]->plaintext;
		    			$price1 = $div->find('div')[1]->plaintext;
		    			$price2 = $div->find('div')[2]->plaintext;
		    		}
		    		Oil::create([
			    		'oil_name' => $name,
			    		'price_1' => $price1,
			    		'price_2' => $price2,
			    		'date' => $date
			    	]);
		    	}
	    	}
	    	echo "Thêm thành công dầu<br>";
    	} catch (\Exception $e) {
    		echo "Thêm thất bại dầu<br>";
    	}
    }

	public function xaHoi()
	{
		// thời sự
		    $this->cloneTiin('http://tiin.vn/24.html', $this->thoiSu, $this->xaHoi);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/thoi-su/', $this->thoiSu, $this->xaHoi);
			$this->cloneVnexpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
		//	$this->cloneBaoTinTuc('https://baotintuc.vn/thoi-su-472ct0.htm', $this->thoiSu, $this->xaHoi);
		//	$this->cloneLaoDong('https://laodong.vn/thoi-su/', $this->thoiSu, $this->xaHoi);
			//$this->cloneVietNamNet('https://vietnamnet.vn/vn/thoi-su/', $this->thoiSu, $this->xaHoi);
			// $this->cloneVnexpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
			 $this->cloneBaoTinTuc('https://baotintuc.vn/thoi-su-472ct0.htm', $this->thoiSu, $this->xaHoi);
			// $this->cloneLaoDong('https://laodong.vn/thoi-su/', $this->thoiSu, $this->xaHoi);
	}

	public function theThao()
	{
		// bóng đá
		//	$this->cloneVnexpress('https://vnexpress.net/bong-da', $this->bongDa, $this->theThao);
			$this->cloneLaoDong('https://laodong.vn/bong-da-quoc-te/', $this->bongDa, $this->theThao);
			$this->cloneLaoDong('https://laodong.vn/bong-da/', $this->bongDa, $this->theThao);
		// quần vợt
			$this->cloneDanTri('https://dantri.com.vn/the-thao/tennis.htm', $this->quanVot, $this->theThao);
		//	$this->cloneVietNamPlus('https://www.vietnamplus.vn/thethao/quanvot.vnp', $this->quanVot, $this->theThao);
		// các môn khác
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/the-thao/cac-mon-khac/', $this->monKhac, $this->theThao);
			$this->cloneVnexpress('https://vnexpress.net/the-thao/cac-mon-khac', $this->monKhac, $this->theThao);
	}

	public function doiSong()
	{
		// dinh dưỡng làm đẹp
			$this->cloneVnexpress('https://vnexpress.net/suc-khoe/dinh-duong', $this->dinhDuong, $this->doiSong);
		//	$this->cloneNguoiLaoDong('https://nld.com.vn/suc-khoe/thuoc-dinh-duong.htm', $this->dinhDuong, $this->doiSong);
			$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/dinh-duong-phong-chong-ung-thu-c100/', $this->dinhDuong, $this->doiSong);
			$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/tham-my-c62/', $this->dinhDuong, $this->doiSong);
		// tình yêu hôn nhân
		    $this->cloneTiin('http://tiin.vn/yeu.html', $this->tinhYeu, $this->doiSong);
			$this->cloneDoiSongPhapLuat('https://www.doisongphapluat.com/doi-song/gia-dinh-tinh-yeu/', $this->tinhYeu, $this->doiSong);
			$this->cloneVnexpress('https://vnexpress.net/tag/tinh-yeu-hon-nhan-gia-dinh-99724', $this->tinhYeu, $this->doiSong);
			$this->cloneDanTri('https://dantri.com.vn/tinh-yeu-gioi-tinh.htm', $this->tinhYeu, $this->doiSong);
		// sức khỏe y tế
			$this->cloneVietNamPlus('https://www.vietnamplus.vn/xahoi/yte.vnp', $this->sucKhoe, $this->doiSong);
			$this->cloneVietNamPlus('https://www.vietnamplus.vn/doisong/suckhoe.vnp', $this->sucKhoe, $this->doiSong);
			$this->cloneNguoiLaoDong('https://nld.com.vn/suc-khoe.htm', $this->sucKhoe, $this->doiSong);
			$this->cloneDoiSongPhapLuat('https://www.doisongphapluat.com/doi-song/suc-khoe-lam-dep/', $this->sucKhoe, $this->doiSong);
	}

	public function theGioi()
	{
		// quân sự
			$this->cloneQdnd('https://www.qdnd.vn/quan-su-the-gioi', $this->quanSu, $this->theGioi);
		//	$this->cloneCongAnNhanDan('http://cand.com.vn/vu-khi-chien-tranh/', $this->quanSu, $this->theGioi);
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/the-gioi/quan-su/', $this->quanSu, $this->theGioi);
		// tư liệu
			$this->cloneBaoTinTuc('https://baotintuc.vn/ho-so-tu-lieu-133ct0.htm', $this->tuLieu, $this->theGioi);
		//	$this->cloneVnexpress('https://vnexpress.net/the-gioi/tu-lieu', $this->tuLieu, $this->theGioi);
		// phân tích
		//	$this->cloneVnexpress('https://vnexpress.net/the-gioi/phan-tich', $this->phanTich, $this->theGioi);

	}

	public function vanHoa()
	{
		// nghệ thuật
			$this->cloneNguoiLaoDong('https://nld.com.vn/nghe-thuat.html', $this->ngheThuat, $this->vanHoa);
		// ẩm thực
		//	$this->cloneNongNghiep('https://nongnghiep.vn/am-thuc-truyen-thong/', $this->amThuc, $this->vanHoa);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/doi-song/am-thuc/', $this->amThuc, $this->vanHoa);
		// du lịch
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/doi-song/du-lich/', $this->duLich, $this->vanHoa);
		//	$this->cloneVnexpress('https://vnexpress.net/du-lich', $this->duLich, $this->vanHoa);
			$this->cloneVietNamPlus('https://www.vietnamplus.vn/dulich.vnp', $this->duLich, $this->vanHoa);
		//	$this->cloneBaoQuocTe('https://baoquocte.vn/van-hoa/du-lich', $this->duLich, $this->vanHoa);
	}

	public function kinhTe()
	{
		//lao động việc làm
		//	$this->cloneTuoiTre('https://tuoitre.vn/viec-lam.html', $this->laoDong, $this->kinhTe);
			$this->cloneNguoiLaoDong('https://nld.com.vn/cong-doan/viec-lam.htm', $this->laoDong, $this->kinhTe);
		//tài chính
		//	$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/tai-chinh-ngan-hang', $this->taiChinh, $this->kinhTe);
			$this->cloneDatViet('https://baodatviet.vn/kinh-te/tai-chinh/', $this->taiChinh, $this->kinhTe);
		//	$this->cloneVietNamPlus('https://www.vietnamplus.vn/kinhte/taichinh.vnp', $this->taiChinh, $this->kinhTe);
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/kinh-doanh/tai-chinh/', $this->taiChinh, $this->kinhTe);
		//chứng khoán
			$this->cloneVietNamPlus('https://www.vietnamplus.vn/kinhte/chungkhoan.vnp', $this->chungKhoan, $this->kinhTe);
		//	$this->cloneVnexpress('https://vnexpress.net/kinh-doanh/chung-khoan', $this->chungKhoan, $this->kinhTe);
		//kinh doanh
			$this->cloneCafeBiz('https://cafebiz.vn/cau-chuyen-kinh-doanh.chn', $this->kinhDoanh, $this->kinhTe);
		//	$this->cloneVnexpress('https://vnexpress.net/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		//	$this->cloneDoiSongPhapLuat('https://www.doisongphapluat.com/kinh-doanh/', $this->kinhDoanh, $this->kinhTe);
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/kinh-doanh/', $this->kinhDoanh, $this->kinhTe);
	}

	public function giaoDuc()
	{
		// học bổng du học
		//	$this->cloneTuoiTre('https://tuoitre.vn/giao-duc/du-hoc.htm', $this->duHoc, $this->giaoDuc);
		//	$this->cloneVnexpress('https://vnexpress.net/giao-duc/du-hoc', $this->duHoc, $this->giaoDuc);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/giao-duc/du-hoc/', $this->duHoc, $this->giaoDuc);

		// đào tạo thi cử
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/giao-duc/tuyen-sinh/', $this->thiCu, $this->giaoDuc);
		//	$this->cloneVnexpress('https://vnexpress.net/giao-duc/tuyen-sinh', $this->thiCu, $this->giaoDuc);
			$this->cloneTuoiTre('https://tuoitre.vn/giao-duc/tuyen-sinh.htm', $this->thiCu, $this->giaoDuc);
			$this->cloneTiin('http://tiin.vn/hoc.html', $this->thiCu, $this->giaoDuc);
			
	}

	public function khoaHoc()
	{
		// trong nước
			$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/trong-nuoc', $this->trongNuoc, $this->khoaHoc);
		// thường thức
		//	$this->cloneTuoiTre('https://tuoitre.vn/khoa-hoc/thuong-thuc.htm', $this->thuongThuc, $this->khoaHoc);
			$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/thuong-thuc', $this->thuongThuc, $this->khoaHoc);
		// chuyện lạ
			$this->cloneDatViet('https://baodatviet.vn/the-gioi/chuyen-la/', $this->chuyenLa, $this->khoaHoc);
			$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/chuyen-la', $this->chuyenLa, $this->khoaHoc);
		// thê giới đọng vật
			$this->cloneDatViet('https://baodatviet.vn/khoa-hoc/the-gioi-dong-vat/', $this->tgdv, $this->khoaHoc);
			$this->cloneDanTri('https://dantri.com.vn/the-gioi-dong-vat.tag', $this->tgdv, $this->khoaHoc);
			$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/the-gioi-dong-vat', $this->tgdv, $this->khoaHoc);
	}

	public function congNghe()
	{
		// công nghệ thông tin
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/cong-nghe/vien-thong/', $this->cntt, $this->congNghe);
			// $this->cloneVietNamNet('https://vietnamnet.vn/vn/cong-nghe/tin-cong-nghe/', $this->cntt, $this->congNghe);
			// $this->cloneBaoTinTuc('https://baotintuc.vn/dien-tu-vien-thong-492ct131.htm', $this->cntt, $this->congNghe);
		// sản phẩm
		//	$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/san-pham', $this->sanPham, $this->congNghe);
			// $this->cloneVietNamNet('https://vietnamnet.vn/vn/cong-nghe/san-pham/', $this->sanPham, $this->congNghe);
			// $this->cloneVietNamPlus('https://www.vietnamplus.vn/congnghe/sanphammoi.vnp', $this->sanPham, $this->congNghe);
			// $this->cloneVnexpress('https://vnexpress.net/so-hoa/san-pham', $this->sanPham, $this->congNghe);
	}

	public function phapLuat()
	{
		// an ninh trật tự
			// $this->cloneNongNghiep('https://nongnghiep.vn/an-ninh-nong-thon/', $this->anNinh, $this->phapLuat);
			// $this->cloneDatViet('https://baodatviet.vn/phap-luat/te-nan-xa-hoi/', $this->anNinh, $this->phapLuat);
			// $this->cloneNguoiLaoDong('https://nld.com.vn/dia-phuong/an-ninh-trat-tu.htm', $this->anNinh, $this->phapLuat);
		// hình sự dân dự
			// $this->cloneCongAnNhanDan('http://cand.com.vn/ban-tin-113/', $this->hinhSu, $this->phapLuat);
			// $this->cloneCongAnNhanDan('http://cand.com.vn/Lan-theo-dau-vet-toi-pham/', $this->hinhSu, $this->phapLuat);
			$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/an-ninh-hinh-su', $this->hinhSu, $this->phapLuat);
	}

	public function giaiTri()
	{
		// âm nhạc
		    $this->cloneTiin('http://tiin.vn/nhac.html', $this->amNhac, $this->giaiTri);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/giai-tri/nhac/', $this->amNhac, $this->giaiTri);
			$this->cloneSaoStar('https://saostar.vn/am-nhac/', $this->amNhac, $this->giaiTri);
			$this->cloneSaoStar('https://saostar.vn/am-nhac/v-pop/', $this->amNhac, $this->giaiTri);
		// thời trang
			$this->cloneVnexpress('https://vnexpress.net/giai-tri/thoi-trang', $this->thoiTrang, $this->giaiTri);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/giai-tri/thoi-trang/', $this->thoiTrang, $this->giaiTri);
			$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/thoi-trang-c63/', $this->thoiTrang, $this->giaiTri);
		// điện ảnh
		    $this->cloneTiin('http://tiin.vn/phim.html', $this->dienAnh, $this->giaiTri);
			$this->cloneSaoStar('https://saostar.vn/dien-anh/phim-truyen-hinh/', $this->dienAnh, $this->giaiTri);
			$this->cloneSaoStar('https://saostar.vn/dien-anh/phim-chieu-rap/', $this->dienAnh, $this->giaiTri);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/giai-tri/truyen-hinh/', $this->dienAnh, $this->giaiTri);
			$this->cloneVnexpress('https://vnexpress.net/giai-tri/phim', $this->dienAnh, $this->giaiTri);
		// Sao
		    $this->cloneTiin('http://tiin.vn/sao.html', $this->sao, $this->giaiTri);
	}

	public function nhaDat()
	{
		// quản lý quy hoạch
		//	$this->cloneVietNamNet('https://vietnamnet.vn/vn/bat-dong-san/du-an/', $this->quanLy, $this->nhaDat);
			$this->cloneCafeBiz('https://cafebiz.vn/quy-hoach-do-thi.html', $this->quanLy, $this->nhaDat);
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/bat-dong-san/du-an/', $this->quanLy, $this->nhaDat);
		// không gian kiến trúc
			$this->cloneVietNamNet('https://vietnamnet.vn/vn/bat-dong-san/nha-dep/', $this->khongGian, $this->nhaDat);
			$this->cloneDanTri('https://dantri.com.vn/khong-gian-kien-truc.tag', $this->khongGian, $this->nhaDat);
	}

	public function saoStar()
	{
		$this->cloneSaoStar('https://saostar.vn/am-nhac/', $this->amNhac, $this->giaiTri);
		$this->cloneSaoStar('https://saostar.vn/am-nhac/v-pop/', $this->amNhac, $this->giaiTri);
		$this->cloneSaoStar('https://saostar.vn/thoi-trang/', $this->thoiTrang, $this->giaiTri);
		$this->cloneSaoStar('https://saostar.vn/dien-anh/phim-truyen-hinh/', $this->dienAnh, $this->giaiTri);
		$this->cloneSaoStar('https://saostar.vn/dien-anh/phim-chieu-rap/', $this->dienAnh, $this->giaiTri);
	}

	public function baoQuocTe()
	{
		$this->cloneBaoQuocTe('https://baoquocte.vn/thoi-su', $this->thoiSu, $this->xaHoi);
	}

	public function nguoiLaoDong()
	{
		$this->cloneNguoiLaoDong('https://nld.com.vn/suc-khoe.htm', $this->sucKhoe, $this->doiSong);
		$this->cloneNguoiLaoDong('https://nld.com.vn/cong-doan/viec-lam.htm', $this->laoDong, $this->kinhTe);
		$this->cloneNguoiLaoDong('https://nld.com.vn/nghe-thuat.html', $this->ngheThuat, $this->vanHoa);
	}

	public function doiSongPhapLuat()
	{
		$this->cloneDoiSongPhapLuat('https://www.doisongphapluat.com/phap-luat/an-ninh-hinh-su/', $this->hinhSu, $this->phapLuat);
	}

	public function baoTinTuc()
	{
		$this->cloneBaoTinTuc('https://baotintuc.vn/thoi-su-472ct0.htm', $this->thoiSu, $this->xaHoi);
	}

	public function phuNuVietNam()
	{
		$this->clonePhuNuVietNam('https://phunuvietnam.vn/dep.htm', $this->dinhDuong, $this->doiSong);
		$this->clonePhuNuVietNam('https://phunuvietnam.vn/tinh-yeu-hon-nhan.html', $this->tinhYeu, $this->doiSong);
		$this->clonePhuNuVietNam('https://phunuvietnam.vn/khoe.htm', $this->sucKhoe, $this->doiSong);
	}

	public function nhanDan()
	{
		$this->cloneNhanDan('https://nhandan.com.vn/y-te', $this->sucKhoe, $this->doiSong);
	}

	public function sucKhoeDoiSong()
	{
		$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/dinh-duong-c38/', $this->dinhDuong, $this->doiSong);
		$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/y-hoc-co-truyen-c9/', $this->sucKhoe, $this->doiSong);
		$this->cloneSucKhoeDoiSong('https://suckhoedoisong.vn/am-thuc-va-dinh-duong-c89/', $this->amThuc, $this->vanHoa);
	}

	public function danTri()
	{
		$this->cloneDanTri('https://dantri.com.vn/the-thao.htm', $this->bongDa, $this->theThao);
	}

	public function vnexpress()
	{
		$this->cloneVnexpress('https://vnexpress.net/the-gioi/quan-su', $this->quanSu, $this->theGioi);
// 		$this->cloneVnexpress('https://vnexpress.net/the-gioi/phan-tich', $this->phanTich, $this->theGioi);
// 		$this->cloneVnexpress('https://vnexpress.net/the-gioi/tu-lieu', $this->tuLieu, $this->theGioi);
// 		$this->cloneVnexpress('https://vnexpress.net/thoi-su', $this->thoiSu, $this->xaHoi);
// 		$this->cloneVnexpress('https://vnexpress.net/bong-da', $this->bongDa, $this->theThao);
// 		$this->cloneVnexpress('https://vnexpress.net/the-thao/tennis', $this->quanVot, $this->theThao);
// 		$this->cloneVnexpress('https://vnexpress.net/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
// 		$this->cloneVnexpress('https://vnexpress.net/giao-duc/du-hoc', $this->duHoc, $this->giaoDuc);
// 		$this->cloneVnexpress('https://vnexpress.net/suc-khoe', $this->sucKhoe, $this->doiSong);
// 		$this->cloneVnexpress('https://vnexpress.net/topic/lao-dong-viec-lam-15474', $this->laoDong, $this->kinhTe);
// 		$this->cloneVnexpress('https://vnexpress.net/tag/tinh-yeu-hon-nhan-gia-dinh-99724', $this->tinhYeu, $this->doiSong);
// 		$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/the-gioi-dong-vat', $this->tgdv, $this->khoaHoc);
// 		$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/chuyen-la', $this->chuyenLa, $this->khoaHoc);
// 		$this->cloneVnexpress('https://vnexpress.net/khoa-hoc/trong-nuoc', $this->trongNuoc, $this->khoaHoc);
		$this->cloneVnexpress('https://vnexpress.net/the-thao/cac-mon-khac', $this->monKhac, $this->theThao);
	}

	public function datViet()
	{
		$this->cloneDatViet('https://baodatviet.vn/kinh-te/tai-chinh/', $this->taiChinh, $this->kinhTe);
	}

	public function nguoiDuaTin()
	{
		$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/kinh-doanh', $this->kinhDoanh, $this->kinhTe);
		$this->cloneNguoiDuaTin('https://www.nguoiduatin.vn/c/an-ninh-hinh-su', $this->hinhSu, $this->phapLuat);
	}

	public function nongNghiep()
	{
		$this->cloneNongNghiep('https://nongnghiep.vn/an-ninh-nong-thon/', $this->anNinh, $this->phapLuat);
	}

	public function congAnNhanDan()
	{
		$this->cloneCongAnNhanDan('http://cand.com.vn/ban-tin-113/', $this->hinhSu, $this->phapLuat);
		$this->cloneCongAnNhanDan('http://cand.com.vn/y-te/', $this->sucKhoe, $this->doiSong);
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
		$this->cloneVietNamNet('https://vietnamnet.vn/vn/cong-nghe/san-pham/', $this->cntt, $this->congNghe);
		$this->cloneVietNamNet('https://vietnamnet.vn/vn/bat-dong-san/du-an/', $this->quanLy, $this->nhaDat);
		// $this->cloneVietNamNet('https://vietnamnet.vn/vn/cong-nghe/vien-thong/', $this->cntt, $this->congNghe);
		// $this->cloneVietNamNet('https://vietnamnet.vn/vn/kinh-doanh/tai-chinh/', $this->taiChinh, $this->kinhTe);
	}

	public function cafeBiz()
	{
		$this->cloneCafeBiz('https://cafebiz.vn/thoi-su.chn', $this->thoiSu, $this->xaHoi);
		//$this->cloneCafeBiz('https://cafebiz.vn/cau-chuyen-kinh-doanh.chn', $this->kinhDoanh, $this->kinhTe);
	}

	public function laoDong()
	{
		$this->cloneLaoDong('https://laodong.vn/bong-da-quoc-te/', $this->bongDa, $this->theThao);
	}

	public function bao24h()
	{
		$this->cloneBao24h('https://www.24h.com.vn/bong-da-c48.html', $this->bongDa, $this->theThao);
	}

	public function cloneSaoStar($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.width-offset-30 .post-item') as $link) {
			try {
				$linkFull = $link->find('a', 0)->href;
				$thumbnail = $link->find('a', 0)->attr['data-src'];

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataSaoStar($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi hàm <cloneSaoStar</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link;
			}
		}
	}

	public function cloneDanTri($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://dantri.com.vn';

		foreach ($html->find('#listcheckepl .mt3') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataDanTri($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
		}
	}

	public function cloneNguoiDuaTin($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://www.nguoiduatin.vn';

		foreach ($html->find('.more-articles .col .box-news') as $link) {
			try {
				$linkFull = $domain . $link->find('a', 0)->href;
				$thumbnail = $link->find('img', 0)->src;
				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataNguoiDuaTin($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
				
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneNguoiDuaTin</b> ' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
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
				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataNongNghiep($linkFull, $subCategoryId, $categoryId, $thumbnail, $date);	
				}
				
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneNongNghiep</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
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

	public function cloneCongAnNhanDan($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.listnews .article') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$this->getDataCongAnNhanDan($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function cloneBongDa($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		
		foreach ($html->find('.list_top_news li') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataBongDa($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
		}
	}

	public function cloneTuoiTre($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://tuoitre.vn';

		foreach ($html->find('.list-news-content .news-item') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataTuoiTre($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
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

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataVietNamPlus($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
				
			}
		} catch (\Exception $e) {
			echo "Lỗi hàm <b>cloneVietNamPlus</b>". ' lỗi dòng' . $e->getLine() . ':' . $link .'<hr>';
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
				echo 'Lỗi <b>cloneLaoDong</b><hr>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}
	}

	public function cloneCafeBiz($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://cafebiz.vn';

		foreach($html->find('.noibat1 ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[0]->href;
				$thumbnail = $link->find('a')[0]->find('img')[0]->src;

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataCafeBiz($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneCafeBiz</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}

		foreach ($html->find('.listtimeline ul li') as $link) {
			try {
				$linkFull = $domain . $link->find('a')[1]->href;
				$thumbnail = $link->find('a')[1]->find('img')[0]->src;

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataCafeBiz($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneCafeBiz</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}
	}

	public function cloneVnexpress($link, $subCategoryId, $categoryId)
	{
		try {
			$html = file_get_html($link);
			$stt = 0;
			foreach ($html->find('.item-news') as $link) {
				if (!empty($link->find('a'))) {
					$linkFull = $link->find('a', 0)->href;
					$this->getDataVnexpress($linkFull, $subCategoryId, $categoryId);
				}
			}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>cloneVnexpress</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link;
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
				
			} catch (\Exception $e) {
				echo "Lỗi hàm <b>cloneBao24h</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}		
	}
	
	public function cloneTiin($link, $subCategoryId, $categoryId)
	{
	    $html = file_get_html($link);
	    
	    if (!empty($html->find('.right-cat-news-container'))) {
	        foreach ($html->find('.right-cat-news-container .blast-list-row') as $link) {
	            $this->getDataTiin($link->find('a', 0)->href, $subCategoryId, $categoryId, $link->find('img', 0)->src);
	        }
	    }
	    
	    if (!empty($html->find('.container-docnhieu'))) {
	        foreach ($html->find('.container-docnhieu .dl-row') as $link) {
	            $this->getDataTiin($link->find('a', 0)->href, $subCategoryId, $categoryId, NULL);
	        }
	    }
	}

	public function cloneSucKhoeDoiSong($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.list_news_home li') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataSucKhoeDoiSong($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
			
		}
	}

	public function cloneNhanDan($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://nhandan.com.vn';

		foreach ($html->find('.hotnew-container .media') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $domain . $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataNhanDan($linkFull, $subCategoryId, $categoryId, $thumbnail, $domain);
			}
		}
	}

	public function cloneDatViet($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://baodatviet.vn/';

		foreach ($html->find('.list_top li') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$this->getDataDatViet($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function clonePhuNuVietNam($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://phunuvietnam.vn';

		foreach ($html->find('.section-1 .img') as $link) {
			try {
				$linkFull = $domain . $link->href;
				$thumbnail = $link->find('img', 0)->src;

				if ($this->checkImage($thumbnail) != NULL) {
					$this->getDataPhuNuVietNam($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi <b>clonePhuNuVietNam</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}

		foreach ($html->find('.left .list-news-timeline .box') as $link) {
			try {
				$linkFull = $domain . $link->find('a', 0)->href;
				$thumbnail = $link->find('img', 0)->src;

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataPhuNuVietNam($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi <b>clonePhuNuVietNam</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}
	}

	public function cloneBaoTinTuc($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://baotintuc.vn/';
		
		foreach ($html->find('#plhMain_ctl00_divFocus .box11') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$this->getDataBaoTinTuc($linkFull, $subCategoryId, $categoryId);
		}

		foreach ($html->find('#plhMain_ctl00_divFocus .box13 li') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$this->getDataBaoTinTuc($linkFull, $subCategoryId, $categoryId);
		}

		foreach ($html->find('.listspecial>ul>li') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$this->getDataBaoTinTuc($linkFull, $subCategoryId, $categoryId);
		}
	}

	public function cloneDoiSongPhapLuat($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.art-listing ul .pkg') as $link) {
			try {
				$linkFull = $link->find('a', 0)->href;
				$thumbnail = $link->find('img', 0)->src;

				if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
					$this->getDataDoiSongPhapLuat($linkFull, $subCategoryId, $categoryId, $thumbnail);
				}
			} catch (\Exception $e) {
				echo 'Lỗi <b>cloneDoiSongPhapLuat</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
			}
		}
	}
	
	public function cloneNguoiLaoDong($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);
		$domain = 'https://nld.com.vn';

		foreach ($html->find('.cate-list-news .list-news .news-item') as $link) {
			$linkFull = $domain . $link->find('a', 0)->href;
			$thumbnail = $link->find('img', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataNguoiLaoDong($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
			
		}
	}

	public function cloneBaoQuocTe($link, $subCategoryId, $categoryId)
	{
		$html = file_get_html($link);

		foreach ($html->find('.colLeftlistCter #listingGrNews li') as $link) {
			$linkFull = $link->find('a', 0)->href;
			$thumbnail = $link->find('.itemStory', 0)->src;

			if ($this->checkImage($thumbnail) != NULL && $this->checkImage($thumbnail) > 0) {
				$this->getDataBaoQuocTe($linkFull, $subCategoryId, $categoryId, $thumbnail);
			}
		}
	}
	
	public function getDataTiin($link, $subCategoryId, $categoryId, $thumbnail)
	{
	    try {
	        $web = 'tiin.vn';
	        $web_name = 'Tiin';
	        $urlMd5 = md5($link);
	        $check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
			    $html = file_get_html($link);
			    $title = trim(html_entity_decode($html->find('#title-container', 0)->plaintext));
			    $slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);
				
				if ($checkTitle == 0) {
    			    if (!empty($html->find('#left-content-container #time'))) {
    			        $date = $html->find('#left-content-container #time', 0)->plaintext;
    			        $date = str_replace('/', '-', $date);
    			        $date = date('Y-m-d H:i:s', strtotime($date));
    			    } else {
    			        $date = date('Y-m-d H:i:s');
    			    }
    			    $folder = date('Y-m', strtotime($date));
    				$this->createFolder($folder);
    				
    				if (!empty($html->find('#body-content'))) {
    				    $summury = html_entity_decode($html->find('#content-header', 0)->plaintext);
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);
                        $replace = array($summury, $title);
						$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
    				    
    				    echo "Thêm thành công" . '<br>' . $link . '<hr>';
    				}
				} else {
				    echo 'Tin này đã thêm <b>tiin.vn</b><hr>';
				}
			}
	    } catch (\Exception $e) {
	        echo 'Lỗi ' . $e->getMessage() . '<br>';
	        echo 'Lỗi dòng' . $e->getLine() . '<br>';
	        echo 'Lỗi link ' . $link . '<br>';
	        echo '<hr>';
	    }
	}

	public function getDataSaoStar($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'saostar.vn';
			$web_name = 'Sao Star';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.head-article .header-writer .time-ago'))) {
					$date = $html->find('.head-article .header-writer .time-ago', 0)->datetime;
					$date = str_replace('+07:00', '', $date);
					$date = str_replace('T', ' ', $date);
				} else {
					$date = date('Y-m-d H:i:s');
				}

				$folder = date('Y-m', strtotime($date));
				$this->createFolder($folder);
				$title = trim(html_entity_decode($html->find('.head-article .article-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);
				
				if ($checkTitle == 0) {
					if (!empty($html->find('.popup-path'))) {
						$summury = trim(html_entity_decode($html->find('.popup-path .article-sapo', 0)->plaintext));
						$content = html_entity_decode($html->find('.popup-path .article-body', 0)->innertext);
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);

						if (!empty($html->find('.article-body .wp-video'))) {
							foreach ($html->find('.article-body .wp-video') as $video) {
								$content = str_replace($video->outertext, '', $content);
							}
						}
						$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					}
				} else {
				    echo 'Tin này đã thêm <b>saostar.vn</b><hr>';
				}
			} else {
			    echo 'Tin này đã thêm <b>saostar.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataSaoStar</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataBaoQuocTe($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$thumbnail = '';
			$web = 'baoquocte.vn';
			$web_name = 'Quốc Tế';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.sharefullColLeft'))) {
					if (!empty($html->find('.detailNews .dateUp .format_time'))) {
						$date = trim($html->find('.detailNews .dateUp .format_time', 0)->plaintext);
						$date = str_replace('/', '-', $date);
						$date = date('Y-m-d H:i:s', strtotime(($date)));
					} else {
						$date = date('Y-m-d H:i:s');
					}
					$folder = date('Y-m', strtotime($date));
					$this->createFolder($folder);
					$title = trim(html_entity_decode($html->find('.sharefullColLeft .detailNews .titleDetailNews', 0)->plaintext));
					$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = html_entity_decode($html->find('.sharefullColLeft .padB10', 0)->plaintext);
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);
						$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

						echo "Thêm tin thành công<b>baoQuocTe.vn</b>";
					} else {
						echo 'Tin này đã thêm<b>baoquocte.vn</b><hr>';
					}
				}
			} else {
				echo 'Tin này đã thêm <b>baoQuocTe.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataBaoQuocTe</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataNguoiLaoDong($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'nld.com.vn';
			$web_name = 'Người Lao Động';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.dateandcat .pdate'))) {
					$date = $html->find('.dateandcat .pdate', 0)->plaintext;
					$date = substr($date, 0, 18);
					$date1 = substr($date, 0, 10);
					$date2 = substr($date, 13, 15);
					$date = $date1 . ' ' . $date2;
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				$title = trim(html_entity_decode($html->find('.nld-detail .title-content', 0)->plaintext));
				$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = html_entity_decode($html->find('.nld-detail .sapo-detail', 0)->plaintext);
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

					echo 'Thên tin thành công <b>nld.com.vn</b><hr>';
				} else {
					echo 'Tin này đã thêm <b>nld.com.vn</b><hr>';
				}
			} else {
				echo 'Tin này đã thêm <b>nld.com.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataNguoiLaoDong</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link;
		}
	}

	public function getDataDoiSongPhapLuat($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'doisongphapluat.com';
			$web_name = 'Đời Sống Pháp Luật';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);
				if (!empty($html->find('.right_detail'))) {
					if (!empty($html->find('.right_detail .fl-right'))) {
						$date = $html->find('.right_detail .fl-right', 0)->plaintext;
						$date = trim(explode(',', $date)[1]);
						$date = str_replace('/', '-', $date);
						$date = str_replace('|', '', $date);
						$date = trim(str_replace('GMT+7', '', $date));
						$date = date('Y-m-d H:i:s', strtotime($date));
					} else {
						$date = date('Y-m-d H:i:s');
					}
					$title = trim(html_entity_decode($html->find('.right_detail .art-title', 0)->plaintext));
					$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = html_entity_decode($html->find("meta[property='og:description']", 0)->content);
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
			    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
			    		$this->insertNewsDay($date, $result);
			    		echo 'Thêm tin thành công <b>doisongphapluat.com</b><hr>';
					} else {
						echo 'Tin này đã thêm <b>doisongphapluat.com</b><hr>';
					}
				}
			} else {
				echo 'Tin này đã thêm <b>doisongphapluat.com</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataDoiSongPhapLuat</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataBaoTinTuc($link, $subCategoryId, $categoryId) {
		try {
		    $thumbnail = '';
			$web = 'baotintuc.vn';
			$web_name = 'Tin Tức';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.newsdetail'))) {
					if (!empty($html->find('.newsdetail .sharing .time'))) {
						$date = $html->find('.newsdetail .sharing .time', 0)->plaintext;
						$date = trim(explode(',', $date)[1]);
						$date = str_replace('/', '-', $date);
						$date = date('Y-m-d H:i:s', strtotime($date));
					} else {
						$date = date('Y-m-d H:i:s');
					}
					$title = trim(html_entity_decode($html->find('.newsdetail .title', 0)->plaintext));
					$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = trim(html_entity_decode($html->find(".newsdetail .sapo", 0)->plaintext));
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);
			    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

			    		echo 'Thêm tin thành công <b>baotintuc</b><hr>';
					} else {
						echo 'Tin này đã thêm <b>baotintuc</b><hr>';
					}
				}
			} else {
				echo 'Tin này đã thêm <b>baotintuc</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataBaoTinTuc</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataPhuNuVietNam($link, $subCategoryId, $categoryId, $thumbnail){
		try {
			$web = 'phunuvietnam.vn';
			$web_name = 'Phụ Nữ Việt Nam';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);
				if (!empty($html->find('.nguon_date .d'))) {
					$date = $html->find('.nguon_date .d', 0)->plaintext;
					$date1 = trim(explode(' ', $date)[0]);
					$date2 = trim(explode(' ', $date)[2]);
					$date = $date1 . ' ' . $date2;
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				
				if (!empty($html->find('.dt_left'))) {
					$title = trim(html_entity_decode($html->find('.dt_left .title_new', 0)->plaintext));
					$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = trim(html_entity_decode($html->find(".dt_left .sapo-detail", 0)->plaintext));
						$content = $html->find('.dt_left .content-detail', 0)->innertext;
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='news_keywords']", 0)->content);
			    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

			    		echo 'Thêm tin thành <b>phuNuVietNam</b><hr>';
					} else {
						echo 'Tin này đã thêm <b>phuNuVietNam</b><hr>';
					}
				}
			} else {
				echo 'Tin này đã thêm <b>phuNuVietNam</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataPhuNuVietNam</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataDatViet($link, $subCategoryId, $categoryId)
	{
		try {

			$thumbnail = '';
			$web = 'baodatviet.vn';
			$web_name = 'Đất Việt';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			
			if ($check == 0) {
				$html = file_get_html($link);
				if (!empty($html->find('.sharedetail .time'))) {
					$date = trim($html->find('.sharedetail .time', 0)->plaintext);
					$date = trim(explode(',', $date)[1]);
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}

				if (!empty($html->find('#left_col #detail'))) {
					$title = trim(html_entity_decode($html->find('#left_col #detail .title', 0)->plaintext));
					$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = trim(html_entity_decode($html->find("#left_col #detail .lead", 0)->plaintext));
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
			    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

			    		echo 'Thêm tin thành công <b>getDataDatViet</b><hr>';
					} else {
						echo 'Tin này đã thêm <b>getDataDatViet</b><hr>';
					}
				}

			} else {
				echo 'Tin này đã thêm <b>getDataDatViet</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataDatViet</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataDanTri($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'dantri.com.vn';
			$web_name = 'Dân Trí';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$html = file_get_html($link);
			
			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.box26 .fr'))) {
					$date = trim($html->find('.box26 .fr', 0)->plaintext);
					$date1 = explode(' ', $date)[2];
					$date2 = explode(' ', $date)[4];
					$date = $date1 . ' ' . $date2;
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				$title = html_entity_decode($html->find("meta[property='og:title']", 0)->content);
				$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = html_entity_decode($html->find("meta[property='og:description']", 0)->content);
					$summury = trim(str_replace('(Dân trí) -', '', $summury));
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

		    		echo 'Thêm tin thành công <b>dantri.com.vn</b><hr>';
				} else {
					echo 'Tin này đã thêm <b>dantri.com.vn</b><hr>';
				}
			} else {
				echo 'Tin này đã thêm <b>dantri.com.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataDanTri()</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataNhanDan($link, $subCategoryId, $categoryId, $thumbnail, $domain)
	{
		try {
			$web = 'nhandan.com.vn';
			$web_name = 'Nhân Dân';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

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
	    		$title = html_entity_decode($html->find("meta[name='title']", 0)->content);
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$og_image = $domain . $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
		    		echo 'Thêm tin thành công <b>nhandan.com.vn</b><hr>';
				} else {
					echo 'Tin này đã thêm <b>nhandan.com.vn</b><hr>';
				}
			} else {
				echo 'Tin này đã thêm <b>nhandan.com.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataNhanDan</b><hr>' . ' lỗi dòng' . $e->getLine() . ':' . $link;
		}
	}

	public function getDataBongDa($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'bongda.com.vn';
			$web_name = 'Bóng Đá';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

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
	    		$title = trim(html_entity_decode($html->find('.time_detail_news', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.sapo_detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    			$summury = trim(str_replace('BongDa.com.vn', '', $summury));
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					echo 'Thêm tin thành công bongda.com.vn';
				} else {
					echo 'Lỗi <b>getDataBongDa</b><hr>';
				}
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataBongDa</b>' . $e->getLine() . '<hr>';
		}
	}

	public function getDataSucKhoeDoiSong($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {			
			$web = 'suckhoedoisong.vn';
			$web_name = 'Sức Khỏe Đời Sống';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

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
	    		$title = trim(html_entity_decode($html->find('.title-detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.sapo_detail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    			$summury = str_replace('Suckhoedoisong.vn - ', '', $summury);
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
		    		echo 'Thêm tin thành công <b>suckhoedoisong.vn</b><hr>';
				} else {
					echo 'Tin này đã thêm <b>suckhoedoisong.vn</b><hr>';
				}
			} else {
				echo 'Tin này đã thêm <b>suckhoedoisong.vn</b><hr>';
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataSucKhoeDoiSong</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataNguoiDuaTin($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$web = 'nguoiduatin.vn';
			$web_name = 'Người Đưa Tin';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

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
		    		$title = trim(html_entity_decode($html->find('.contents .title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
		    		$slug = $nameImage = str_slug($title);
					$checkTitle = $this->checkTitle($slug);

					if ($checkTitle == 0) {
						$summury = trim(html_entity_decode($html->find('.contents .sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
						$og_image = $html->find("meta[property='og:image']", 0)->content;
						$keyword = '';

						if (!empty($html->find('ul.tags'))) {
							foreach ($html->find('.tags li') as $tag)
							{
								$keyword = $keyword . $tag->plaintext . ',';
							}
						}
			    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
			    		$this->insertNewsDay($date, $result);

			    		echo "Thêm tin thành công <b>nguoiduatin.vn</b><hr>";
					} else {
						echo "Tin này đã thêm <b>nguoiduatin.vn</b><hr>";
					}
				}
			} else {
					echo "Tin này đã thêm <b>nguoiduatin.vn</b><hr>";
				}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataNguoiDuaTin</b> " . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataNongNghiep($link, $subCategoryId, $categoryId, $thumbnail, $date)
	{
		try {
			$web = 'nongnghiep.vn';
			$web_name = 'Nông Nghiệp';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);
				$folder = date('Y-m', strtotime($date));
	    		$this->createFolder($folder);
	    		$title = trim(html_entity_decode($html->find('.detail-content .main-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.detail-content .main-intro', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
		    		echo "Thêm thành công <b>nongnghiep.vn</b><hr>";
				} else {
					echo "Tin này đã thêm <b>nongnghiep.vn</b><hr>";
				}
			} else {
				echo "Tin này đã thêm <b>nongnghiep.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataNongNghiep</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataQdnd($link, $subCategoryId, $categoryId)
	{
		try {
			$thumbnail = '';
			$web = 'qdnd.vn';
			$web_name = 'Quân Đội Nhân Dân';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);

			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.post-head .post-subinfo'))) {
					$date = trim($html->find('.post-head .post-subinfo', 0)->plaintext);
					$date = str_replace('/', '-', $date);
					$date = date('Y-m-d H:i:s', strtotime($date));

				} else {
					$date = date('Y-m-d H:i:s');
				}
	    		$title = trim(html_entity_decode($html->find('.post-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.post-summary', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = '';

					if (!empty($html->find('.post-tag a[itemprop="keywords"]'))) {
						foreach ($html->find('.post-tag a[itemprop="keywords"]') as $tag) {
							$keyword = $keyword . $tag->plaintext . ',';
						}
					}
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
		    		echo "Thêm tin thành công <b>qdnd.vn</b><hr>";

				} else {
					echo "Tin này đã thêm <b>qdnd.vn</b><hr>";
				}
			} else {
				echo "Tin này đã thêm <b>qdnd.vn</b><hr>";
			}

		} catch (\Exception $e) {
			echo "Lỗi <b>getDataQdnd</b><hr>" . ' lỗi dòng' . $e->getLine() . ':' . $link;
		}
	}

	public function getDataTuoiTre($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$urlMd5 = md5($link);
	    	$web = 'tuoitre.vn';
	    	$web_name = 'Tuổi Trẻ';
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
	    		$title = trim(html_entity_decode($html->find('.content-detail .article-title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.main-content-body .sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$keyword = $html->find("meta[name='keywords']", 0)->content;
	    			$keyword = str_replace(';', ',', $keyword);
					$og_image = $html->find("meta[property='og:image']", 0)->content;
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
		    		echo "Thêm thành công <b>tuoitre.vn</b><hr>";
				} else {
					echo "Tin này đã thêm <b>tuoitre.vn</b><hr>";
				}
	    	} else {
	    		echo "Tin này đã thêm <b>tuoitre.vn</b><hr>";
	    	}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>getDataTuoiTre</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataCongAnNhanDan($link, $subCategoryId, $categoryId)
	{
		try {
			$thumbnail = '';
			$urlMd5 = md5($link);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'cand.com.vn';
	    	$web_name = 'Công An Nhân Dân';
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
	    		$title = trim(html_entity_decode($html->find('.box-widget .titledetail', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
	    		$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('.box-widget .desnews', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = '';

					if (!empty($html->find('.box-widget .tags'))) {
						foreach ($html->find('.box-widget .tags li') as $key => $tag) {
							if ($key > 0) {
								$keyword = $keyword . $tag->plaintext . ',';
							}
						}
					}
		    		$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
				} else {
					echo "Tin đã thêm <b>cand.com.vn</b><hr>";
				}
	    	} else {
	    		echo "Tin đã thêm <b>cand.com.vn</b><hr>";
	    	}

		} catch (\Exception $e) {
			echo "Lỗi <b>getDataCongAnNhanDan</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataBao24h($link, $subCategoryId, $categoryId, $date)
	{
		try {
			$web = '24h.com.vn';
			$web_name = '24h';
			$urlMd5 = md5($link);
			$check = $this->check($urlMd5, $categoryId);
			$thumbnail = '';

			if ($check == 0) {
				$html = file_get_html($link);
				$title = trim(html_entity_decode($html->find('#left #article_body #article_title', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$slug = $nameImage = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = trim(html_entity_decode($html->find('#left #article_body #article_sapo', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
					$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					echo "Thêm thành công <b>24h.com.vn</b><hr>";
				} else {
					echo "Tin này đã thêm <b>24h.com.vn</b><hr>";
				}
			} else {
				echo "Tin này đã thêm <b>24h.com.vn</b><hr>";
			}	
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataBao24h</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataVietNamPlus($link, $subCategoryId, $categoryId, $thumbnail)
	{
		try {
			$urlMd5 = md5($link);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'vietnamplus.vn';
	    	$web_name = 'vietnamplus';

			if ($check == 0) {
		    	$html = file_get_html($link);

		    	if (!empty($html->find('.details__meta .source time'))) {
		    		$date = $html->find('.details__meta .source time', 0)->datetime;
		    	} else {
		    		$date = date('Y-m-d H:i:s');
		    	}
		    	$title = html_entity_decode(trim($html->find('.details__headline')[0]->plaintext));
		    	$nameImage = $slug = str_slug($title);
		    	$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
	    			$keyword = html_entity_decode($html->find("meta[name='keywords']", 0)->content);
					$og_image = $html->find("meta[property='og:image:url']", 0)->content;
		    		$summury = html_entity_decode(trim($html->find("meta[name='description']", 0)->content));
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					echo "Thêm tin thành công <b>Vietnamplus.vn</b><hr>";
				} else {
					echo "Tin này đã thêm <b>Vietnamplus.vn</b><hr>";
				}
			    
			} else {
				echo "Tin này đã thêm <b>Vietnamplus.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi <b>getDataVietNamPlus</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}
	
	public function getDataVnexpress($link, $subCategoryId, $categoryId)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'VnExpress.net';
	    $web_name = 'VnExpress';
		$array = array();

		try {		
			if ($check == 0) {
				$html = file_get_html($link);

				if (!empty($html->find('.sidebar-1'))) {
					$title = trim($html->find('.sidebar-1 .title-detail', 0)->plaintext);
					$summury = trim($html->find('.sidebar-1 .description')[0]->plaintext);
				} else if (!empty($html->find('.sidebar_1'))){
					$title = trim($html->find('.sidebar_1 .title_news_detail', 0)->plaintext);
					$summury = trim($html->find('.sidebar_1 .description')[0]->plaintext);
				}

				$nameImage = $slug = str_slug($title);
				$thumbnail = '';
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					if (!empty($html->find('.sidebar-1 .header-content span.date'))) {
						$date = trim($html->find('.header-content span.date')[0]->plaintext);
			    		$date1 = trim(explode(',', $date)[1]);
			    		$date2 = trim(str_replace('(GMT+7)', '', explode(',', $date)[2]));
			    		$date = $date1 . ' ' . $date2;
				    	$date = str_replace('/', '-', $date);
				    	$date = date('Y-m-d H:i:s', strtotime($date));
			    	} else if (!empty($html->find('.sidebar_1 header.clearfix span.time'))) {
			    		$date = trim($html->find('header.clearfix span.time')[0]->plaintext);
			    		$date1 = trim(explode(',', $date)[1]);
			    		$date2 = trim(str_replace('(GMT+7)', '', explode(',', $date)[2]));
			    		$date = $date1 . ' ' . $date2;
				    	$date = str_replace('/', '-', $date);
				    	$date = date('Y-m-d H:i:s', strtotime($date));
			    	} else {
			    		$date = date('Y-m-d H:i:s');
			    	}
					$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					echo "Thêm thành công<b>vnExpress</b><hr>";
				} else {
					echo "Tin này đã thêm<b>vnExpress</b><hr>";
				}
			} else {
				echo "Tin này đã thêm<b>vnExpress</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi hàm <b>testVnexpress</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataLaoDong($link, $subCategoryId, $categoryId)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'laodong.vn';
	    $web_name = 'Lao động';
		$html = file_get_html($link);

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
				$title = trim(html_entity_decode($html->find('.title h1', 0)->plaintext, ENT_QUOTES, 'UTF-8'));
				$nameImage = $slug = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$keyword = html_entity_decode(trim($html->find("meta[name='keywords']", 0)->content), ENT_QUOTES, 'UTF-8');
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$summury = html_entity_decode(trim($html->find('.left-sidebar .abs', 0)->plaintext), ENT_QUOTES, 'UTF-8');
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					echo "Thêm tin thành công <b>Laodong.vn</b><hr>";
				} else {
					echo "Tin này đã thêm <b>Laodong.vn</b><hr>";
				}

			} else {
				echo "Tin này đã thêm <b>Laodong.vn</b><hr>";
			}
		} catch (\Exception $e) {
			echo "Lỗi <b>getDataLaoDong()</b>" . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function getDataVietNamNet($link, $subCategoryId, $categoryId)
	{
		try {
			$thumbnail = '';
			$urlMd5 = md5($link);
	    	$check = $this->check($urlMd5, $categoryId);
	    	$web = 'vietnamnet.vn';
	    	$web_name = 'vietnamnet';
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

				$title = html_entity_decode(trim($html->find('.ArticleDetail h1.title')[0]->plaintext), ENT_QUOTES, 'UTF-8');
				$nameImage = $slug = str_slug($title);
				$checkTitle = $this->checkTitle($slug);

				if ($checkTitle == 0) {
					$summury = html_entity_decode(trim($html->find('.ArticleLead p')[0]->plaintext), ENT_QUOTES, 'UTF-8');
					$og_image = $html->find("meta[property='og:image']", 0)->content;
					$keyword = $html->find("meta[name='keywords']", 0)->content;
					$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);
					$this->insertNewsDay($date, $result);
					echo "Thêm tin thành <b>Vietnamnet</b><hr>";
				} else {
					echo "Tin đã thêm <b>Vietnamnet</b><hr>";
				}
			} else {
				echo "Tin đã thêm <b>Vietnamnet</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>getDataVietNamNet</b>:' . ', lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
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

	public function getDataCafeBiz($link, $subCategoryId, $categoryId, $thumbnail)
	{
		$urlMd5 = md5($link);
		$check = $this->check($urlMd5, $categoryId);
	    $web = 'cafebiz.vn';
	    $web_name = 'cafebiz';
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
				$result = $this->insertPost($title, $slug, $summury, $keyword, $subCategoryId, $urlMd5, $link, $web, $date, $og_image, $categoryId, $web_name);

				echo "Thêm tin thành công<b>cafeBiz</b><hr>";
			} else {
				echo "Tin này đã thêm<b>cafeBiz</b><hr>";
			}
		} catch (\Exception $e) {
			echo 'Lỗi hàm <b>testCafeBiz</b>' . ' lỗi dòng' . $e->getLine() . ':' . $link . '<hr>';
		}
	}

	public function insertNewsDay($date, $news)
	{
		$home = route('client.home') . '/';
		$date = date('Y-m-d', strtotime($date));
		$newsDay = NewsDay::where('date', $date)->first();
		$route = route('client.detail', ['cate' => $news->category->slug, 'sub-cate' => $news->subCategory->slug, 'title' => $news->slug, 'p' => $news->id]);
		$route = str_replace($home, '', $route);
		$image = $news->image;
		$title = $news->title;
		$sub_cate = route('client.sub_cate', ['category' => $news->subCategory->category->slug, 'sub' => $news->subCategory->slug]);
		$sub_cate = str_replace($home, '', $sub_cate);
		$cate_name = $news->subCategory->name;
		$news_soure = route('client.news_soure', ['web' => urlencode($news->web)]);
		$news_soure = str_replace($home, '', $news_soure);
		$web = $news->web;

		if (empty($newsDay)) {
			NewsDay::create([
				'date' => $date,
				'content' => "<div class='news-list-item articles-list'>
								<div class='row' style='margin: 0px'>
		                            <div class='col-xs-3 col-sm-3 col-md-2 col-lg-2 news-list-item-left'>
		                                <a href='$route' class='thumb'>
		                                	<img data-src='$image' alt='$title' class='lazy img-responsive'></a>
		                            </div>
		                            <div class='col-xs-9 col-sm-9 col-md-10 col-lg-10 news-list-item-right'>
		                                <h4 title='$title'>
		                                	<a href='$route' class='title'>$title</a>
		                                </h4>
		                                <p style='margin-bottom: 0px;'>
											<a class='sub-category' href='$sub_cate'>$cate_name</a> <span style='color: #adb5bd'>|</span> <a class='soure' href='$news_soure'>$web</a>
										</p>
		                            </div>
		                        </div>
		                    </div>"
			]);
		} else {
			$content = $newsDay->content . "<div class='news-list-item articles-list'>
								<div class='row' style='margin: 0px'>
		                            <div class='col-xs-3 col-sm-3 col-md-2 col-lg-2 news-list-item-left'>
		                                <a href='$route' class='thumb'>
		                                	<img data-src='$image' alt='$title' class='lazy img-responsive'></a>
		                            </div>
		                            <div class='col-xs-9 col-sm-9 col-md-10 col-lg-10 news-list-item-right'>
		                                <h4 title='$title'>
		                                	<a href='$route' class='title'>$title</a>
		                                </h4>
		                                <p style='margin-bottom: 0px;'>
											<a class='sub-category' href='$sub_cate'>$cate_name</a> <span style='color: #adb5bd'>|</span> <a class='soure' href='$news_soure'>$web</a>
										</p>
		                            </div>
		                        </div>
		                    </div>";
		    $newsDay->content = $content;
		    $newsDay->save();
		}
	}

    public function insertPost($title, $slug, $summury, $keyword, $subCate, $urlMd5, $urlOrigin, $web, $date, $og_image, $categoryId, $web_name)
    {
    	try {
	    	return Post::create(
	    		[
	    			'title' => html_entity_decode($title),
	    			'slug' => $slug,
	    			'summury' => $summury,
	    			'image' => $og_image,
	    			'keyword' => $keyword,
	    			'sub_category_id' => $subCate,
	    			'category_id' => $categoryId,
	    			'url_md5' => $urlMd5,
	    			'url_origin' => $urlOrigin,
	    			'web' => $web,
	    			'web_name' => $web_name,
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
    						 ->get();

    	return count($result);
    }

    public function checkTitle($slug)
    {
    	$result = $this->post->where('slug', $slug)
    						 ->get();

    	return count($result);
    }

    public function resizeImage($data, $nameImage) {
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

    public function uploadThumbnail($og_image, $listImage, $listRand, $nameImage, $thumbnail, $folder, $post)
	{
		try {
			$width1 = NULL;
			$dem = 0;
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
						$fullpath = 'photos/images/' . $folder . '/' . $nameImage . '-' . $listRand[$key] . '.jpg';
						\Storage::disk('s3')->put($fullpath, file_get_contents($img, false, stream_context_create($arrContextOptions)), 'public');

						// $put_img = file_get_contents($img, false, stream_context_create($arrContextOptions));
						// file_put_contents(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'), $put_img);
						list($width, $height) = getimagesize($this->server . $fullpath);

						if ($width == NULL || $width == 0) {
							$dem++;
						}
					}
				}
			}

			//if ($checkUrl == 1) {
			    // $put_og_image = file_get_contents(str_replace(' ', '%20', $og_image), false, stream_context_create($arrContextOptions));
			    // file_put_contents(public_path("upload/og_images/" . $nameImage . '.jpg'), $put_og_image);

			    $pathOgImage = 'photos/og_images/' . $nameImage . '.jpg';
			    \Storage::disk('s3')->put($pathOgImage, file_get_contents(str_replace(' ', '%20', $og_image), false, stream_context_create($arrContextOptions)), 'public');
			    list($width1, $height1) = getimagesize($this->server . $pathOgImage);

			    // list($width1, $height1) = getimagesize(public_path("upload/og_images/$nameImage.jpg"));
			    
			    if ($thumbnail == '') {
			        $pathThumbnail = 'photos/thumbnails/' . $nameImage . '.jpg';
	    			// $data = getimagesize(public_path("upload/og_images/" . $nameImage . '.jpg'));
	    			// $this->resizeImage($data, $nameImage . '.jpg');
	    			\Storage::disk('s3')->put($pathThumbnail, file_get_contents(str_replace(' ', '%20', $og_image), false, stream_context_create($arrContextOptions)), 'public');
	    		} else {
	    			$thumbnail = str_replace(' ', '%20', $thumbnail);
	    			$pathThumbnail = 'photos/thumbnails/' . $nameImage . '.jpg';
	    			// $put_thumbnail = file_get_contents($thumbnail, false, stream_context_create($arrContextOptions));
	    			// file_put_contents(public_path("upload/thumbnails/" . $nameImage . '.jpg'), $put_thumbnail);

	    			\Storage::disk('s3')->put($pathThumbnail, file_get_contents($thumbnail, false, stream_context_create($arrContextOptions)), 'public');
	    		}
			//}
            
			if ($width1 == 0 || $dem > 0) {
				$postItem = Post::findOrFail($post->id);

				if (\Storage::disk('s3')->exists('photos/thumbnails/' . $postItem->image)) {
					\Storage::disk('s3')->delete('photos/thumbnails/' . $postItem->image);
				}
				if (\Storage::disk('s3')->exists('photos/og_images/' . $postItem->image)) {
					\Storage::disk('s3')->delete('photos/og_images/' . $postItem->image);
				}				
				// if (file_exists(public_path('upload/thumbnails/' . $postItem->image))) {
				// 	unlink(public_path('upload/thumbnails/' . $postItem->image));
				// 	unlink(public_path('upload/og_images/' . $postItem->image));
				// }
				
				foreach ($listImage as $key => $img) {
					if ($img != '') {
						if (\Storage::disk('s3')->exists("photos/images/$folder" . $nameImage . '-' . $listRand[$key] . '.jpg')) {
							\Storage::disk('s3')->delete("photos/images/$folder" . $nameImage . '-' . $listRand[$key] . '.jpg');
						}
						// if (file_exists(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'))) {
						// 	unlink(public_path("upload/images/$folder/" . $nameImage . '-' . $listRand[$key] . '.jpg'));
						// }
					}
				}
				$postItem->delete();
				
				return 'Tin này ảnh lỗi nên không thêm';
			} else {
				return 'Thêm tin thành công';
			}
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function checkImage($filePath)
	{
	    try {
			$arrContextOptions=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);
			$sourceImage = file_get_contents($filePath, false, stream_context_create($arrContextOptions));
			$newImage = imagecreatefromstring($sourceImage);
			$width = imagesx($newImage);
			$height = imagesy($newImage);
			
			return $width;
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function checkUrl($url)
	{
		$headers = @get_headers($url);

		if($headers && strpos( $headers[0], '200')) {
		    return 1;
		} 
		else { 
		    return 0;
		} 
	}

	public function deletePost($postId)
	{
		$post = Post::findOrFail($postId);
		$image = $post->image;
		$folder = date('Y-m', strtotime($post->date));
        
        if (\Storage::disk('s3')->exists("photos/thumbnails/$image")) {
			\Storage::disk('s3')->delete("photos/thumbnails/$image");
		}
		if (\Storage::disk('s3')->exists("photos/og_images/$image")) {
			\Storage::disk('s3')->delete("photos/og_images/$image");
		}
		$link = route('client.detail', [
											'cate' => $post->category->slug, 
											'sub' => $post->subCategory->slug, 
											'title' => $post->slug, 
											'p' => $postId
										]);
		$html = file_get_html($link);

		if (!empty($html->find('.bk-content .image-detail img'))) {
			foreach ($html->find('.bk-content .image-detail img') as $image) {
				$img = str_replace('https://diembao24h.s3-ap-southeast-1.amazonaws.com/', '', $image->src);
                
                if (\Storage::disk('s3')->exists($img)) {
        			\Storage::disk('s3')->delete($img);
        		}
			}
		}
		
		return $post->delete();
	}

	public function deleteSoure($web)
	{
		$posts = Post::where('web', $web)->get();

		foreach ($posts as $post) {
			$image = $post->image;

			if (file_exists(public_path('upload/og_images/' . $image))) {
				unlink(public_path('upload/og_images/' . $image));
			}
			if (file_exists(public_path('upload/thumbnails/' . $image))) {
				unlink(public_path('upload/thumbnails/' . $image));
			}
			$link = route('client.detail', [
											'cate' => $post->category->slug, 
											'sub' => $post->subCategory->slug, 
											'title' => $post->slug, 
											'p' => $post->id
										]);
			$html = file_get_html($link);

			if (!empty($html->find('.bk-content .image-detail img'))) {
				foreach ($html->find('.bk-content .image-detail img') as $image) {
					$img = $image->src;

					if (file_exists(public_path($img))) {
						unlink(public_path($img));
					}
				}
			}
			$post->delete();
			echo 'Đã xóa tin: ' . $post->id . '<hr>';
		}
	}

	public function test(Request $request)
	{
		$file = $request->file('file');
		$fileName = $file->getClientOriginalName();

		$uploadDir = 'test/';
		$fullpath = $uploadDir . $fileName;
		\Storage::disk('s3')->put($fullpath, file_get_contents($file), 'public');
	}
	
	public function checkImageInNews()
	{
	    $date = date('Y-m-d');
	    $posts = Post::where('created_at', 'like', $date . '%')->get();

	    foreach ($posts as $post) {
	        $checkOgImage = \Storage::disk('s3')->exists('photos/og_images/' . $post->image);
	        $checkThumbnail = \Storage::disk('s3')->exists('photos/thumbnails/' . $post->image);
	        
	        if ($checkOgImage == false || $checkThumbnail == false) {
	            $link = route('client.detail', [
											'cate' => $post->category->slug, 
											'sub' => $post->subCategory->slug, 
											'title' => $post->slug, 
											'p' => $post->id
										]);
    	        $html = file_get_html($link);
    	        
    	        foreach ($html->find('.bk-content img') as $img) {
    	            $img = str_replace('https://diembao24h.s3-ap-southeast-1.amazonaws.com/', '', $img->src);
    	            \Storage::disk('s3')->delete($img);
    	        }
    	        \Storage::disk('s3')->delete($checkOgImage);
    	        \Storage::disk('s3')->delete($checkThumbnail);
    	        $post->delete();
	        }
	    }
	}
}
