            </div> {{-- end content --}}
        </div> {{-- end content container --}}

        <footer class="bg-white border py-3 lg:ml-64"> {{-- footer --}}
            <div class="footer-content">
                <p class="text-sm text-gray-400 text-center">&copy; <script>document.write(new Date().getFullYear());</script> Urban Space. All rights reserved.</p>
            </div>
        </footer> {{-- end footer --}}
    </div> {{-- end full screen --}}

    {{-- show/hide sidebar --}}
    <script>
        function showHideSidebar() {
            var sidebar = document.getElementById("sidebar");

            if (sidebar.style.display === "none") {
                sidebar.style.display = "block";
            } else {
                sidebar.style.display = "none";
            }
        }
    </script>

    {{-- sweetalert pop up box --}}
    {{-- activate confirmation --}}
    <script>
        document.getElementById('activate-confirmation').addEventListener('click', function () {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                titleText: 'Activate',
                text: "Are you sure you want to activate this record?",
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true,
                color: '#1f2937',
                confirmButtonColor: '#14b8a6',
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

    {{-- deactivate confirmation --}}
    <script>
        document.getElementById('deactivate-confirmation').addEventListener('click', function () {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                titleText: 'Deactivate',
                text: "Are you sure you want to deactivate this record?",
                icon: 'warning',
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

    {{-- delete confirmation --}}
    <script>
        document.getElementById('delete-confirmation').addEventListener('click', function () {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                titleText: 'Delete',
                text: "Are you sure you want to delete this record?",
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                color: '#1f2937',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#14b8a6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        })
    </script>

    {{-- logout confirmation --}}
    <script>
        document.getElementById('logout-confirmation').addEventListener('click', function () {
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
                cancelButtonColor: '#14b8a6',
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