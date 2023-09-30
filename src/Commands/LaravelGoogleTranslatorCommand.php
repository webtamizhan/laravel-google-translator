<?php

namespace Webtamizhan\LaravelGoogleTranslator\Commands;

use Illuminate\Console\Command;

class LaravelGoogleTranslatorCommand extends Command
{
    public $signature = 'lgt:translate';

    public $description = 'This command will take the translatable columns from model and translate the values and save it in a translations table';

    public function handle(): int
    {
        $this->comment("Preparing models...");
        $modelsToBeProcess = [
            // Add your models here
//            \App\Models\User::class
        ];

        foreach ($modelsToBeProcess as $model) {
            $this->info("Dispatching model ".$model);
            //create a job with queue processing and dispatch the models
//            ProcessTranslation::dispatch($model);
        }

        $this->comment("Processed.");
    }
}
