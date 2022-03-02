<?php
namespace App\Helpers;
use App\Models\Settings;
use App\Models\Category;
use App\Models\Files;
use App\Models\Posts;
use Spatie\Permission\Models\Role;
use App\Models\Types;
use App\Models\Silder;
use App\Models\Images;
use Auth;



class Helpers{
    public static function getImgaeSlider($silder){
        $index=0;
        $return='';
        foreach ($silder as $sl){
            if($index==0){
                if($sl->status == 1)
                {
                    $image=Images::find($sl->idImg);
                    $return .= '<div class="carousel-item active"><a href="'.$sl->slug.'"><div style="background-image: url(/storage/'.$image->name.');" class="d-block w-100 backgroudslider"></div></a></div>';
                    $index++;
                }
            }
            else{
                if($sl->status == 1){
                    $image=Images::find($sl->idImg);
                    $return .= '<div class="carousel-item"><a href="'.$sl->slug.'"><div style="background-image: url(/storage/'.$image->name.');" class="d-block w-100 backgroudslider"></div></a></div>';
                    $index++;
                }
            }
        }
        return $return;
    }
    public static function get_slider(){
        $silder= Silder::all();
       return self::getImgaeSlider($silder);
    } 

    public static function get_setting($name)
    {
        $setting = Settings::where('name', $name)->first();
        if($setting)
            return $setting->value;
        return null;
    }
    public static function getTreeFull($cats, $idParent, $count, $selected){
        $flag = '';
        $return = '';
        for ($i=0; $i < $count; $i++) {
            $flag .= '- ';
        }
        foreach ($cats as $cat) {
            if($cat->idParent == $idParent) {
                $thisCat = Category::find($selected); // Danh mục đang xét
                if($cat->id == (isset($thisCat->id) ? $thisCat->id : 0 ) ) {
                    $select = 'selected';
                    $return .= '<option value="'.$cat->id.'" '.$select.'>'.$flag.''.$cat->name.'</option>'.self::getTreeFull($cats, $cat->id, ($count + 1), $selected);
                } else {
                    $return .= '<option value="'.$cat->id.'">'.$flag.''.$cat->name.'</option>'.self::getTreeFull($cats, $cat->id, ($count + 1), $selected);
                }
            }
        }
        return $return;
    }
    public static function catTreeFull($selected = 0) {
        $cats = Category::where('id', '>', 0)->get();
        return self::getTreeFull($cats, 0, 0, $selected);
    }



    public static function table_cat($cats, $idParent, $count) {
        $flag = '';
        $return = '';
        for ($i=0; $i < $count; $i++) {
            $flag .= '— ';
        }
        $index=0;
        foreach ($cats as $cat) {
            if($cat->idParent == $idParent) {
                $start = '<tr>';
                $web = '<a target="_blank" class="ml-1 badge badge-primary badge-hidden" href="/'.Helpers::get_setting('urlcat').'/'.$cat->slug.'">Xem</a>';
                $loop = '<th scope="row">'. ($index = $index+ 1) .'</th>';
                $name = '<th scope="row"><a href="/quanly/danhmuc/show/'.$cat->id.'">'.$flag.$cat->name.'</a><a href="/quanly/danhmuc/edit/'.$cat->id.'" class="ml-1 badge badge-success badge-hidden">Chỉnh sửa</a>'.$web.'</th>';
                $sopost = '<td><span data-toggle="tooltip" title="Có '.self::count_post($cat->id).' Bài viết trong Danh mục '.$cat->name.'">'.self::count_post($cat->id).'</span></td>';
                $sofile = '<td><span data-toggle="tooltip" title="Có '.self::count_file_in_cat($cat->id).' Tài liệu trong Danh mục '.$cat->name.'">'.self::count_file_in_cat($cat->id).'</span></td>';
                $status = '<td>'.($cat->status == 1 ? '<span class="text-success">Công khai</span>' : '<span class="text-danger">Đang ẩn</span>').'</td>';
                $end = '</tr>';
                $return .= $start.$loop.$name.$sopost.$sofile.$status.$end.self::table_cat($cats, $cat->id, ($count + 1));
            }
        }
        return $return;
    }
    public static function get_table_cat() {
        $cats = Category::where('id', '>', 0)->get();
        return self::table_cat($cats, 0, 0);
    }

