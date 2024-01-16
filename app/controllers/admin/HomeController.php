<?php

namespace App\controllers\admin;

use Illuminate\framework\Controller;
use Illuminate\framework\Response;
use Illuminate\framework\Request;
use Illuminate\framework\factory\Model;

class HomeController extends Controller
{
    public function index()
    {   
        $qty = Model::sum('Products', 'qty');

        $products = Model::all('Products');

        $qtyCategory = [];
        
        foreach($products as $key => $value) {
            $qtyCategory[$key]['product_category_id'] = $value['product_category_id'];
            $qtyCategory[$key]['SUM(qty)'] = implode(', ',Model::sumWhere('Products', 'qty', ['product_category_id' => $value['product_category_id']]));
        }

        $categorys = Model::all('ProductCategory');

        $this->setLayout('admin');
        
        echo $this->view('pages/admin/home', [
            'qty' => $qty,
            'qtyCategory' => $qtyCategory,
            'categorys' => $categorys
        ]);
    }
}
