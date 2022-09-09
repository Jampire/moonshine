<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Http\Requests\Resources;

use Leeto\MoonShine\MoonShineRequest;

final class EditFormRequest extends MoonShineRequest
{
    public function authorize(): bool
    {
        return $this->getResource()->can('update', $this->getDataOrFail());
    }

    public function rules(): array
    {
        return [];
    }
}
