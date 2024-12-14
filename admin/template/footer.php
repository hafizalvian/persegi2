</div> <!-- End row -->
    </div> <!-- End container-fluid -->

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="text-center">
                <span class="text-muted">© <?php echo date('Y'); ?> Perpustakaan Digital. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Toggle sidebar on mobile
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('.sidebar').toggleClass('active');
            });
        });

        // Auto hide alerts after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>
    
</body>
</html>