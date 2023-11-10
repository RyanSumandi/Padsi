<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    public function index()
    {
        $customer_model = new CustomerModel();
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->setTable('customer');
        $crud->columns(['name', 'no_customer', 'gender', 'address', 'email', 'phone']);
        $crud->unsetColumns(['created_at', 'updated_at', 'deleted_at']);
        $crud->displayAs(array(
            'name' => 'Nama',
            'no_customer' => 'No Customer',
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

        $crud->callbackInsert(function ($stateParameters) use ($customer_model) {
            $customer_model->save($stateParameters->data);
            return $stateParameters;
        });

        $crud->callbackDelete(function ($stateParameters) use ($customer_model) {
            $customer_model->delete($stateParameters->primaryKeyValue);
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
            'title' => 'Data Customer',
            'result' => $output
        ];
        return view('customer/index', $data);
    }
}
