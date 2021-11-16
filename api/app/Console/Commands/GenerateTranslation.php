<?php

namespace App\Console\Commands;

use App\Models\Locale\Locale;
use App\Service\TranslateLocaleService;
use Illuminate\Console\Command;
use RuntimeException;

class GenerateTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:generate {iso}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translation by iso code';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locale = Locale::where('iso_code',$this->argument('iso'))->first();
        if (!$locale) {
            $this->error('Locale not found!');
            return;
        }
        $translations = (new TranslateLocaleService())->translate($locale->getKey());
        if ($translations instanceof RuntimeException) {
            $this->error($translations->getMessage());
            return;
        }
        $this->info($translations);
    }
}
