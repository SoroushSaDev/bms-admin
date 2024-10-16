<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Device;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpMqtt\Client\Facades\MQTT;

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
        return view('registers.create', compact('device'));
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
        $device = $register->Device;
        return view('registers.edit', compact('register', 'device'));
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

    public function send(Register $register)
    {
        DB::beginTransaction();
        try {
            $device = $register->Device;
            $mqtt = MQTT::connection();
            $mqtt->publish($device->mqtt_topic, 'test');
            DB::commit();
            return redirect(route('devices.registers', $device));
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