    public static function table_silder($srs) {
        $return = '';
        $index=0;
        foreach ($srs as $sr) {
            $start = '<tr>';
            $web = '<a target="_blank" class="ml-1 badge badge-primary badge-hidden" href="/'.$sr->slug.'">Xem</a>';
            $loop = '<th scope="row">'. ($index = $index+ 1) .'</th>';
            $name = '<th scope="row"><a href="/quanly/slider/edit/'.$sr->id.'">'.$sr->name.'</a><a href="/quanly/slider/edit/'.$sr->id.'" class="ml-1 badge badge-success badge-hidden">Chỉnh sửa</a>'.$web.'</th>';
            $status = '<td>'.($sr->status == 1 ? '<span class="text-success">Công khai</span>' : '<span class="text-danger">Đang ẩn</span>').'</td>';
            $end = '</tr>';
            $return .= $start.$loop.$name.$status.$end;
        }
        return $return;
    }

    public static function get_table_silder() {
        $srs = Silder::where('id', '>', 0)->get();
        return self::table_silder($srs);
    }
   
    /*
    *   Count
    */
    public static function count_post($idCat = null) {
        if($idCat == null) {
            return count(Posts::all());
        } else {
            return count(Posts::where('idCat', $idCat)->get());
        }
    }
    public static function count_file($idPost = null, $uid = null) {
        if($idPost == null) {
            return count(Files::all());
        } else {
            if($uid == null) {
                $file = Files::where('idPost', $idPost)->get();
                if($file) return count($file);
                else return 0;
            } else {
                $file = Files::where('idPost', $idPost)->where('idUser', $uid)->get();
                if($file) return count();
                else return 0;
            }
        }
    }
    public static function count_file_in_cat($idCat = null, $uid = null) {
        if($idCat == null) {
            return count(Files::all());
        } else {
            $count = 0;
            $posts = Posts::where('idCat', $idCat)->get();
            if($uid == null) {
                foreach($posts as $post) {
                    $f = Files::where('idPost', $post->id)->get();
                    if($f) $count += count($f);
                }
            } else {
                foreach($posts as $post) {
                    $f = Files::where('idPost', $post->id)->where('idUser', $uid)->get();
                    if($f) $count += count();
                }
            }
            return $count;
        }
    }
    public static function getTree($cats, $idParent, $count, $selected){
        $flag = '';
        $return = '';
        for ($i=0; $i < $count; $i++) {
            $flag .= '- ';
        }
        foreach ($cats as $cat) {
            if($cat->idParent == $idParent) {
                $thisCat = Category::find($selected); // Danh mục đang xét
                if($cat->id == (isset($thisCat->idParent) ? $thisCat->idParent : 0 ) ) { // Nếu danh mục này là cha danh mục đang xét
                    $select = 'selected';
                    $return .= '<option value="'.$cat->id.'" '.$select.'>'.$flag.''.$cat->name.'</option>'.self::getTree($cats, $cat->id, ($count + 1), $selected);
                } else {
                    if($cat->id != $selected) { // Ko in ra nếu danh mục này là danh mục đang xét
                        $return .= '<option value="'.$cat->id.'">'.$flag.''.$cat->name.'</option>'.self::getTree($cats, $cat->id, ($count + 1), $selected);
                    }
                }
            }
        }
        return $return;
    }
    public static function catTree($selected = 0) {
        $cats = Category::all();
        return self::getTree($cats, 0, 0, $selected);
    }
    /*
    *   GET list Role
    */
    public static function get_roles($id = NULL){
        if($id === NULL) {
            $roles = Role::all()->where('status','==','1');
            // if($roles==NULL)
            // $roles= Role::all()->where('status','==','1');
        } else {
             if($id == 0) {
                $r = new class{};
                $r->id = 0;
                $r->name = 'khach';
                // $r->display_name = "Công khai";
                $roles = $r;
            } else {
                $roles = Role::where('id', $id)->first();
            }
        }
        return $roles;
    }
    public static function check_slug($request, $cat) {
        if($request->slug == '') return json_encode(['status' => 'FALSE', 'message' => 'Đường dẫn không được bỏ trống']);
        if($cat == 'cat') {
            $return = Category::where('slug', $request->slug)->first();
        } else {
            $return = Posts::where('slug', $request->slug)->first();
        }
        if($return == NULL || (isset($request->id) && $request->id == $return['id'])) {
            if(!preg_match('/[^a-z0-9-]/',$request->slug) && $request->slug[0] != '-' && $request->slug[strlen($request->slug) - 1] != '-')
                return json_encode(['status' => 'TRUE', 'message' => '']);
            else return json_encode(['status' => 'FALSE', 'message' => 'Định dạng đường dẫn không hợp lệ']);
        }
        else return json_encode(['status' => 'FALSE', 'message' => 'Đường dẫn này bị trùng']);
    }
    public static function getTreeType($selected = 0) {
        $types = Types::all();
        $return = '';
        if(count($types) > 0) {
            foreach($types as $type) {
                $select = '';
                if($type->id == $selected) $select = 'selected';
                $return .= '<option value="'.$type->id.'" '.$select.'>'.$type->name.'</option>';
            }
        }
        return $return;
    }
    public static function getTreePost($selected = 0, $cat = null) {
        if($cat == null) {
            $posts = Posts::all();
        } else {
            $posts = Posts::where('idCat', $cat)->get();
            // dd($posts);
        }
        $return = '';
        if(count($posts) > 0) {
            foreach($posts as $post) {
                $select = '';
                if($post->id == $selected) $select = 'selected';
                $return .= '<option value="'.$post->id.'" '.$select.'>'.$post->title.'</option>';
            }
        }
        return $return;
    }
    /*
    *   Check File
    */
    public static function checkFile($filename, $filesize) {
        $size = $filesize/1024;
        $p_size = round($size, 2).'KB';
        if($size > 1024) {
            $p_size = round($size/1024, 2).'MB';
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $max_size = Helpers::get_setting('maxsizeupload');
        $r_name = '<span class="success">'.$filename.'</span>';
        $r_size = '<span class="success">'.$p_size.'</span>';
        if($name == '' || $ext == '') {
            $status = 'FALSE';
            $message = 'Tên tập tin không hợp lệ!';
            $r_name = '<span class="error">'.$filename.'</span>';
        } else {
            if($size >= $max_size*1024) {
                $status = 'FALSE';
                $message = 'Tập tin bạn tải lên quá lớn ('.$p_size.'). Kích thước tối đa là: '.$max_size.'MB';
                $r_size = '<span class="error">'.$p_size.'</span>';
            } else {
                $status = 'TRUE';
                $message = '';
            }
        }
        $result = $r_name.' | '.$r_size;
        return json_encode(['status' => $status, 'message' => $message, 'result' => $result]);
    }
    public static function createslug($str) {
        $utf8 = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
         foreach($utf8 as $ascii=>$uni) {
         	$str = preg_replace("/($uni)/i",$ascii,$str);
         }
	        $str = strtolower($str);
	        $str = preg_replace("/[^a-z0-9-]/", "-",$str);
	        $str = str_replace(array('%20', ' '), '-', $str);
	        $str = str_replace("----","-",$str);
	        $str = str_replace("---","-",$str);
	        $str = str_replace("--","-",$str);
	        $str = ltrim($str, "-");
	        $str = rtrim($str, "-");
		return $str;
    }
     /*
    * Get, Set, Unset Cookie
    */
    public static function setCookie($name, $value, $daylive = 1) {
        setcookie($name, $value, time() + (86400 * $daylive), "/");
    }
    public static function getCookie($name) {
        if(!isset($_COOKIE[$name])) {
            return null;
        } else {
            return $_COOKIE[$name];
        }
    }
    public static function unsetCookie($name) {
        if(isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            setcookie($name, null, time() - 3600, '/');
        }
    }
     /*
    *   Thông báo qua Cookie
    */
    public static function setThongBaoCookie($value) {
        self::setCookie('thongbao', $value, 0.1);
    }
    public static function showThongBaoCookie() {
        $thongbao = self::getCookie('thongbao');
        if($thongbao != null) {
            $tb = json_decode($thongbao);
            self::unsetCookie('thongbao');
            return '<div class=" toast alert-'.$tb->status.' alert-dismissible shadow toast-fixed fade show" id="placement-toast2"
            role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false" data-mdb-position="top-right"
            data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px" data-mdb-color="info"
            style="width: 350px; display: block; top: 50px; right: 17px; bottom: unset; left: unset; transform: unset;">
            <div class="toast-header">
                <strong class="me-auto">Thông báo</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">'.$tb->message.'</div>
        </div>';
        } else {
            return '';
        }
    }
    /*
    *   Thông báo mặc định
    */
    public static function showThongBao($thongbao) {
        if($thongbao != null) {
            $tb = json_decode($thongbao);
            self::unsetCookie('thongbao');
            return '<div class=" toast alert-'.$tb->status.' alert-dismissible shadow toast-fixed fade show" id="placement-toast1"
            role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false" data-mdb-position="top-right"
            data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px" data-mdb-color="info"
            style="width: 350px; display: block; top: 50px; right: 17px; bottom: unset; left: unset; transform: unset;">
            <div class="toast-header">
                <strong class="me-auto">Thông báo</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">'.$tb->message.'</div>
        </div>';
        } else {
            return '';
        }
    }
     /*
    *   Get Info File
    */
    public static function getInfoFile($id) {
        $file = Files::find($id);
        $status = 'FALSE';
        $message = $result = '';
        if($file) {
            $fileDrive = json_decode($file->info);
            if($file) {
                $status = 'TRUE';
                $size = $fileDrive->size/1024;
                $p_size = round($size, 2).'KB';
                if($size > 1024) {
                    $p_size = round($size/1024, 2).'MB';
                }
                $message = '<span class="success">'.$p_size.'</span> | <span class="success">'.$fileDrive->filename.'.'.$fileDrive->extension.'</span>';
                $result = $file->info;
            }
        }
        return json_encode(['status'=>$status, 'message'=>$message, 'result'=>$result]);
    }
    /*
    *   Breadcrumb
    */
    public static function BreadcrumbCat($id , $active = true) {
        $it = Category::find($id);
        $parent = $it->parent;
        $return = '';
        if($active) {
            $return = '<li class="breadcrumb-item active">'.$it->name.'</li>'.$return;
        } else {
            $return = '<li class="breadcrumb-item"><a href="/'.Helpers::get_setting('urlcat').'/'.$it->slug.'" title="'.$it->name.'">'.$it->name.'</a></li>'.$return;
        }
        if($parent && $parent->id != 0) {
            $return = self::BreadcrumbCat($parent->id, false).$return;
        }
        return $return;
    }
    public static function GetBreadcrumbCat($id)
    {
        return '<ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="/" title="Trang Chủ"><i class="fas fa-home"></i></a></li>'.self::BreadcrumbCat($id).'</ol>';
    }
    public static function GetBreadcrumbPost($id)
    {
        $it = Posts::find($id);
        return '<ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="/" title="Trang Chủ"><i class="fas fa-home"></i></a></li>'.self::BreadcrumbCat($it->idCat, false).'<li class="breadcrumb-item active">'.$it->title.'</li></ol>';
    }
     /*
    *   Return @name-icon Font Awesome 5
    *   <i class="fas fa-@name-icon"></i>
    */
    public static function getFA($ext) {
        switch ($ext) {
            case 'doc':
            case 'docx':
                $icon = 'file-word';
                break;
            case 'ppt':
            case 'pptx':
                $icon = 'file-powerpoint';
                break;
            case 'xls':
            case 'xlsx':
                $icon = 'file-excel';
                break;
            case 'pdf':
                $icon = 'file-pdf';
                break;
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'tiff':
            case 'bmp':
                $icon = 'file-image';
                break;
            case 'mp4':
            case '3gp':
            case 'avi':
            case 'm4v':
            case 'mov':
            case 'wmv':
            case 'wav':
                $icon = 'file-video';
                break;
            case 'zip':
            case 'rar':
            case '7z':
                $icon = 'file-archive';
                break;
            case 'txt':
                $icon = 'file-alt';
                break;
            default:
                $icon = 'file';
                break;
        }
        return $icon;
    }
    /*
    *   Input @byte
    *   Return @size KB or MB
    *   Convert size
    */
    public static function getSize($kb) {
        $size = $kb/1024;
        $return = round($size, 2).'KB';
        if($size > 1024) {
            $return = round($size/1024, 2).'MB';
        }
        return $return;
    }
     /*
    * Check Permition Down FILE
    */
    public static function check_download_file($id)
    {
        $file = Files::find($id);
        if($file) {
            $roles = json_decode($file->role);
            foreach($roles as $role) {
                if($role == 0) return TRUE;
                if(!Auth::guest()) {
                    if(Auth::user()->hasRole('moderator')) {
                        return TRUE;
                    } elseif(Auth::user()->hasRole($role)) {
                        return TRUE;
                    }
                }
            }
        } else {
            return FALSE;
        }
        return FALSE;
    }
}

?>
