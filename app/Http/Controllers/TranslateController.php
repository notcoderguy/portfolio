<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;

class TranslateController extends Controller
{
    public function getTranslation($modelType, $modelId, $locale='en', $key) {
        if (empty($modelType) || empty($modelId) || empty($locale) || empty($key)) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        try {
            $data = Translation::getData($modelType, $modelId, $locale, $key);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTranslationByKey($locale='en', $key) {
        if (empty($locale) || empty($key)) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        try {
            $data = Translation::getDataByKey($locale, $key);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function setTranslation($modelType, $modelId, $locale='en', $key, Request $request) {
        $data = $request->input('data');
        if (empty($modelType) || empty($modelId) || empty($locale) || empty($key) || empty($data)) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }
    
        try {
            Translation::setData($modelType, $modelId, $locale, $key, $data);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteTranslation($modelType, $modelId, $locale='en', $key) {
        if (empty($modelType) || empty($modelId) || empty($locale) || empty($key)) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }

        try {
            Translation::deleteData($modelType, $modelId, $locale, $key);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
