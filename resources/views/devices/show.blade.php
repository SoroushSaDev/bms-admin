@php
    use Carbon\Carbon;
    $title = translate($device->name);
@endphp
@extends('layouts.app')
@section('title', $device->name)
@section('content')
    <div class="flex justify-between items-center">
        @include('shared.button', ['type' => 'back', 'url' => route('devices.index')])
        @include('shared.title', [$title])
        @include('shared.fake-div')
    </div>
    <hr class="my-5">
    <ul class="space-y-5">
        <li>
            {{ 'User : ' . ($device->User?->FullName() ?? '---') }}
        </li>
        <li>
            {{ 'Type : ' . ($device->type ?? '---') }}
        </li>
        <li>
            {{ 'Brand : ' . ($device->brand ?? '---') }}
        </li>
        <li>
            {{ 'Model : ' . ($device->model ?? '---') }}
        </li>
        <li>
            {{ 'Description : ' . ($device->description ?? '---') }}
        </li>
        <li>
            {{ 'LAN : ' . ($device->lan ?? '---') }}
        </li>
        <li>
            {{ 'WiFi : ' . ($device->wifi ?? '---') }}
        </li>
        <li>
            {{ 'Created At : ' . Carbon::parse($device->created_at)->format('Y/m/d | H:m:i') }}
        </li>
        <li>
            {{ 'Updated At : ' . Carbon::parse($device->updated_at)->format('Y/m/d | H:m:i') }}
        </li>
    </ul>
    <h3 class="text-2xl my-5">
        Patterns :
    </h3>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
        <table id="data" class="w-full text-sm text-left rtl:text-right text-gray-900 dark:text-gray-100">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Setter
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Beginner
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Finisher
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Separator
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Connector
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lenght
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($device->Patterns as $key => $pattern)
                <tr class="odd:bg-dar-gray-100 odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $key + 1 }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->setter ?? '---' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->beginner ?? '---' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->finisher ?? '---' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->separator }} 
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->connector ?? '---' }} 
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->lenght ?? '---' }} 
                    </td>
                    <td class="px-6 py-4">
                        {{ $pattern->type }} 
                    </td>
                </tr>
                @empty
                <tr class="odd:bg-dar-gray-100 odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td colspan="8" class="px-6 py-4">
                        No Records
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <hr class="my-5 border-gray-300 dark:border-gray-700">
    <div class="flex">
        <a href="{{ route('devices.edit', $device) }}"
           class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
            Edit
        </a>
        <form action="{{ route('devices.destroy', $device) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="ml-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Remove
            </button>
        </form>
    </div>
@endsection
