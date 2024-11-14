    <?php
    class SanphamModel
    {
        private $pdo;
    
        public function __construct()
        {
            $this->pdo = connectDB(); // Giả sử hàm connectDB() đã được định nghĩa bên ngoài
        }
    
        // Lấy tất cả sản phẩm
        public function getAll()
        {
            try {
                $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc
                FROM san_phams 
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Lỗi kết nối CSDL: " . $e->getMessage();
                return []; // Trả về mảng rỗng nếu có lỗi
            }
        }
        public function searchByName($searchTerm)
{
    try {
        // Dùng LIKE để tìm kiếm tên sản phẩm với ký tự đặc biệt
        $stmt = $this->pdo->prepare("SELECT * FROM san_phams WHERE ten_san_pham LIKE :search");
        $stmt->execute(['search' => '%' . $searchTerm . '%']);
        
        // Lấy tất cả kết quả từ truy vấn
        $Sanphams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $Sanphams;
    } catch (PDOException $e) {
        // Thông báo lỗi chi tiết
        echo "Lỗi kết nối CSDL: " . $e->getMessage();
        return [];  // Trả về mảng rỗng nếu có lỗi
    }
}

    
        // Lấy sản phẩm theo ID
        public function getById($id)
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM san_phams WHERE id = :id");
                $stmt->execute(['id' => $id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Lỗi khi lấy dữ liệu sản phẩm: " . $e->getMessage();
                return false;
            }
        }
        //list anh san pham
        public function getlistAnh($id)
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM san_pham_images WHERE san_pham_id = :id");
                $stmt->execute(['id' => $id]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Lỗi khi lấy dữ liệu sản phẩm: " . $e->getMessage();
                return false;
            }
        }
        
    
        // Thêm sản phẩm mới
        public function add($danh_muc_id, $ten_san_pham, $mo_ta, $gia_ban, $gia_nhap, $gia_khuyen_mai, $so_luong, $hinh_anh, $trang_thai, $ngay_nhap, $luot_xem) {
            try {
                // Chuẩn bị câu lệnh SQL để thêm sản phẩm
                $sql = "INSERT INTO san_phams (danh_muc_id, ten_san_pham, mo_ta, gia_ban, gia_nhap, gia_khuyen_mai, so_luong, hinh_anh, trang_thai, ngay_nhap, luot_xem)
                        VALUES (:danh_muc_id, :ten_san_pham, :mo_ta, :gia_ban, :gia_nhap, :gia_khuyen_mai, :so_luong, :hinh_anh, :trang_thai, :ngay_nhap, :luot_xem)";
        
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':danh_muc_id' => $danh_muc_id,
                    ':ten_san_pham' => $ten_san_pham,
                    ':mo_ta' => $mo_ta,
                    ':gia_ban' => $gia_ban,
                    ':gia_nhap' => $gia_nhap,
                    ':gia_khuyen_mai' => $gia_khuyen_mai,
                    ':so_luong' => $so_luong,
                    ':hinh_anh' => $hinh_anh,
                    ':trang_thai' => $trang_thai,
                    ':ngay_nhap' => $ngay_nhap,
                    ':luot_xem' => $luot_xem
                ]);
        
                // Lấy ID của sản phẩm vừa thêm
                return $this->pdo->lastInsertId(); // Trả về ID của sản phẩm vừa thêm
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
                return false;
            }
        }
        
        public function addAlbum($san_pham_id, $image_paths) {
            try {
                foreach ($image_paths as $path) {
                    $sql = "INSERT INTO san_pham_images (san_pham_id, image_path) VALUES (:san_pham_id, :image_path)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':san_pham_id' => $san_pham_id,
                        ':image_path' => $path
                    ]);
                }
                return true;
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
                return false;
            }
        }
        
        public function updateAlbum($san_pham_id, $image_paths) {
            try {
                // Xóa album ảnh cũ trước khi thêm ảnh mới
                $sql_delete = "DELETE FROM san_pham_images WHERE san_pham_id = :san_pham_id";
                $stmt_delete = $this->pdo->prepare($sql_delete);
                $stmt_delete->execute([':san_pham_id' => $san_pham_id]);
        
                // Thêm ảnh mới vào album
                $this->addAlbum($san_pham_id, $image_paths);
        
                return true;
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
                return false;
            }
        }
        // Xóa album cũ trước khi thêm ảnh mới
