<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use App\Models\Register;
use App\Models\Device;

class HandleIncomingMessageJob implements ShouldQueue
{
    use Queueable;

    public string $message;
    public string $topic;

    /**
     * Create a new job instance.
     */
    public function __construct(string $message, string $topic)
    {
        $this->message = $message;
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            $topic = $this->topic;
            $message = $this->message;
            if (json_validate($message)) {
                $devices = Device::where('mqtt_topic', $topic)->get();
                if (count($devices)) {
                    $registers = json_decode($message, true);
                    if (count($registers)) {
                        foreach ($devices as $device) {
                            foreach ($registers as $key => $value) {
                                $register = Register::where('device_id', $device->id)->where('key', $key)->first();
                                if (!is_null($register)) {
                                    $register->value = $value;
                                    $register->save();
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->fail($exception);
        }
    }
}
