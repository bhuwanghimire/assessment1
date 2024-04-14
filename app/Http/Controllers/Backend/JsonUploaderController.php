<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UserJsonExport;
use App\Jobs\ExportToJson;
use App\Models\JsonUploader;
use Illuminate\Http\Request;
use App\Services\JsonFileUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class JsonUploaderController extends Controller
{

    protected $jsonfile;

    public function __construct(JsonFileUploader $jsonfile)
    {
        $this->jsonfile = $jsonfile;
    }

    public function Store(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file', // Validate JSON file
        ]);

        if ($request->hasFile('json_file')) {
            $file = $request->file('json_file');
            $check = $this->jsonfile->storeJson($file);

            if ($check) {
                return redirect()->back()->with('success', 'File successfully uploaded');
            } else {
                return redirect()->back()->with('error', 'Somethings went wrong!');
            }
        } else {
            return redirect()->back()->with('error', 'Please provide a valid file.');
        }
    }

    public function Downloads($id)
    {

        $file = JsonUploader::find($id);

        // path is like this http://127.0.0.1:8000/storage/uploads/1713004128_users.json contain large data set

        $jsonData = json_decode(file_get_contents($file->file_path), true);
        $fileName = pathinfo($file->file_name, PATHINFO_FILENAME);


        // Dispatch the job to export to Excel
        ExportToJson::dispatch($jsonData, $fileName);
    }

    public function Download($id){
        {
            // try {
                $file = JsonUploader::find($id);

                if (!$file) {
                    return response()->json(['error' => 'File not found'], 404);
                }

                // Check if file exists and is readable
                if (!is_readable($file->file_path)) {
                    return response()->json(['error' => 'File is not readable'], 500);
                }

                $jsonData = json_decode(file_get_contents($file->file_path), true);
                // $jsonData = array_slice($jsonData, 0, 20);
                                $fileName = pathinfo($file->file_name, PATHINFO_FILENAME);

                // (new UserJsonExport($jsonData, $fileName))->queue('ddddd.xlsx');
                        // return response()->json(['success' => 'File download started'], 200);
                        // return redirect()->back();
                // Dispatch the job to export to Excel

                ExportToJson::dispatch($jsonData, $fileName);


            // } catch (\Exception $e) {
            //     \Log::error('Error downloading file: ' . $e->getMessage());
            //     return response()->json(['error' => 'Internal Server Error'], 500);
            // }
        }
    }
}
