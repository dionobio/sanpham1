<?php
require_once "./models/SanphamModel.php";

class SanphamController
{
    private $model;

        public function __construct()
        {
            $this->model = new SanphamModel();
        }

    // Hiển thị danh sách sản phẩm
    public function showSanphamList()
{
    $searchTerm = $_GET['search'] ?? ''; 
    if ($searchTerm) {
        $Sanphams = $this->model->searchByName($searchTerm);
    } else {
        $Sanphams = $this->model->getAll();
    }
    include 'views/sanpham/sanpham_list.php';
}



    // Hiển thị form thêm sản phẩm
    public function showAddSanphamForm()
    {
        $danhMucs = $this->model->getDanhMucs(); 
        require_once 'views/sanpham/sanpham_add.php'; 
    }

    // Xử lý thêm sản phẩm mới
    public function addSanpham() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $danh_muc_id = $_POST['danh_muc_id'] ?? null;
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';
            $gia_ban = $_POST['gia_ban'] ?? 0;
            $gia_nhap = $_POST['gia_nhap'] ?? 0;
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? 0;
            $so_luong = $_POST['so_luong'] ?? 0;
            $hinh_anh = $_FILES['hinh_anh']['name'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? 'active';
            $ngay_nhap = $_POST['ngay_nhap'] ?? date('Y-m-d');
            $luot_xem = 0;
            $img_array = $_FILES['img_array'] ?? [];
    
            // Xử lý upload ảnh chính
            $file_thumb = uploadFile($_FILES['hinh_anh'], './uploads/');
            if ($file_thumb !== $hinh_anh) {
                // Lỗi tải tệp
                $errors['hinh_anh'] = $file_thumb;
            } else {
                // Nếu upload thành công, lưu tên tệp vào biến
                $hinh_anh = $file_thumb;
            }
    
            $errors = [];
    
            // Kiểm tra các trường bắt buộc
            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'Danh mục không được để trống!';
            }
            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống!';
            }
            if (empty($mo_ta)) {
                $errors['mo_ta'] = 'Mô tả không được để trống!';
            }
            if (empty($gia_ban) || $gia_ban <= 0) {
                $errors['gia_ban'] = 'Giá bán phải lớn hơn 0!';
            }
            if (empty($gia_nhap) || $gia_nhap <= 0) {
                $errors['gia_nhap'] = 'Giá nhập phải lớn hơn 0!';
            }
            if (empty($so_luong) || $so_luong <= 0) {
                $errors['so_luong'] = 'Số lượng phải lớn hơn 0!';
            }
            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'Ngày nhập không được để trống!';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thái không được để trống!';
            }
    
            // Kiểm tra nếu không có lỗi
            if (empty($errors)) {
                // Gọi phương thức add với các tham số
                $san_pham_id = $this->model->add($danh_muc_id, $ten_san_pham, $mo_ta, $gia_ban, $gia_nhap, $gia_khuyen_mai, $so_luong, $hinh_anh, $trang_thai, $ngay_nhap, $luot_xem);
    
                // Nếu thêm sản phẩm thành công, lấy ID sản phẩm vừa thêm
                if ($san_pham_id) {
                    // Xử lý thêm album ảnh
                    if (!empty($img_array['name'])) {
                        foreach ($img_array['name'] as $key => $value) {
                            $file = [
                                'name' => $img_array['name'][$key],
                                'type' => $img_array['type'][$key],
                                'tmp_name' => $img_array['tmp_name'][$key],
                                'error' => $img_array['error'][$key],
                                'size' => $img_array['size'][$key]
                            ];
                            $image_paths = uploadFile($file, 'uploads/');
                            $this->model->addAlbum($san_pham_id, $image_paths);

                        }
                        // Gọi phương thức addAlbum để thêm các ảnh vào album của sản phẩm
                    }
    
                    // Chuyển hướng về trang danh sách sản phẩm nếu thành công
                    header("Location: index.php?act=list-sanpham");
                    exit();
                } else {
                    // Nếu không thành công, hiển thị thông báo lỗi
                    $errors['database'] = 'Có lỗi khi thêm sản phẩm vào cơ sở dữ liệu.';
                }
            }
    
            // Nếu có lỗi, trả về trang thêm sản phẩm và hiển thị lỗi
            require_once('./admin/views/sanpham/sanpham_add.php');
        } else {
            echo "Yêu cầu không hợp lệ!";
        }
    }
    
    
    
    // Hiển thị form chỉnh sửa sản phẩm
    public function showEditSanphamForm()
{
    $danhMucs = $this->model->getDanhMucs(); 
    $id = $_GET['id'] ?? null;

    if ($id && is_numeric($id)) {
        $Sanpham = $this->model->getById($id);
        $listSanpham = $this->model->getlistAnh($id); // Lấy danh sách ảnh album

        if ($Sanpham) {
            require "views/sanpham/sanpham_edit.php";
        } else {
            echo "Không tìm thấy sản phẩm với ID: $id";
        }
    } else {
        echo "ID không hợp lệ!";
    }
}


    // Cập nhật sản phẩm
    public function updateSanpham() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $id = $_POST['id'] ?? null;
            $danh_muc_id = $_POST['danh_muc_id'] ?? null;
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';
            $gia_ban = $_POST['gia_ban'] ?? 0;
            $gia_nhap = $_POST['gia_nhap'] ?? 0;
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? 0;
            $so_luong = $_POST['so_luong'] ?? 0;
            $hinh_anh = $_FILES['hinh_anh']['name'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? 'active';
            $ngay_nhap = $_POST['ngay_nhap'] ?? date('Y-m-d');
            $luot_xem = $_POST['luot_xem'] ?? 0;
            $mo_ta_chi_tiet = $_POST['mo_ta_chi_tiet'] ?? '';
            $img_array = $_FILES['img_array'] ?? [];
        
            // Xử lý upload ảnh chính (ảnh đại diện)
            $file_thumb = uploadFile($_FILES['hinh_anh'], './uploads/');
            if ($file_thumb !== $hinh_anh) {
                $errors['hinh_anh'] = $file_thumb;
            } else {
                $hinh_anh = $file_thumb;
            }
        
            $errors = [];
        
            // Kiểm tra các trường bắt buộc
            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'Danh mục không được để trống!';
            }
            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'Tên sản phẩm không được để trống!';
            }
            if (empty($mo_ta)) {
                $errors['mo_ta'] = 'Mô tả không được để trống!';
            }
            if (empty($gia_ban) || $gia_ban <= 0) {
                $errors['gia_ban'] = 'Giá bán phải lớn hơn 0!';
            }
            if (empty($gia_nhap) || $gia_nhap <= 0) {
                $errors['gia_nhap'] = 'Giá nhập phải lớn hơn 0!';
            }
            if (empty($so_luong) || $so_luong <= 0) {
                $errors['so_luong'] = 'Số lượng phải lớn hơn 0!';
            }
            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'Ngày nhập không được để trống!';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Trạng thái không được để trống!';
            }
        
            // Kiểm tra nếu không có lỗi
            if (empty($errors)) {
                // Lấy mảng dữ liệu để truyền vào phương thức update
                $data = [
                    'danh_muc_id' => $danh_muc_id,
                    'ten_san_pham' => $ten_san_pham,
                    'mo_ta' => $mo_ta,
                    'gia_ban' => $gia_ban,
                    'gia_nhap' => $gia_nhap,
                    'gia_khuyen_mai' => $gia_khuyen_mai,
                    'so_luong' => $so_luong,
                    'hinh_anh' => $hinh_anh,
                    'trang_thai' => $trang_thai,
                    'ngay_nhap' => $ngay_nhap,
                    'luot_xem' => $luot_xem,
                    'mo_ta_chi_tiet' => $mo_ta_chi_tiet
                ];
        
                // Gọi phương thức update với mảng dữ liệu
                $result = $this->model->update($id, $data);
        
                // Kiểm tra nếu cập nhật thành công
                if ($result) {
                    // Xử lý album ảnh
                    if (!empty($img_array['name'])) {
                        // Xóa tất cả ảnh cũ
                        $this->model->deleteAlbum($id);
    
                        // Upload các ảnh mới vào mảng
                        $image_paths = [];
                        foreach ($img_array['name'] as $key => $value) {
                            $file = [
                                'name' => $img_array['name'][$key],
                                'type' => $img_array['type'][$key],
                                'tmp_name' => $img_array['tmp_name'][$key],
                                'error' => $img_array['error'][$key],
                                'size' => $img_array['size'][$key]
                            ];
                            $path = uploadFile($file, './uploads/');
                            $image_paths[] = $path; // Thêm đường dẫn ảnh vào mảng
                        }
        
                        // Gọi phương thức updateAlbum để cập nhật album ảnh
                        $this->model->updateAlbum($id, $image_paths);
                    }
        
                    // Chuyển hướng về trang danh sách sản phẩm nếu thành công
                    header("Location: index.php?act=list-sanpham");
                    exit();
                } else {
                    // Nếu không thành công, hiển thị thông báo lỗi
                    $errors['database'] = 'Có lỗi khi cập nhật sản phẩm trong cơ sở dữ liệu.';
                }
            }
        
            // Nếu có lỗi, trả về trang sửa sản phẩm và hiển thị lỗi
            require_once('./admin/views/sanpham/sanpham_edit.php');
        } else {
            echo "Yêu cầu không hợp lệ!";
        }
    }
    
    // Xóa sản phẩm
    public function deleteSanpham($id)
{
    if ($id && is_numeric($id)) {  // Kiểm tra ID hợp lệ
        $this->model->delete($id);
        header("Location: index.php?act=list-sanpham");
    } else {
        echo "ID không hợp lệ!";
    }
}
    

}