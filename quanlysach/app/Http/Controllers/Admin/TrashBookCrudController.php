<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrashBookRequest as StoreRequest;
use App\Http\Requests\TrashBookRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\Exception\AccessDeniedException;

/**
 * Class TrashBookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrashBookCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        try {
            $this->crud->setModelTrash('App\Models\Book');
        } catch (\Exception $e) {
        }
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/trashbook');
        $this->crud->setEntityNameStrings('trashbook', 'book');
        $this->crud->denyAccess('create');
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in TrashBookRequest
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
        return $this->crud->deleteTrashBook($id);
    }
}
