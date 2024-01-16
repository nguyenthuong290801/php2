<section class="intro mt-4">
    <h2>Danh sách lô hàng</h2>
</section>
<section class="intro mt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 p-0">
                <div class="card shadow-2-strong">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã lô hàng</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Tồn kho</th>
                                        <th scope="col">Loại</th>
                                        <th scope="col">Ngày nhập</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 0;
                                    foreach ($products as $product) :
                                        $counter++;
                                    ?>
                                        <tr>
                                            <td><?= $product['name'] ?? '' ?></td>
                                            <td><?= number_format($product['price'] ?? 0, 0, ',', '.') ?> VND</td>
                                            <td><?= number_format($product['qty'] ?? 0, 0, ',', '.') ?></td>
                                            <td><?= $product['product_category_id'] ?? '' ?></td>
                                            <td><?= date('d/m/Y', strtotime($product['created_at'])) ?? '' ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#editModal<?= $counter ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#destroyModal<?= $counter ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#printModal<?= $counter ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path fill="#ffffff" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Destroy Modal -->
                                        <div class="modal fade" id="destroyModal<?= $counter ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <form action="/admin/product/destroy/<?= $product['id'] ?? '0' ?>" method="post">
                                                            <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Print Modal -->
                                        <div class="modal fade" id="printModal<?= $counter ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn in bill</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <form action="/admin/product/PDF/<?= $product['id'] ?? '0' ?>" method="post">
                                                            <button type="submit" class="btn btn-danger">Xác nhận in bill</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $counter ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <section class="mt-4">
                                                            <?php if (isset($_SESSION['edit-product'])) : ?>
                                                                <div class="text-light bg-primary rounded p-2"><?= $_SESSION['edit-product'] ?? '' ?></div>
                                                            <?php endif ?>
                                                        </section>
                                                        <section class="mt-4">
                                                            <form action="/admin/product/edit/<?= $product['id'] ?? '' ?>" method="post">
                                                                <div class="mb-3">
                                                                    <label for="productName" class="form-label">Tên sản phẩm</label>
                                                                    <input type="text" class="form-control" id="productName" name="name" value="<?= $product['name'] ?? '' ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="productPrice" class="form-label">Giá sản phẩm</label>
                                                                    <input type="text" class="form-control" id="productPrice" name="price" value="<?= $product['price'] ?? '' ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="productInventory" class="form-label">Tồn kho</label>
                                                                    <input type="text" class="form-control" id="productInventory" name="qty" value="<?= $product['qty'] ?? '' ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="productCategory" class="form-label">Danh mục sản phẩm</label>
                                                                    <select class="form-select" id="productCategory" name="product_category_id">
                                                                        <option value="1" <?= ($product['product_category_id'] ?? '') == '1' ? 'selected' : '' ?>>Áo</option>
                                                                        <option value="2" <?= ($product['product_category_id'] ?? '') == '2' ? 'selected' : '' ?>>Quần</option>
                                                                        <option value="3" <?= ($product['product_category_id'] ?? '') == '3' ? 'selected' : '' ?>>Áo khoác</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary mt-4">Sửa sản phẩm</button>
                                                            </form>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>