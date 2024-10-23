<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/flowbite.min.js') }}"></script>
<script src="{{ asset('js/Toast.min.js') }}"></script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((registration) => {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch((error) => {
                    console.log('Service Worker registration failed:', error);
                });
        });
    }
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    function SetLoading(state) {
        const cursor = state ? 'wait' : 'default'
        document.body.style.cursor = cursor;
    }
</script>

<!-- Samples -->
<script>
    // new Toast({
        //     message: 'This is a danger message. You can use this for errors etc',
        //     type: 'danger'
    // });

    // window.swal.fire({
        //     title: 'Error!',
        //     text: 'Please contact support',
        //     icon: 'error',
        //     confirmButtonText: 'Ok'
    // })
</script>