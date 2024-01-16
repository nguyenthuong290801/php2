<?php

namespace App\controllers\admin;

use Illuminate\framework\Controller;
use Illuminate\framework\Response;
use Illuminate\framework\Request;
use Illuminate\framework\factory\Model;
use Illuminate\framework\base\Validator;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProductController extends Controller
{
    public function index()
    {
        $products = Model::all('Products', 'DESC');
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
                $lastInsertId = Model::create('Products', $request->getData());

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

            $rowCount = Model::softDelete('Products', $productId);

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

                $row = Model::update('Products', $productId, $request->getData());

                if ($row) {
                    $_SESSION['edit-product'] = 'Sửa sản phẩm thành công';
                } else {
                    $_SESSION['edit-product'] = 'Sửa sản phẩm thât bại';
                }
            }

            $this->index();
        }
    }

    public function printPDF(Request $request)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Đường dẫn đến thư mục chứa font arialuni.ttf
        $fontDir = realpath(__DIR__ . '/../vendor/dompdf/dompdf/lib/fonts/');
        $options->set('fontDir', $fontDir);
        $options->set('defaultFont', 'arialuni');

        $dompdf = new Dompdf($options);
        $product = Model::find('Products', $request->getParam());
        // Tạo HTML để chuyển đổi thành PDF
        $html = '<h1>Bill</h1>';
        $html .= '<h5>'. $product['created_at'].'</h5>';
        $html .= '<hr>';
        $html .= '<p style="background: #e6e6e674; padding: 5px;">Code: ' . $product['name'] . '</p>';
        $html .= '<p style="background: #e6e6e674; padding: 5px;">Total: ' . number_format($product['price'] ?? 0, 0, ',', '.'). 'VND</p>';
        $html .= '<p style="background: #e6e6e674; padding: 5px;">Quantity: ' . number_format($product['qty'] ?? 0, 0, ',', '.'). '</p>';

        // Load HTML vào Dompdf
        $dompdf->loadHtml($html);

        // Cấu hình và render PDF (output vào file hoặc browser)
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output PDF tới trình duyệt (mở trong tab mới)
        $dompdf->stream('output.pdf', ['Attachment' => false]);
    }
}
