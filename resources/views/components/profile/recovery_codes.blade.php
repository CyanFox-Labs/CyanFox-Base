@if(session()->has('recovery_codes'))
    <dialog id="recovery_codes" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">2FA Recovery Keys</h2>

                @foreach(session('recovery_codes') as $recovery_code)
                    <p class="mb-3">{{ $recovery_code }}</p>
                @endforeach
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Close</button>
                </form>
            </div>
        </div>
    </dialog>
    <script>
        recovery_codes.showModal();
    </script>
@endif
