<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Mail;

class ExportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $total_count = Contact::count();
        $start = 0;
        $limit = 10000;
        $files = intdiv($total_count, $limit) + 1;

        for ($i = 1; $i <= $files; $i++) {
            if ($i == 1) {
                Excel::store(new ContactExport($start, $limit),'/faisal/'. $i . 'invoices.xlsx');
            } else {
                $start = $start + $limit;
                Excel::store(new ContactExport($start, $limit),'/faisal/'. $i . 'invoices.xlsx');
            }
        }


        $zip = new ZipArchive;

        $fileName = 'Transactions.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = \File::files(storage_path('app/faisal'));

            foreach ($files as $key => $value) {
                $file = basename($value);
                $zip->addFile($value, $file);
            }

            $zip->close();
        }

        
        File::deleteDirectory(storage_path('app/faisal'));
        
         $data = array('name' => "Payripe");
        Mail::send([], $data, function ($message) use ($fileName){
            $message->to('king975232@gmail.com', 'Tutorials Point')->subject('Payripe Transaction Export File')->setBody('Transactions File is Attached in the email');
            $message->attach(public_path($fileName));

            $message->from('king975232@gmail.com', 'Payripe');
        });

        
       

        dd('done');
    }
}
