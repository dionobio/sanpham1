<!doctype html>
<html lang="vi" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="UTF-8" />
    <title>Danh sách người dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Quản lý người dùng" name="description" />
    <meta content="Your Company" name="author" />
    <!-- CSS -->
    <?php require_once "views/layouts/libs_css.php"; ?>
</head>

<body>
    <div id="layout-wrapper">
        <!-- HEADER -->
        <?php
            require_once "views/layouts/header.php";
            require_once "views/layouts/siderbar.php";
        ?>
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Quản Lý Sản Phẩm</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Sản Phẩm</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Danh sách sản phẩm</h4>
                                    <a href="index.php?act=add-sanpham" class="btn btn-soft-success"><i
                                            class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm mới</a>
                                </div>
                                <form method="GET">
                                <input type="hidden" name="act" value="list-sanpham" />

                                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..."
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                                    <button type="submit">Tìm kiếm</button>
                                </form>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-nowrap align-middle mb-0">
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên Sản Phẩm</th>
                                                <th>Danh Mục</th>
                                                <th>Hình Ảnh</th>
                                                <th>Giá Bán</th>
                                                <th>Số Lượng</th>
                                                <th>Trạng Thái</th>
                                                <th>Hành Động</th>
                                            </tr>
                                            <?php if (isset($Sanphams) && count($Sanphams) > 0) : ?>
                                            <?php foreach ($Sanphams as $Sanpham) : ?>
                                            <tr>
                                                <td><?= $Sanpham['id'] ?></td>
                                                <td><?= htmlspecialchars($Sanpham['ten_san_pham']) ?></td>
                                                <td><?= htmlspecialchars($Sanpham['danh_muc_id']) ?></td>
                                                <td><img src="uploads/<?= htmlspecialchars($Sanpham['hinh_anh']) ?>"
                                                        alt="Hình sản phẩm" width="100" height="50"></td>
                                                <td><?= number_format($Sanpham['gia_ban']) ?></td>
                                                <td><?= $Sanpham['so_luong'] ?></td>
                                                <td class="btn btn-success"><?= $Sanpham['trang_thai'] ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                                                        data-bs-target="#viewModal-<?= $Sanpham['id'] ?>">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="index.php?act=edit-sanpham&id=<?= $Sanpham['id'] ?>"
                                                        class="btn btn-warning btn-sm me-1">Sửa</a>
                                                    <a href="index.php?act=delete-sanpham&id=<?= $Sanpham['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="viewModal-<?= $Sanpham['id'] ?>" tabindex="-1"
                                                aria-labelledby="viewModalLabel-<?= $Sanpham['id'] ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"
                                                                id="viewModalLabel-<?= $Sanpham['id'] ?>">Chi Tiết Sản
                                                                Phẩm</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Left Section - Image and Basic Info -->
                                                                <div class="col-md-4">
                                                                    <img src="uploads/<?= htmlspecialchars($Sanpham['hinh_anh']) ?>"
                                                                        alt="Hình sản phẩm"
                                                                        class="img-fluid rounded mb-3"
                                                                        style="max-height: 300px; object-fit: contain;">
                                                                </div>
                                                                <!-- Right Section - Product Details -->
                                                                <div class="col-md-8">
                                                                    <div class="mb-3">
                                                                        <h5><strong>Tên sản phẩm:</strong></h5>
                                                                        <p><?= htmlspecialchars($Sanpham['ten_san_pham']) ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <h5><strong>Mô tả:</strong></h5>
                                                                        <p><?= nl2br(htmlspecialchars($Sanpham['mo_ta'])) ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 mb-3">
                                                                            <h5><strong>Giá bán:</strong></h5>
                                                                            <p><?= number_format($Sanpham['gia_ban']) ?>
                                                                                VNĐ</p>
                                                                        </div>
                                                                        <div class="col-sm-6 mb-3">
                                                                            <h5><strong>Giá nhập:</strong></h5>
                                                                            <p><?= number_format($Sanpham['gia_nhap']) ?>
                                                                                VNĐ</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6 mb-3">
                                                                            <h5><strong>Số lượng:</strong></h5>
                                                                            <p><?= $Sanpham['so_luong'] ?></p>
                                                                        </div>
                                                                        <div class="col-sm-6 mb-3">
                                                                            <h5><strong>Trạng thái:</strong></h5>
                                                                            <span
                                                                                class="badge bg-success"><?= $Sanpham['trang_thai'] ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <h5><strong>Danh mục:</strong></h5>
                                                                        <p><?= htmlspecialchars($Sanpham['danh_muc_id']) ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php endforeach; ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            <?php endif; ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                            document.write(new Date().getFullYear())
                            </script> © Your Company.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Your Company
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <?php require_once "views/layouts/libs_js.php"; ?>
</body>

</html>