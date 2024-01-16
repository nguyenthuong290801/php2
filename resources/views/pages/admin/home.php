<section class="intro mt-4">
    <h4 class="mt-2 text-secondary">Quản lý tồn kho</h4>
    <div class="row">
        <div class="col-4">
            <div class="bg-dark text-success p-3 rounded text-center">
                <h5>Tổng số lượng tồn kho</h5>
                <h6 class="text-light"><?= number_format($qty['SUM(qty)'] ?? 0, 0, ',', '.') ?></h6>
            </div>
        </div>
    </div>
    <h4 class="mt-4 text-secondary">Quản lý tồn kho theo danh mục</h4>
    <div class="row">
        <?php $check = [] ?>
        <?php if ($qtyCategory) : ?>
            <?php foreach ($categorys as $category) : ?>
                <div class="col-4">
                    <div class="bg-dark p-3 text-success rounded text-center">
                        <h5>Tổng số lượng tồn kho <?= $category['category_name'] ?></h5>
                        <?php foreach ($qtyCategory as $qty) : ?>
                            <?php if ($qty['product_category_id'] == $category['id'] && !in_array($qty['product_category_id'], $check)) : ?>
                                <h6 class="text-light"><?= number_format($qty['SUM(qty)'] ?? 0, 0, ',', '.') ?></h6>
                                <?php $check[] = $qty['product_category_id'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>