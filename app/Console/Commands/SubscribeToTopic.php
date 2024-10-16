<?php

namespace App\Console\Commands;

use App\Events\ChatEvent;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeToTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe {topic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to an MQTT topic';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $mqtt = MQTT::connection();
            $inputTopic = $this->argument('topic');
            $this->info("Subscribing to topic: {$inputTopic}");
            $mqtt->subscribe($inputTopic, function (string $topic, string $message) {
                $this->info(sprintf("Received message on topic [%s]: %s", $topic, $message));
                event(new ChatEvent($topic, $message));
            });
            $mqtt->loop(true);
        } catch (\Exception $exception) {
            return Command::FAILURE;
        }
    }
}