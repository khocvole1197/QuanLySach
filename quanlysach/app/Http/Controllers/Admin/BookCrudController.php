<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BookRequest as StoreRequest;
use App\Http\Requests\BookRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\Exception\AccessDeniedException;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BookCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */

        try {
            $this->crud->setModel('App\Models\Book');
        } catch (\Exception $e) {
        }
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/book');
        $this->crud->setEntityNameStrings('book', 'books');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();

        $this->crud->setColumns(['name_book', 'authors','active','user_r']);
        $this->crud->setColumnDetails('name_book', [
            'name' => 'name_book',
            'label' => 'Tên Sách'
        ]);
        $this->crud->setColumnDetails('active',[
            'name'=>'active',
            'label' =>'Trạng Thái',
            'type'        => 'radio',
            'options'     => [
                null => "Chưa Mượn",
                1 =>"Chưa Mượn",
                2 =>"Đang Mượn",
                3 => "Đang Đọc"
            ]
        ]);
        $this->crud->setColumnDetails('user_r', [
            'name' => 'user_r',
            'label' => 'Người Mượn',
        ]);
        $this->crud->setColumnDetails('authors', [
            'name' => 'authors',
            'type' => 'select',
            'label' => 'Tác Giả',
            'entity' => 'author',
            'attribute' => 'name_authors',
            'model' => 'App\Models\author',
        ]);

        $this->crud->addField([
            'name' => 'name_book',
            'type' => 'text',
            'label' => "Tên Sách"
        ]);
        $this->crud->addField([
            'name' => 'authors',
            'type' => 'select2',
            'label' => 'Tác Giả',
            'entity' => 'author',
            'attribute' => 'name_authors',
            'model' => 'App\Models\Author',
            'options' => (function ($query) {
                return $query->orderBy('name_authors', 'ASC')->get();
            })
        ]);


        // add asterisk for fields that are required in BookRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
    public function destroy($id)
    {
        try {
            $this->crud->hasAccessOrFail('delete');
        } catch (AccessDeniedException $e) {
        }
        return $this->crud->deleteBook($id);
    }
}
