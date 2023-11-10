<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\SupplierModel;

class Supplier extends BaseController
{
    public function index()
    {
        $supplier_model = new SupplierModel();
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->setTable('supplier');
        $crud->columns(['name', 'no_supplier', 'gender', 'address', 'email', 'phone']);
        $crud->unsetColumns(['created_at', 'updated_at', 'deleted_at']);
        $crud->displayAs(array(
            'name' => 'Nama',
            'no_supplier' => 'No Supplier',
            'gender' => 'L/P',
            'address' => 'Alamat',
            'phone' => 'Telp'
        ))
            ->unsetExport()
            ->unsetPrint();
        $crud->setTheme('datatables');
        //$crud->unsetAddFields(['created_at' , 'updated_at']);
        //$crud->unsetEditFields(['created_at' , 'updated_at']);
        $crud->unsetFields(['created_at', 'updated_at', 'deleted_at']);

        $crud->callbackInsert(function ($stateParameters) use ($supplier_model) {
            $supplier_model->save($stateParameters->data);
            return $stateParameters;
        });

        $crud->callbackDelete(function ($stateParameters) use ($supplier_model) {
            $supplier_model->delete($stateParameters->primaryKeyValue);
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
            'title' => 'Data Supplier',
            'result' => $output
        ];
        return view('supplier/index', $data);
    }
}
