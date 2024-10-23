@php
    use Carbon\Carbon;
    $title = $register->title;
@endphp
@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="flex justify-between items-center">
        <a href="{{ route('devices.registers', $device) }}"
           class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            Back
        </a>
        <h2 class="text-gray-900 dark:text-gray-100 text-3xl">
            {{ $title }}
        </h2>
        <div></div>
    </div>
    <hr class="my-5 border-gray-300 dark:border-gray-700">
    <ul class="space-y-5">
        <li>
            Title : {{ $register->title }}
        </li>
        <li>
            Value : {{ $register->value ?? '---' }}
        </li>
        <li>
            Unit : {{ $register->unit ?? '---' }}
        </li>
        <li>
            Type : {{ $register->type ?? '---' }}
        </li>
        <li>
            Created At : {{ Carbon::parse($register->created_at)->format('Y/m/d | H:m:i') }}
        </li>
        <li>
            Updated At : {{ Carbon::parse($register->updated_at)->format('Y/m/d | H:m:i') }}
        </li>
    </ul>
    <h3 class="text-2xl my-5">
        Commands :
    </h3>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table id="data" class="w-full text-sm text-left rtl:text-right text-gray-900 dark:text-gray-100">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Command
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Values
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($register->Commands as $key => $command)
                <tr class="odd:bg-dar-gray-100 odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $key + 1 }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $command->title }}
                    </td>
                    <td class="px-6 py-4" id="register{{ $register->key }}">
                        {{ $command->command }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $command->GetType() }}
                    </td>
                    <td class="px-6 py-4">
                        @switch($command->type)
                            @case('Switch')
                                {{ implode(' , ', json_decode($command->value)) }}
                                @break
                            @case('SetPoint')
                                {{ 'From ' . json_decode($command->value)[0] . ' To ' . json_decode($command->value)[1] }}
                                @break
                            @default
                                ---
                                @break
                        @endswitch
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-dar-gray-100 odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td colspan="5" class="px-6 py-4">
                        No Records
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <hr class="my-5 border-gray-300 dark:border-gray-700">
    <div class="flex">
        <a href="{{ route('registers.edit', $register) }}"
           class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
            Edit
        </a>
        <form action="{{ route('registers.destroy', $register) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="ml-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Remove
            </button>
        </form>
    </div>
@endsection