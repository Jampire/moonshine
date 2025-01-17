<?php

declare(strict_types=1);

namespace MoonShine\Http\Controllers;

use Illuminate\Http\Response;
use MoonShine\Contracts\Fields\HasFields;
use MoonShine\Exceptions\ResourceException;
use MoonShine\Fields\Field;
use MoonShine\Fields\Fields;
use MoonShine\Http\Requests\Relations\RelationModelColumnUpdateRequest;
use MoonShine\Http\Requests\Resources\UpdateColumnFormRequest;
use MoonShine\Resources\ModelResource;

class UpdateFieldController extends MoonShineController
{
    public function column(UpdateColumnFormRequest $request): Response
    {
        return $this->save($request->getResource(), $request->getField());
    }

    public function relation(RelationModelColumnUpdateRequest $request): Response
    {
        $relationField = $request->getField();

        if($relationField instanceof HasFields) {
            $relationField->preparedFields();
        }

        $resource = $relationField->getResource();

        $field = $relationField
            ->getFields()
            ?->onlyFields()
            ?->findByColumn($request->get('field'));

        return $this->save($resource, $field);
    }

    protected function save(ModelResource $resource, Field $field)
    {
        try {
            $resource->save(
                $resource->getItemOrFail(),
                Fields::make([$field])
            );
        } catch (ResourceException $e) {
            throw_if(! app()->isProduction(), $e);
            report_if(app()->isProduction(), $e);

            return response($e->getMessage());
        }

        return response()->noContent();
    }
}
