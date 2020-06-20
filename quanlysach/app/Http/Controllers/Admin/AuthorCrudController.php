<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AuthorRequest as StoreRequest;
use App\Http\Requests\AuthorRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Backpack\CRUD\Exception\AccessDeniedException;

/**
 * Class AuthorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AuthorCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Author');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/author');
        $this->crud->setEntityNameStrings('author', 'authors');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();


        $this->crud->setColumns(['name_authors']);
        $this->crud->setColumnDetails('name_authors', [
            'name' => 'name_authors',
            'label' => "Tác giả"
        ]);
        $this->crud->addField([
            'name' => 'name_authors',
            'type' => 'text',
            'label' => "Tác giả"
        ]);

        // add asterisk for fields that are required in AuthorRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
//        $this->crud->denyAccess('delete');
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
        return $this->crud->delete($id);
    }

}
