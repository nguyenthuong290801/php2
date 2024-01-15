<?php

namespace App\controllers\admin;

use Illuminate\framework\Controller;
use Illuminate\framework\Response;
use Illuminate\framework\Request;
use Illuminate\framework\factory\Model;
use Illuminate\framework\base\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Model::all('Product', 'DESC');
        $product_categorys = Model::all('ProductCategory');

        $categoryMap = [];

        foreach ($product_categorys as $product_category) {
            $categoryMap[$product_category['id']] = $product_category['category_name'];
        }

        foreach ($products as &$product) {
            if (isset($categoryMap[$product['product_category_id']])) {
                $product['product_category_id'] = $categoryMap[$product['product_category_id']];
            }
        }

        $this->setLayout('admin');

        echo $this->view('pages/admin/product-list', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isPost()) {
            if (
                Validator::required($request->getData()['name'])
                || Validator::required($request->getData()['price'])
                || Validator::required($request->getData()['qty'])
            ) {
                $_SESSION['create-product'] = 'Thêm sản phẩm thât bại - Còn trường chưa điền vào';
            } elseif (
                Validator::notNumeric($request->getData()['price'])
            ) {
                $_SESSION['create-product'] = 'Thêm sản phẩm thât bại - Trường giá không phải là số';
            } elseif (
                Validator::notNumeric($request->getData()['qty'])
            ) {
                $_SESSION['create-product'] = 'Thêm sản phẩm thât bại - Trường tồn kho không phải là số';
            } elseif (
                Validator::naturalNumeric($request->getData()['price'])
            ) {
                $_SESSION['create-product'] = 'Thêm sản phẩm thât bại - Trường giá không phải là số nguyên';
            } elseif (
                Validator::naturalNumeric($request->getData()['qty'])
            ) {
                $_SESSION['create-product'] = 'Thêm sản phẩm thât bại - Trường tồn kho phải là số nguyên';
            } else {
                $lastInsertId = Model::create('Product', $request->getData());

                if ($lastInsertId) {
                    $_SESSION['create-product'] = 'Thêm sản phẩm thành công';
                } else {
                    $_SESSION['create-product'] = 'Thêm sản phẩm thât bại';
                }
            }

            $this->setLayout('admin');

            echo $this->view('pages/admin/product-new');
        }

        unset($_SESSION['create-product']);
        
        $this->setLayout('admin');

        echo $this->view('pages/admin/product-new');
    }

    public function destroy(Request $request)
    {
        if ($request->isPost()) {
            $productId = $request->getParam();

            $rowCount = Model::softDelete('Product', $productId);

            if ($rowCount > 0) {

                $_SESSION['delete-product'] = 'Xóa sản phẩm thành công';

                $this->index();
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->isPost()) {
            if (
                Validator::required($request->getData()['name'])
                || Validator::required($request->getData()['price'])
                || Validator::required($request->getData()['qty'])
            ) {
                $_SESSION['edit-product'] = 'Thêm sản phẩm thât bại - Còn trường chưa điền vào';
            } elseif (
                Validator::notNumeric($request->getData()['price'])
            ) {
                $_SESSION['edit-product'] = 'Thêm sản phẩm thât bại - Trường giá không phải là số';
            } elseif (
                Validator::notNumeric($request->getData()['qty'])
            ) {
                $_SESSION['edit-product'] = 'Thêm sản phẩm thât bại - Trường tồn kho không phải là số';
            } elseif (
                Validator::naturalNumeric($request->getData()['price'])
            ) {
                $_SESSION['edit-product'] = 'Thêm sản phẩm thât bại - Trường giá phải là số nguyên';
            } elseif (
                Validator::naturalNumeric($request->getData()['qty'])
            ) {
                $_SESSION['edit-product'] = 'Thêm sản phẩm thât bại - Trường tồn kho phải là số nguyên';
            } else {
                $productId = $request->getParam();

                $row = Model::update('Product', $productId, $request->getData());

                if ($row) {
                    $_SESSION['edit-product'] = 'Sửa sản phẩm thành công';
                } else {
                    $_SESSION['edit-product'] = 'Sửa sản phẩm thât bại';
                }
            }

            $this->index();
        }
    }
}
