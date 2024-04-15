<?php

namespace App\Services;

use App\Models\JsonUploader;
use Illuminate\Support\Facades\DB;

class JsonFileUploader
{

    public function storeJson($data)
    {
        DB::beginTransaction();
        try {

            //object of jsonuploader
            $obj = new JsonUploader();
            $fileName = time() . '_' . $data->getClientOriginalName();
            $filePath = $data->storeAs('uploads', $fileName, 'public');
            $obj->file_name = time() . '_' . $data->getClientOriginalName();
            $obj->file_path = 'storage/' . $filePath;
            $obj->save();
            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
