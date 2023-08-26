<?php

declare(strict_types=1);

namespace MoonShine\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

use function Laravel\Prompts\{info, outro, text};

use MoonShine\MoonShine;

class MakeResourceCommand extends MoonShineCommand
{
    protected $signature = 'moonshine:resource {name?} {--m|model=} {--t|title=}';

    protected $description = 'Create resource';

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $name = str(
            text(
                'Name',
                'ArticleResource',
                $this->argument('name') ?? '',
                required: true,
            )
        );

        $name = $name->ucfirst()
            ->replace(['resource', 'Resource'], '')
            ->value();

        $model = $this->qualifyModel($this->option('model') ?? $name);
        $title = $this->option('title') ?? str($name)->singular()->plural()->value();

        $resource = $this->getDirectory() . "/Resources/{$name}Resource.php";

        $this->copyStub('Resource', $resource, [
            '{namespace}' => MoonShine::namespace('\Resources'),
            '{model-namespace}' => $model,
            '{model}' => class_basename($model),
            'DummyTitle' => $title,
            'Dummy' => $name,
        ]);

        info(
            "{$name}Resource file was created: " . str_replace(
                base_path(),
                '',
                $resource
            )
        );

        outro('Now register resource in menu');
    }
}