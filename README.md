# Child select field for Laravel Nova

This field allows you to dynamically fill options of the select based on value in parent select field.

Works with Nova Tabs!

Field is based on [nova-ajax-select](https://github.com/dillingham/nova-ajax-select).
But instead of providing api endpoint, you can fill options by a closure function.

![](https://user-images.githubusercontent.com/29180903/52602810-15c53900-2e32-11e9-9ade-492bfe80b234.gif)

### Install
```
composer require amidesfahani/nova-child-select
```

### Usage
Class have 2 special methods on top of default Select from Laravel Nova.
`parent` should be a select field or another child select this one depends on.
`options` should be a callable. it will receive parent select field's value as first argument and should return an array to be shown on the child select field.


### Example

```
use Amidesfahani\ChildSelect\ChildSelect;

public function fields(Request $request)
    {
        return [

            ID::make()->sortable(),

            Select::make('Country')
                ->options(Country::all()->mapWithKeys(function ($country) {
                    return [$country->id => $country->name];
                }))
                ->rules('required'),

            ChildSelect::make('City')
                ->parent('country')
                ->options(function ($value) { 
                    City::whereCountry($value)->get()->mapWithKeys(function ($city) {
                        return [$city->id => $city->name];
                    });
                })
                ->rules('required'),
        ];
    }

```

## Forked
https://github.com/alvinhu/nova-child-select

## Licence
This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/https://github.com/amidesfahani/nova-child-select) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.