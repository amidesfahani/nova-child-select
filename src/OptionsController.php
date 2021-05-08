<?php

namespace Amid\ChildSelect;

use Illuminate\Routing\Controller;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;

class OptionsController extends Controller
{
    public function index(NovaRequest $request)
    {
        $attribute = $request->query('attribute');
        $parentValue = $request->query('parent');

        $resource = $request->newResource();
        $fields = $resource->updateFields($request);
        $field = $fields->findFieldByAttribute($attribute);

        if (!$field)
        {
            if ($fields->count() > 1)
            {
                foreach ($fields as $_field)
                {
                    if (is_array($_field))
                    {
                        if (array_key_exists('panel', $_field) && $_field['panel'] == 'Tabs')
                        {
                            $_fields = FieldCollection::make($_field['fields']);
                            $field = $_fields->findFieldByAttribute($attribute);
                            break;
                        }
                    }
                }
            }
            else
            if ($fields->count() == 1 && isset($fields['Tabs']))
            {
                $tab = $fields->first();
                if (isset($tab['fields']))
                {
                    $fields = $tab['fields'];
                    $field = $fields->findFieldByAttribute($attribute);
                }
            }
        }
        $options = $field->getOptions($parentValue);

        return $options;
    }
}
