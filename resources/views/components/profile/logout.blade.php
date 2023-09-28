<dialog id="logout" class="modal">
    <div class="modal-box">

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Logout?</h2>
            <p class="mb-3">You clicked on your own session. Do you want to log out?</p>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog" class="space-x-2">
                <button class="btn btn-neutral">Cancel</button>
                <a href="{{ route('logout') }}" role="button" class="btn btn-success">Yes</a>
            </form>
        </div>
    </div>
</dialog>
