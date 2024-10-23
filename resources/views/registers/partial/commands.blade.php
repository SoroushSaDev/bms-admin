<div id="commands-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-gray-200 rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $register->title . ' Commands' }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal"
                    onclick="modal.hide();">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <ol class="space-y-5">
                    @foreach($register->Commands as $command)
                        <li class="flex justify-between items-center">
                            <p>
                                {{ $command->title }}
                            </p>
                            @switch($command->type)
                            @case('Switch')
                                <ul class="items-center w-auto text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach(json_decode($command->value) as $key => $value)
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <div class="flex items-center px-3">
                                                <input id="{{ 'switch' . $key }}" type="radio" value="{{ $value }}" name="{{ 'command' . $command->id }}" onchange="run(this)"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                    data-type="{{ $command->type }}" data-command="{{ $command->id }}" @checked($command->current == $value)>
                                                <label for="{{ 'switch' . $key }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @break
                            @case('SetPoint')
                                @php
                                    $min = json_decode($command->value)[0];
                                    $max = json_decode($command->value)[1];
                                @endphp
                                <div class="flex">
                                    <input type="number" id="{{ 'command' . $command->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto sm:w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="{{ 'Enter a value between ' . $min . ' & ' . $max }}"
                                        value="{{ $command->current }}" min="{{ $min }}" max="{{ $max }}"/>
                                    <button type="button" onclick="run(this)" data-type="{{ $command->type }}" data-command="{{ $command->id }}"
                                        class="ml-5 flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill sm:mr-2" viewBox="0 0 16 16">
                                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                        </svg>
                                        <span class="hidden sm:block">
                                            Run
                                        </span>
                                    </button>
                                </div>
                                @break
                            @default
                            <div class="flex justify-between items-center space-x-5">
                                    <p class="rounded-lg bg-gray-300 dark:bg-gray-700 p-2">
                                        {{ $command->command }}
                                    </p>
                                    <button type="button" onclick="run(this)" data-type="{{ $command->type }}" data-command="{{ $command->id }}"
                                        class="ml-5 flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill sm:mr-2" viewBox="0 0 16 16">
                                            <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                        </svg>
                                        <span class="hidden sm:block">
                                            Run
                                        </span>
                                    </button>
                                </div>
                                @break
                            @endswitch
                        </li>
                    @endforeach
                </ol>
            </div>
            <!-- Modal footer -->
            <!-- <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b border-gray-300 dark:border-gray-700">
                <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div> -->
        </div>
    </div>
</div>
<script>
    function run(event) {
        SetLoading(true);
        let value = '';
        const type = $(event).data('type');
        const command = $(event).data('command');
        switch(type) {
            case 'Switch':
                value = $('input[name="command' + command + '"]:checked').val();
                break;
            case 'SetPoint':
                value = $('#command' + command).val();
                break;
            default:
                break;
        }
        $.ajax({
            url: "{{ route('registers.publish', $register) }}",
            method: "POST",
            data: {
                type: type,
                value: value,
                command: command,
            }
        }).done(function(data) {
            new Toast({
                message: 'Command ran successfully : ' + data,
                type: 'success'
            });
        }).fail(function(jqXHR, textStatus) {
            window.swal.fire({
                title: 'Error!',
                text: 'Please contact support',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            console.log(textStatus);
        }).always(function() {
            SetLoading(false);
        });
    }
</script>