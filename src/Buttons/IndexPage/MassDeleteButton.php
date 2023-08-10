<?php

declare(strict_types=1);

namespace MoonShine\Buttons\IndexPage;

use MoonShine\ActionButtons\ActionButton;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\Hidden;
use MoonShine\Resources\ModelResource;

final class MassDeleteButton
{
    public static function for(ModelResource $resource): ActionButton
    {
        return ActionButton::make(
            '',
            url: fn (): string => route('moonshine.crud.destroy', [
                'resourceUri' => $resource->uriKey(),
                'resourceItem' => 0,
            ])
        )
            ->bulk()
            ->customAttributes(['class' => 'btn-pink'])
            ->icon('heroicons.outline.trash')
            ->inModal(
                fn (): string => 'Delete',
                fn (): string => (string) form($resource->route('massDelete'))
                    ->fields([
                        Hidden::make('_method')->setValue('DELETE'),
                        Hidden::make('ids')->customAttributes([
                            'class' => 'actionsCheckedIds',
                        ]),
                        Heading::make(__('moonshine::ui.confirm_message')),
                    ])
                    ->submit('Delete', ['class' => 'btn-pink'])
            )
            ->showInLine();
    }
}