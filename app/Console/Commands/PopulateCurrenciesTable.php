<?php

namespace App\Console\Commands;

use App\Http\Controllers\CurrencyConversion\Models\Currency;
use App\Http\Controllers\External\FixerController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PopulateCurrenciesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:populate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to populate all currencies from the external API and their rates to the base currency EURO';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fixerController = new FixerController();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('PopulateCurrenciesTable started...');

        $currencies = $this->fixerController->postToFixer('latest', [], false);
        Log::info('Currencies rates list: ' . json_encode($currencies['rates']));

        if (isset($currencies)) {
            foreach ($currencies['rates'] as $key => $rate) {
                Log::info('Saving currency: ' . json_encode($key));
                Currency::updateOrCreate([
                    'value' => $key
                ], [
                    'value' => $key,
                    'to_base_eur' => $rate
                ]);
            }
        }

        //this will populate also the description(currency whole words) -> useful for displaying to users to avoid confusion
        $currencies_descriptions = $this->fixerController->postToFixer('symbols', [], false);
        Log::info('Currencies symbols list: ' . json_encode($currencies_descriptions['symbols']));

        if (isset($currencies_descriptions)) {
            foreach ($currencies_descriptions['symbols'] as $key => $currency) {
                Log::info('Updating currency description for: ' . json_encode($key));
                Currency::where('value', $key)->update(['description' => $currency]);
            }
        }

        Log::info('PopulateCurrenciesTable finished...');
    }
}
