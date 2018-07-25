<?php
/**
 * Created by PhpStorm.
 * User: ntutikyan
 * Date: 7/22/18
 * Time: 10:26 PM
 */

namespace App;

use App\Places;
use LaravelEnso\VueDatatable\app\Classes\Table;


class PlaceTable extends Table
{
    protected $templatePath = __DIR__.'/../resources/assets/js/data-table-config.json';

    public function query()
    {
        return Places::select(\DB::raw(
            'id as "dtRowId", name, coordinates, created_at, visited'
        ));
    }

}