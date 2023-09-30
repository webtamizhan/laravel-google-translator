<?php


namespace Webtamizhan\LaravelGoogleTranslator;


use Google\Cloud\Core\Exception\ServiceException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Webtamizhan\LaravelGoogleTranslator\Models\Translation;

trait GoogleTranslatableTrait
{

    /**
     * Get the mentioned columns to translate
     * @return array
     */
    public function getTranslatableColumns(): array
    {
        return $this->translatable;
    }


    /**
     * Get the translation if available
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, "model_id","id");
    }


    /**
     * Get the corresponding translation for the model
     * @param string|array $column
     * @param string $lang
     * @return string|array
     */
    public function getTranslation(string|array $column, string $lang): string|array
    {
        if(is_array($this->$column)){
            $result = [];
            foreach ($this->$column as $key => $item) {
                $ky = $column."_".$key;
                $collection = collect($this->translations())
                    ->where('lang', $lang)
                    ->where('column_name', $ky)
                    ->first();
                $result[] =  optional($collection)->value ?? $this->$column;
            }
            return $result;
        }else{
            $collection = collect($this->translations())
                ->where('lang', $lang)
                ->where('column_name', $column)
                ->first();

            return optional($collection)->value ?? $this->$column;
        }
    }

    /**
     * @param string|array $column
     * @param string $lang
     * @param bool $runningFromConsole
     * @return void
     * @throws ServiceException
     */
    public function setTranslation(string|array $column, string $lang, bool $runningFromConsole=false): void
    {
        if($this->$column){
            if(is_array($this->$column)){
                foreach ($this->$column as $key => $item) {
                    $ky = $column."_".$key;
                    if(LaravelGoogleTranslator::checkModelIsAlreadyTranslated($this, $ky , $lang)){
                        $translatedValue = LaravelGoogleTranslator::translate($item, $lang);
                        LaravelGoogleTranslator::saveTranslation($this, $ky, $lang, $translatedValue);

                    }else{
                        if(!$runningFromConsole) {
                            $translatedValue = LaravelGoogleTranslator::translate($item, $lang);
                            LaravelGoogleTranslator::updateTranslation($this, $ky, $lang, $translatedValue);
                        }
                    }
                }
            }else{
                if(LaravelGoogleTranslator::checkModelIsAlreadyTranslated($this, $column, $lang)){
                    $translatedValue = LaravelGoogleTranslator::translate($this->$column, $lang);
                    LaravelGoogleTranslator::saveTranslation($this, $column, $lang, $translatedValue);
                }
                else{
                    if(!$runningFromConsole){
                        $translatedValue = LaravelGoogleTranslator::translate($this->$column, $lang);
                        Translation::where('model_name',get_class($this))
                            ->where('model_id', $this->id)
                            ->where('column_name',$column)
                            ->where('lang', $lang)
                            ->update(['translated_column_value' => $translatedValue]);
                    }
                }
            }
        }
    }

}
