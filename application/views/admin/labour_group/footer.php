        </div>
        <!-- End Main Content Area -->

        <!-- Footer Section -->
        <div class="labour-group-footer fade-in">
            <div class="row">
                <div class="col-md-6 text-left">
                    <p class="mb-0">
                        <strong>Labour Groups Module</strong> - Version 1.0<br>
                        <small>© <?php echo date('Y'); ?> ERP System. All rights reserved.</small>
                    </p>
                </div>
                <div class="col-md-6 text-right">
                    <p class="mb-0">
                        <small>
                            Last updated: <?php echo date('F j, Y g:i A'); ?><br>
                            <a href="<?php echo site_url('admin/labour_group'); ?>" style="color: var(--secondary-color);">
                                <i class="fa fa-home"></i> Back to Labour Groups
                            </a>
                        </small>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <!-- End Container -->

    <!-- JavaScript Libraries -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- Labour Group Module JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Add smooth scrolling
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
            
            // Add loading states to buttons
            $('.btn').on('click', function() {
                if (!$(this).hasClass('btn-no-loading')) {
                    var btn = $(this);
                    var originalHtml = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    btn.prop('disabled', true);
                    
                    // Re-enable after 3 seconds (for safety)
                    setTimeout(function() {
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                    }, 3000);
                }
            });
            
            // Auto-hide alerts after 5 seconds
            $('.alert-custom').each(function() {
                var alert = $(this);
                setTimeout(function() {
                    alert.fadeOut(500);
                }, 5000);
            });
            
            // Add confirmation for delete actions
            $('.btn-delete, .delete-action').on('click', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var itemName = $(this).data('item-name') || 'this item';
                
                if (confirm('Are you sure you want to delete "' + itemName + '"?\n\nThis action cannot be undone.')) {
                    window.location.href = href;
                }
            });
            
            // Form validation enhancement
            $('form').on('submit', function() {
                var form = $(this);
                var submitBtn = form.find('button[type="submit"], input[type="submit"]');
                
                if (!submitBtn.hasClass('btn-no-loading')) {
                    submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                    submitBtn.prop('disabled', true);
                }
            });
            
            // Character counter for textareas
            $('textarea[maxlength]').each(function() {
                var textarea = $(this);
                var maxLength = textarea.attr('maxlength');
                var counterId = textarea.attr('id') + '_counter';
                
                // Add counter display
                textarea.after('<div class="character-counter text-muted small mt-1" id="' + counterId + '"></div>');
                
                // Update counter
                function updateCounter() {
                    var remaining = maxLength - textarea.val().length;
                    $('#' + counterId).text(remaining + ' characters remaining');
                    
                    if (remaining < 50) {
                        $('#' + counterId).removeClass('text-muted').addClass('text-warning');
                    } else if (remaining < 20) {
                        $('#' + counterId).removeClass('text-warning').addClass('text-danger');
                    } else {
                        $('#' + counterId).removeClass('text-warning text-danger').addClass('text-muted');
                    }
                }
                
                textarea.on('keyup paste', updateCounter);
                updateCounter(); // Initial count
            });
            
            // Enhanced table functionality
            if ($('.data-table').length) {
                $('.data-table').each(function() {
                    var table = $(this);
                    
                    // Add search functionality
                    if (!table.data('no-search')) {
                        var searchInput = $('<input type="text" class="form-control mb-3" placeholder="Search labour groups...">');
                        table.before(searchInput);
                        
                        searchInput.on('keyup', function() {
                            var value = $(this).val().toLowerCase();
                            table.find('tbody tr').filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                            });
                        });
                    }
                    
                    // Add sorting to table headers
                    table.find('th[data-sort]').addClass('sortable').css('cursor', 'pointer').on('click', function() {
                        var th = $(this);
                        var column = th.data('sort');
                        var order = th.hasClass('sort-asc') ? 'desc' : 'asc';
                        
                        // Remove previous sort classes
                        table.find('th').removeClass('sort-asc sort-desc');
                        th.addClass('sort-' + order);
                        
                        // Sort table rows
                        var rows = table.find('tbody tr').get();
                        rows.sort(function(a, b) {
                            var A = $(a).find('td').eq(th.index()).text().toUpperCase();
                            var B = $(b).find('td').eq(th.index()).text().toUpperCase();
                            
                            if (order === 'asc') {
                                return (A < B) ? -1 : (A > B) ? 1 : 0;
                            } else {
                                return (A > B) ? -1 : (A < B) ? 1 : 0;
                            }
                        });
                        
                        $.each(rows, function(index, row) {
                            table.children('tbody').append(row);
                        });
                    });
                });
            }
            
            // Add animation classes to elements as they come into view
            function addAnimationOnScroll() {
                $('.fade-in-on-scroll').each(function() {
                    var elementTop = $(this).offset().top;
                    var elementBottom = elementTop + $(this).outerHeight();
                    var viewportTop = $(window).scrollTop();
                    var viewportBottom = viewportTop + $(window).height();
                    
                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('fade-in');
                    }
                });
            }
            
            $(window).on('scroll resize', addAnimationOnScroll);
            addAnimationOnScroll(); // Initial check
        });
    </script>
    
    <!-- Page-specific JavaScript -->
    <?php if (isset($page_js)): ?>
    <script>
        <?php echo $page_js; ?>
    </script>
    <?php endif; ?>

</body>
</html>