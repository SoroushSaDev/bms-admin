@php
    use Carbon\Carbon;
    $title = $user->name;
@endphp
@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="flex justify-between items-center">
        <a href="{{ route('users.index') }}"
            class="flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-arrow-left-circle-fill sm:mr-2" viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
            <span class="hidden sm:block">
                Back
            </span>
        </a>
        <h2 class="text-gray-900 dark:text-gray-100 text-3xl">
            {{ $title }}
        </h2>
        <div class="hidden sm:block"></div>
    </div>
    <hr class="my-5 border-gray-300 dark:border-gray-700">
    <ul class="space-y-5">
        <li>
            Username : {{ $user->name }}
        </li>
        <li>
            Email : {{ $user->email ?? '---' }} ({{ is_null($user->email_verified_at) ? 'Not Verified' : 'Verified' }})
        </li>
        <li>
            Phone Number : {{ $user->phone_number ?? '---' }}
            ({{ is_null($user->phone_number_verified_at) ? 'Not Verified' : 'Verified' }})
        </li>
        <li>
            Type : {{ $user->type ?? '---' }}
        </li>
        <li>
            First Name : {{ $user->Profile?->first_name ?? '---' }}
        </li>
        <li>
            Last Name : {{ $user->Profile?->last_name ?? '---' }}
        </li>
        <li>
            Gender : {{ $user->Profile?->gender ?? '---' }}
        </li>
        <li>
            Language : {{ $user->Profile?->language ?? '---' }}
        </li>
        <li>
            Parent : {{ $user->Parent?->name ?? '---' }}
        </li>
        <li>
            Created At : {{ Carbon::parse($user->created_at)->format('Y/m/d | H:m:i') }}
        </li>
        <li>
            Updated At : {{ Carbon::parse($user->updated_at)->format('Y/m/d | H:m:i') }}
        </li>
    </ul>
    <h3 class="text-2xl my-5">
        Roles :
    </h3>
    <ul class="space-y-5">
        @foreach($user->Roles as $key => $role)
            <li>
                {{ $key + 1 }} - {{ $role->name }}
            </li>
        @endforeach
    </ul>
    <hr class="my-5 border-gray-300 dark:border-gray-700">
    <div class="flex">
        <a href="{{ route('users.edit', $user) }}"
           class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
            Edit
        </a>
        <form action="{{ route('users.destroy', $user) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="ml-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                Remove
            </button>
        </form>
    </div>
@endsection
