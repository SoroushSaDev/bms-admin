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
            $message = str_replace('[', '', $message);
            $message = str_replace(']', '', $message);
            $registers = explode(',', $message);
            if (count($registers)) {
                $devices = Device::where('mqtt_topic', $topic)->get();
                foreach ($devices as $device) {
                    foreach ($registers as $value) {
                        $data = array_values(explode(':', $value));
                        $register = Register::where('device_id', $device->id)->where('key', $data[0])->first();
                        if (!is_null($register)) {
                            $register->value = $data[1];
                            $register->save();
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
