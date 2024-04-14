<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportToJson implements ShouldQueue
{
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        protected $jsonData;
        protected $fileName;



        /**
         * Create a new job instance.
         */
        public function __construct($jsonData, $fileName)
        {
            $this->jsonData = $jsonData;
            $this->fileName = $fileName;
        }

        /**
         * Execute the job.
         */
        public function handle(): void
        {
        $data = [];

            foreach ($this->jsonData as $row) {
                $data[] = [
                    $row['name'],
                    $row['email'],
                    $row['phone'],
                    $row['address'],
                ];
            }

            // dd($data);
            Excel::store(collect($data), 'exports/' . $this->fileName . '.xlsx');
        }
    }
