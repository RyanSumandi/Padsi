<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\LayananModel;

class Layanan extends BaseController
{
    public function index()
    {
        $layanan_model = new LayananModel();
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->setTable('layanan');
        $crud->columns(['Id_Layanan', 'Bentuk_Layanan', 'Reservasi_Layanan']);
        $crud->unsetColumns(['created_at', 'updated_at', 'deleted_at']);
        $crud->displayAs(array(
            'Id_Layanan' => 'Id Layanan',
            'Bentuk_Layanan' => 'Bentuk Layanan',
            'Reservasi_Layanan' => 'No HP',
        ))
            ->unsetExport()
            ->unsetPrint();
        $crud->setTheme('datatables');
        //$crud->unsetAddFields(['created_at' , 'updated_at']);
        //$crud->unsetEditFields(['created_at' , 'updated_at']);
        $crud->unsetFields(['created_at', 'updated_at', 'deleted_at']);

        $crud->callbackInsert(function ($stateParameters) use ($layanan_model) {
            $layanan_model->save($stateParameters->data);
            return $stateParameters;
        });

        $crud->callbackDelete(function ($stateParameters) use ($layanan_model) {
            $layanan_model->delete($stateParameters->primaryKeyValue);
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
            'title' => 'Data Layanan',
            'result' => $output
        ];
        return view('layanan/index', $data);
    }
}
