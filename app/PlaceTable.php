<?php
/**
 * Created by PhpStorm.
 * User: ntutikyan
 * Date: 7/22/18
 * Time: 10:26 PM
 */

namespace App\Http\Controllers\Examples\Tables\Builders;

use App\Places;
use LaravelEnso\VueDatatable\app\Classes\Table;


class PlaceTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/exampleTable.json';

    public function query()
    {
        return Places::select(\DB::raw(
            'id as "dtRowId", name, coordinates, created_at, visited'
        ));
    }

}