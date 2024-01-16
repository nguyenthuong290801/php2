<section class="intro mt-4">
    <h2>Thêm lô hàng</h2>
</section>
<section class="mt-4">
    <?php if (isset($_SESSION['create-product'])) : ?>
        <div class="text-light bg-primary rounded p-2"><?= $_SESSION['create-product'] ?? '' ?></div>
    <?php endif ?>
</section>
<section class="mt-4">
    <form action="/admin/product/new" method="post">
        <div class="mb-3">
            <label for="productName" class="form-label">Mã lô hàng</label>
            <input type="text" class="form-control" id="productName" name="name">
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Giá lô hàng</label>
            <input type="text" class="form-control" id="productPrice" name="price">
        </div>
        <div class="mb-3">
            <label for="productInventory" class="form-label">Tồn kho</label>
            <input type="text" class="form-control" id="productInventory" name="qty">
        </div>
        <div class="mb-3">
            <label for="productCategory" class="form-label">Danh mục lô hàng</label>
            <select class="form-select" id="productCategory" name="product_category_id">
                <option value="1">Áo</option>
                <option value="2">Quần</option>
                <option value="3">Áo khoác</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Thêm lô hàng</button>
    </form>
</section>