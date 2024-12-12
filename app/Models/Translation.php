<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'locale',
        'key',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Retrieve translation data by model type, model id, locale and key.
     *
     * @param string $modelType
     * @param string $modelId
     * @param string $locale
     * @param string $key
     * @return array|null
     */
    public static function getData(string $modelType, string $modelId, string $locale, string $key): ?array
    {
        return static::where([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'locale' => $locale,
            'key' => $key,
        ])->first()?->data ?? null;
    }


    /**
     * Retrieve translation data by key.
     *
     * @param string $locale
     * @param string $key
     * @return array|null
     */
    public static function getDataByKey(string $locale, string $key): ?array
    {
        return static::where([
            'locale' => $locale,
            'key' => $key,
        ])->first()?->data ?? null;
    }
    /**
     * Store translation data.
     *
     * @param string $modelType
     * @param string $modelId
     * @param string $locale
     * @param string $key
     * @param array  $data
     */

    public static function setData(string $modelType, string $modelId, string $locale, string $key, array $data): void
    {
        static::updateOrCreate([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'locale' => $locale,
            'key' => $key,
        ], [
            'data' => $data,
        ]);
    }

    /**
     * Delete a translation by model type, model id, locale and key.
     * 
     * @param string $modelType
     * @param string $modelId
     * @param string $locale
     * @param string $key
     */
    public static function deleteData(string $modelType, string $modelId, string $locale, string $key): void
    {
        static::where([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'locale' => $locale,
            'key' => $key,
        ])->delete();
    }
}