public function deleteAlbum($san_pham_id) {
    try {
        $sql = "DELETE FROM san_pham_images WHERE san_pham_id = :san_pham_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['san_pham_id' => $san_pham_id]);
    } catch (PDOException $e) {
        echo "Lỗi khi xóa album: " . $e->getMessage();
    }
}

        // Cập nhật sản phẩm theo ID
        public function update($id, $data)
        {
            try {
                $stmt = $this->pdo->prepare("UPDATE san_phams 
                                                SET danh_muc_id = :danh_muc_id, ten_san_pham = :ten_san_pham, mo_ta = :mo_ta, gia_ban = :gia_ban, gia_nhap = :gia_nhap, 
                                                    gia_khuyen_mai = :gia_khuyen_mai, so_luong = :so_luong, hinh_anh = :hinh_anh, trang_thai = :trang_thai, 
                                                    ngay_nhap = :ngay_nhap, luot_xem = :luot_xem, mo_ta_chi_tiet = :mo_ta_chi_tiet 
                                                WHERE id = :id");
                return $stmt->execute([
                    'id' => $id,
                    'danh_muc_id' => $data['danh_muc_id'],
                    'ten_san_pham' => $data['ten_san_pham'],
                    'mo_ta' => $data['mo_ta'],
                    'gia_ban' => $data['gia_ban'],
                    'gia_nhap' => $data['gia_nhap'],
                    'gia_khuyen_mai' => $data['gia_khuyen_mai'],
                    'so_luong' => $data['so_luong'],
                    'hinh_anh' => $data['hinh_anh'],
                    'trang_thai' => $data['trang_thai'],
                    'ngay_nhap' => $data['ngay_nhap'],
                    'luot_xem' => $data['luot_xem'],
                    'mo_ta_chi_tiet' => $data['mo_ta_chi_tiet']
                ]);
            } catch (PDOException $e) {
                echo "Lỗi khi cập nhật sản phẩm: " . $e->getMessage();
                return false;
            }
        }
    
        // Xóa sản phẩm theo ID
        public function delete($id)
    {
        try {
            // Bắt đầu transaction
            $this->pdo->beginTransaction();
    
            // Xóa bản ghi từ bảng san_phams
            $stmt = $this->pdo->prepare("DELETE FROM san_phams WHERE id = :id");
            $stmt->execute(['id' => $id]);
    
            // Cập nhật lại ID cho các bản ghi còn lại (ID > id bị xóa sẽ giảm đi 1)
            $stmt = $this->pdo->prepare("UPDATE san_phams SET id = id - 1 WHERE id > :id");
            $stmt->execute(['id' => $id]);
    
            // Cập nhật lại giá trị AUTO_INCREMENT (để tiếp tục từ ID lớn nhất hiện có)
            $stmt = $this->pdo->query("SELECT MAX(id) AS max_id FROM san_phams");
            $row = $stmt->fetch();
            $max_id = $row['max_id'];
    
            // Đặt lại giá trị AUTO_INCREMENT
            if ($max_id !== null) {
                $this->pdo->query("ALTER TABLE san_phams AUTO_INCREMENT = " . ($max_id + 1));
            } else {
                $this->pdo->query("ALTER TABLE san_phams AUTO_INCREMENT = 1");
            }
    
            // Commit transaction nếu mọi thứ thành công
            $this->pdo->commit();
    
            return true;
        } catch (PDOException $e) {
            // Nếu có lỗi, rollback transaction
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
            return false;
        }
    }
    
    
    
        
        public function getDanhMucs()
    {
        $sql = "SELECT * FROM danh_mucs WHERE trang_thai = 1"; // Chỉ lấy danh mục còn hàng
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng danh mục
    }
        
    }
    ?>