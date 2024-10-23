<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Command;
use App\Models\Device;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpMqtt\Client\Facades\MQTT;

use function React\Promise\all;

class RegisterController extends Controller
{
    public function index(Device $device, Request $request)
    {
        $registers = $device->Registers;
        $registers->map(function ($register) {
            $register->Translate();
        });
        return $request->ajax()
            ? view('registers.partial.table', compact('registers'))
            : view('registers.index', compact('device', 'registers'));
    }

    public function create(Device $device)
    {
        $types = Command::Types;
        return view('registers.create', compact('device', 'types'));
    }

    public function store(Device $device, RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $register = new Register();
            $register->device_id = $device->id;
            $register->title = $request['title'];
            $register->unit = $request->has('unit') ? $request['unit'] : null;
            $register->type = $request->has('type') ? $request['type'] : null;
            $register->save();
            if($request->has('command')) {
                foreach($request['command'] as $i => $command) {
                    $type = $request['command_type'][$i];
                    $value = match($type) {
                        'SetPoint' => json_encode([$request['from'][$i], $request['to'][$i]]),
                        'Switch' => json_encode(explode(',', $request['switches'][$i])),
                        default => null,
                    };
                    Command::create([
                        'register_id' => $register->id,
                        'title' => $request['command_title'][$i],
                        'type' => $type,
                        'command' => $command,
                        'value' => $value,
                    ]);
                }
            }
            DB::commit();
            $register->Translate();
            return redirect(route('devices.registers', $device));
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function show(Register $register)
    {
        $register->Translate();
        $device = $register->Device;
        return view('registers.show', compact('register', 'device'));
    }

    public function edit(Register $register)
    {
        $types = Command::Types;
        $device = $register->Device;
        return view('registers.edit', compact('register', 'device', 'types'));
    }

    public function update(Register $register, RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $register->title = $request['title'];
            $register->unit = $request->has('unit') ? $request['unit'] : $register->unit;
            $register->type = $request->has('type') ? $request['type'] : $register->type;
            $register->save();
            DB::commit();
            $register->Translate();
            $device = $register->Device;
            return redirect(route('devices.registers', $device));
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function destroy(Register $register)
    {
        DB::beginTransaction();
        try {
            $device = $register->Device;
            $register->delete();
            DB::commit();
            return redirect(route('devices.registers', $device));
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function commands(Register $register)
    {
        return view('registers.partial.commands', compact('register'));
    }
}
