<?php

namespace Webtamizhan\LaravelGoogleTranslator;

use Google\Cloud\Core\Exception\ServiceException;
use Illuminate\Database\Eloquent\Model;
use Webtamizhan\LaravelGoogleTranslator\Models\Translation;

class LaravelGoogleTranslator
{
    /**
     * @param Model $model
     * @param array $columns
     * @param string $targetLanguage
     * @return void
     * @throws ServiceException
     */
    public static function translateAndSave(Model $model, array $columns, string $targetLanguage): void
    {
        $translator = new GoogleTranslateService();

        foreach ($columns as $column) {
            if(self::checkModelIsAlreadyTranslated($model, $column, $targetLanguage)){
                $translatedValue = $translator->translateText($model->$column, $targetLanguage);
                self::saveTranslation($model, $column, $targetLanguage, $translatedValue);
            }
        }
    }

    /**
     * @param Model $model
     * @param string $column
     * @param string $langCode
     * @return bool
     */
    public static function checkModelIsAlreadyTranslated(Model $model, string $column, string $langCode): bool{
        $isExists = Translation::where('model_name',get_class($model))
            ->where('model_id', $model->id)
            ->where('column_name',$column)
            ->where('lang', $langCode)
            ->count();

        return $isExists === 0;
    }

    /**
     * @param Model $model
     * @param string $column
     * @param string $langCode
     * @param string $translatedText
     * @return void
     */
    public static function saveTranslation(Model $model, string $column, string $langCode, string $translatedText): void{
        $translation = new Translation();
        $translation->model_name = get_class($model);
        $translation->model_id = (string)$model->id;
        $translation->column_name = $column;
        $translation->translated_column_value = $translatedText;
        $translation->lang = $langCode;
        $translation->save();
    }

    /**
     * @param string $column
     * @param string $targetLanguage
     * @return mixed
     * @throws ServiceException
     */
    public static function translate(string $column, string $targetLanguage): mixed
    {
        $translator = new GoogleTranslateService();
        return $translator->translateText($column, $targetLanguage);
    }


    /**
     * Find the translation and update the value using translated Text
     * @param Model $model
     * @param string $column
     * @param string $langCode
     * @param string $translatedText
     * @return void
     */
    public static function updateTranslation(Model $model, string $column, string $langCode, string $translatedText): void{
        $translation = Translation::where('model_name',get_class($model))
            ->where('model_id', $model->id)
            ->where('column_name',$column)
            ->where('lang', $langCode)
            ->first();
        if($translation){
            $translation->value = $translatedText;
            $translation->save();
        }
    }
}
