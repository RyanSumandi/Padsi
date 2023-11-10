<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $produk_model = new ProdukModel();
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->setTable('produk');
        $crud->columns(['Id_Produk', 'Id_Pembelian', 'Nama_Produk', 'Stok_Produk', 'Harga_Produk']);
        $crud->unsetColumns(['created_at', 'updated_at', 'deleted_at']);
        $crud->displayAs(array(
            'Id_Produk' => 'Id Produk',
            'Id_Pembelian' => 'Id Pembelian',
            'Nama_Produk' => 'Nama Produk',
            'Stok_Prpduk' => 'Stok Produk',
            'Harga_Produk' => 'Harga Produk'
        ))
            ->unsetExport()
            ->unsetPrint();
        $crud->setTheme('datatables');
        //$crud->unsetAddFields(['created_at' , 'updated_at']);
        //$crud->unsetEditFields(['created_at' , 'updated_at']);
        $crud->unsetFields(['created_at', 'updated_at', 'deleted_at']);

        $crud->callbackInsert(function ($stateParameters) use ($produk_model) {
            $produk_model->save($stateParameters->data);
            return $stateParameters;
        });

        $crud->callbackDelete(function ($stateParameters) use ($produk_model) {
            $produk_model->delete($stateParameters->primaryKeyValue);
            return $stateParameters;
        });




        // $crud->unsetAdd();
        // $crud->unsetEdit();
        // $crud->unsetDelete();
        // $crud->unsetExport();
        // $crud->unsetPrint();
        // $crud->setRelation('officeCode', 'offices', 'city');
        // $crud->setTheme('datatables');

        $output = $crud->render();

        $data = [
            'title' => 'Data Produk',
            'result' => $output
        ];
        return view('produk/index', $data);
    }
}
