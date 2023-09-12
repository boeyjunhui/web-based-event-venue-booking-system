    <div class="mx-auto max-w-screen-xl">
        <footer class="bottom-0 left-0 w-full p-4 bg-white md:flex md:items-center md:justify-between md:p-4">
            <p class="text-sm text-gray-500 sm:text-center">&copy; <script>document.write(new Date().getFullYear());</script> Urban Space. All rights reserved.</p>
        </footer>
    </div>

    {{-- sweetalert --}}
    {{-- sign out confirmation --}}
    <script>
        document.getElementById('sign-out-confirmation')?.addEventListener('click', function () {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                titleText: 'Sign Out',
                text: "Are you sure you want to sign out?",
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true,
                color: '#1f2937',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        })
    </script>

    {{-- jquery datatable --}}
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable();
        } );
    </script>
</body>
</html>