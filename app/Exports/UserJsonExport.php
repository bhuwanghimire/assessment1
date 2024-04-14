<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserJsonExport implements FromCollection, ShouldQueue, WithHeadings
{
    use Exportable;

    public $jsonData;
    public $filename;

    public function __construct($jsonData, $filename)
    {
        $this->jsonData = $jsonData;
        $this->filename = $filename;
    }

    public function collection()
    {
        $chunkSize = 100; // Adjust the chunk size as needed

        // Chunk the data to process it in smaller batches
        return collect($this->jsonData)->chunk($chunkSize);
    }

    public function headings(): array
    {
        // Assuming the first row of $this->jsonData contains the keys
        return array_keys((array) $this->jsonData[0]);
    }
}
