@php
    use Carbon\Carbon;
    $title = __('Add Register');
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
    <form action="{{ route('registers.store', $device) }}" method="post">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-3">
            <div>
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Title
                </label>
                <input type="text" id="title" name="title" required
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
            </div>
            <div>
                <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Unit
                </label>
                <input type="text" id="unit" name="unit"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
            </div>
            <div>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Type
                </label>
                <input type="text" id="type" name="type"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                />
            </div>
        </div>
        <h3 class="text-2xl my-5">
            Commands :
        </h3>
        <ol id="commands" class="space-y-2">
            <li class="bg-gray-600 p-2 rounded">
                <div class="grid gap-6 md:grid-cols-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Title
                        </label>
                        <input type="text" name="command_title[]" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Command
                        </label>
                        <input type="text" name="command[]" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Type
                        </label>
                        <select name="command_type[]" onchange="SetType(this)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach($types as $key => $type)
                                    <option value="{{ $key }}">
                                        {{ $type }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="switchable hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Switches
                        </label>
                        <input type="text" name="switches[]" placeholder="separate with commas ( , )"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div class="limit hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Limit From
                        </label>
                        <input type="number" name="from[]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div class="limit hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Limit To
                        </label>
                        <input type="number" name="to[]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                </div>
                <button type="button" onclick="$(this).parent().remove();"
                    class="mt-2 flex items-center justify-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Remove Command
                </button>
            </li>
        </ol>
        <button type="button" onclick="AddCommand()"
                class="mt-5 flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Add Command
        </button>
        <hr class="my-5 border-gray-300 dark:border-gray-700">
        <button type="submit"
                class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-check-circle-fill mr-2" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            Submit
        </button>
    </form>
@endsection
<script>
    const command = '<li class="bg-gray-600 p-2 rounded"><div class="grid gap-6 md:grid-cols-5"><div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label><input type="text" name="command_title[]" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/></div><div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Command</label><input type="text" name="command[]" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/></div><div><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label><select name="command_type[]" onchange="SetType(this)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">@foreach($types as $key => $type)<option value="{{ $key }}">{{ $type }}</option>@endforeach</select></div><div class="switchable hidden"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Switches</label><input type="text" name="switches[]" placeholder="separate with commas ( , )" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/></div><div class="limit hidden"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Limit From</label><input type="number" name="from[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/></div><div class="limit hidden"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Limit To</label><input type="number" name="to[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/></div></div><button type="button" onclick="$(this).parent().remove();" class="mt-2 flex items-center justify-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Remove Command</button></li>';

    function AddCommand()
    {
        $('#commands').append(command);
    }

    function SetType(box)
    {
        const type = $(box).find(":selected").val();
        switch(type) {
            case 'Text':
                $(box).parent().parent().find('.switchable').css('display', 'none');
                $(box).parent().parent().find('.limit').css('display', 'none');
                break;
            case 'Switch':
                $(box).parent().parent().find('.switchable').css('display', 'block');
                $(box).parent().parent().find('.limit').css('display', 'none');
                break;
            case 'SetPoint':
                $(box).parent().parent().find('.switchable').css('display', 'none');
                $(box).parent().parent().find('.limit').css('display', 'block');
                break;
        }
    }
</script>