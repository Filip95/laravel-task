<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Import;
use App\Models\ImportError;
use App\Models\Audit;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
//use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\GenericImport;

class ProcessImport implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected string $type;
    protected $filePath;
    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $type, $filePath,int $userId)
    {
        $this->type = $type;
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $imports = config('imports');
        if (!array_key_exists($this->type, $imports)) {
            throw new \InvalidArgumentException("Unknown import type: {$this->type}");
        }
        $cfg = $imports[$this->type];
        //Creates import record
        $import = Import::create([
            'type' => $this->type,
            'filename' => basename($this->filePath),
            'status' => 'processing',
            'user_id' => $this->userId,
        ]);

        $fullPath = Storage::path($this->filePath);
        //Loads all rows(including header) into a collection. For performance reasons chunking could've been considered(and would be necessary for large scale files), for simplicity left collection
        $rows = Excel::toCollection(new GenericImport(), $fullPath)->first();
        Log::info("ProcessImport saw ".count($rows).' rows', ['type'=>$this->type]);
        if ($rows->isNotEmpty()) {
            Log::info('First row keys', array_keys($rows->first()->toArray()));
        }
        //Mapping to a model that we need dinamically
        $modelMap  = [
            'orders' => Order::class,
            'customers' => Customer::class,
            'invoices' => Invoice::class,
        ];

        if (!array_key_exists($this->type, $modelMap)) {
            throw new \InvalidArgumentException("Unknown import type: {\$this->type}");
        }

        $modelClass = $modelMap[$this->type];

        foreach($rows as $index => $row) {
            $rowNumber = $index + 2;
            $data = $row->toArray();

            $validator = Validator::make($data, $cfg['validation']);
            if($validator->fails()){
                foreach($validator->errors()->messages() as $field => $messages){
                    foreach ($messages as $msg) {
                        $import->errors()->create([
                            'row_number' => $rowNumber,
                            'column'     => $field,
                            'value'      => $data[$field] ?? null,
                            'message'    => $msg,
                        ]);
                    }
                }
                continue;
            }
            $mapped = [];
            foreach($cfg['headers_to_db'] as $header => $column) {
                $mapped[$column] = $data[$header] ?? null;
            }

            $match = [];
            foreach ($cfg['update_or_create']['match'] as $column) {
                $match[$column] = $mapped[$column] ?? null;
            }
            $model = $modelClass::updateOrCreate($match, $mapped);

            if($model->wasChanged()){
                foreach($model->getChanges() as $col => $new){
                    $import->audits()->create([
                        'import_id' => $import->id,
                        'table_name'=> $model->getTable(),
                        'row_id'    => $model->getKey(),
                        'column'    => $col,
                        'old_value' => $model->getOriginal($col),
                        'new_value' => $new,
                    ]);
                }
            }
        }

        $import->update(['status' => 'completed']);
    }
}
