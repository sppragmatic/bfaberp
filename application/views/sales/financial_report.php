<?php
/**
 * Enhanced Sales Financial Report View
 * 
 * Displays comprehensive financial breakdown of sales transactions including:
 * - Sub Total (products only)
 * - Transportation Charges
 * - Loading Charges  
 * - Grand Total
 * - Paid Amount
 * - Balance Amount
 * 
 * Features:
 * - Color-coded financial metrics
 * - Summary dashboard with key performance indicators
 * - Responsive design for mobile devices
 * - Export-ready format for printing
 * - Real-time balance calculations
 */
?>

<script src="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/datatable/jquery.dataTables.min.css" />

<script>
$(document).ready(function() {
    $('#financial_table').DataTable({
        responsive: true,
        scrollX: true,
        scrollCollapse: true,
        "pageLength": 25,
        "order": [[ 1, "desc" ]],  // Sort by date desc
        "columnDefs": [
            { "orderable": false, "targets": [-1] }, // Disable sorting on action column
            { "width": "80px", "targets": [0] }, // Invoice No
            { "width": "90px", "targets": [1] }, // Date
            { "width": "100px", "targets": [2] }, // Vehicle No
            { "width": "150px", "targets": [3] }, // Customer Name
            { "width": "90px", "targets": [4] }, // Payment Status
            { "width": "100px", "targets": [5] }, // Sub Total
            { "width": "90px", "targets": [6] }, // Transport
            { "width": "90px", "targets": [7] }, // Loading
            { "width": "110px", "targets": [8] }, // Grand Total
            { "width": "100px", "targets": [9] }, // Paid Amount
            { "width": "100px", "targets": [10] }, // Balance
            { "width": "70px", "targets": [-1] } // Actions
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "dom": '<"top-controls"<"left-controls"l><"center-controls"f><"right-controls"B>>rt<"bottom-controls"<"pagination-info"i><"pagination-nav"p>>',
        "language": {
            "lengthMenu": "Show _MENU_ entries per page",
            "zeroRecords": "No sales data found matching your criteria",
            "info": "Showing _START_ to _END_ of _TOTAL_ sales transactions",
            "infoEmpty": "No sales data available",
            "infoFiltered": "(filtered from _MAX_ total transactions)",
            "search": "Search sales data:",
            "searchPlaceholder": "Search by customer, vehicle, invoice...",
            "paginate": {
                "first": "First",
                "last": "Last", 
                "next": "Next",
                "previous": "Previous"
            }
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
 
            // Enhanced number extraction function to handle HTML content
            var intVal = function ( i ) {
                if (typeof i === 'number') {
                    return i;
                }
                
                if (typeof i === 'string') {
                    // Remove HTML tags, currency symbols, commas, and spaces
                    var cleanValue = i.replace(/<[^>]*>/g, '') // Remove HTML tags
                                      .replace(/[\₹,\s]/g, '') // Remove currency, commas, spaces
                                      .replace(/[^\d.-]/g, ''); // Keep only digits, dots, and minus
                    
                    var num = parseFloat(cleanValue);
                    return isNaN(num) ? 0 : num;
                }
                
                return 0;
            };
 
            // Calculate totals for visible rows with better error handling
            try {
                var subTotalSum = 0;
                var transportSum = 0;
                var loadingSum = 0;
                var grandTotalSum = 0;
                var paidSum = 0;
                var balanceSum = 0;
                
                // Get visible row nodes and calculate sums using data attributes
                api.rows({ page: 'current' }).nodes().each(function(node) {
                    var $row = $(node);
                    
                    // Extract values from data attributes for reliable calculation
                    subTotalSum += parseFloat($row.find('td:eq(5)').attr('data-value') || '0');
                    transportSum += parseFloat($row.find('td:eq(6)').attr('data-value') || '0');
                    loadingSum += parseFloat($row.find('td:eq(7)').attr('data-value') || '0');
                    grandTotalSum += parseFloat($row.find('td:eq(8)').attr('data-value') || '0');
                    paidSum += parseFloat($row.find('td:eq(9)').attr('data-value') || '0');
                    balanceSum += parseFloat($row.find('td:eq(10)').attr('data-value') || '0');
                });
                
                // Format and display totals with validation
                var formatCurrency = function(amount) {
                    if (isNaN(amount) || !isFinite(amount)) {
                        return '₹0.00';
                    }
                    return '₹' + Number(amount).toLocaleString('en-IN', {
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2
                    });
                };
                
                // Update footer with calculated sums
                $(api.column(5).footer()).html(formatCurrency(subTotalSum));
                $(api.column(6).footer()).html(formatCurrency(transportSum));
                $(api.column(7).footer()).html(formatCurrency(loadingSum));
                $(api.column(8).footer()).html('<strong>' + formatCurrency(grandTotalSum) + '</strong>');
                $(api.column(9).footer()).html(formatCurrency(paidSum));
                $(api.column(10).footer()).html('<strong>' + formatCurrency(balanceSum) + '</strong>');
                
            } catch (e) {
                console.error('Error calculating totals:', e);
                // Set default values if calculation fails
                $(api.column(5).footer()).html('₹0.00');
                $(api.column(6).footer()).html('₹0.00');
                $(api.column(7).footer()).html('₹0.00');
                $(api.column(8).footer()).html('₹0.00');
                $(api.column(9).footer()).html('₹0.00');
                $(api.column(10).footer()).html('₹0.00');
            }
        }
    });

    // Print functionality
    $('#printReport').click(function() {
        window.print();
    });

    // Export to Excel functionality (requires additional plugin)
    $('#exportExcel').click(function() {
        alert('Excel export functionality can be added with additional plugins');
    });
    
    // Enhance search input with placeholder
    $('.dataTables_filter input').attr('placeholder', 'Search by customer, vehicle, invoice...');
    
    // Add real-time search feedback
    $('.dataTables_filter input').on('keyup', function() {
        var value = $(this).val();
        if (value.length > 0) {
            $(this).css('background-color', '#e8f5e8');
        } else {
            $(this).css('background-color', 'white');
        }
    });
    
    // Alternative calculation method as backup
    function calculateTotalsManually() {
        try {
            var subTotal = 0, transport = 0, loading = 0, grand = 0, paid = 0, balance = 0;
            
            $('#financial_table tbody tr:visible').each(function() {
                var row = $(this);
                
                // Extract values from data attributes for reliable calculation
                subTotal += parseFloat(row.find('td:eq(5)').attr('data-value') || '0');
                transport += parseFloat(row.find('td:eq(6)').attr('data-value') || '0');
                loading += parseFloat(row.find('td:eq(7)').attr('data-value') || '0');
                grand += parseFloat(row.find('td:eq(8)').attr('data-value') || '0');
                paid += parseFloat(row.find('td:eq(9)').attr('data-value') || '0');
                balance += parseFloat(row.find('td:eq(10)').attr('data-value') || '0');
            });
            
            // Format currency with proper validation
            var formatAmount = function(amt) {
                return '₹' + Number(amt).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            };
            
            // Update footer - always update to ensure correct values
            $('#financial_table tfoot th:eq(5)').html(formatAmount(subTotal));
            $('#financial_table tfoot th:eq(6)').html(formatAmount(transport));
            $('#financial_table tfoot th:eq(7)').html(formatAmount(loading));
            $('#financial_table tfoot th:eq(8)').html('<strong>' + formatAmount(grand) + '</strong>');
            $('#financial_table tfoot th:eq(9)').html(formatAmount(paid));
            $('#financial_table tfoot th:eq(10)').html('<strong>' + formatAmount(balance) + '</strong>');
            
        } catch (e) {
            console.error('Manual calculation failed:', e);
            // Set safe defaults
            $('#financial_table tfoot th:eq(5)').html('₹0.00');
            $('#financial_table tfoot th:eq(6)').html('₹0.00');
            $('#financial_table tfoot th:eq(7)').html('₹0.00');
            $('#financial_table tfoot th:eq(8)').html('₹0.00');
            $('#financial_table tfoot th:eq(9)').html('₹0.00');
            $('#financial_table tfoot th:eq(10)').html('₹0.00');
        }
    }
    
    // Run manual calculation after table is drawn
    $('#financial_table').on('draw.dt', function() {
        setTimeout(calculateTotalsManually, 100);
    });
    
    // Enhanced scroll functionality for responsive table
    setupResponsiveTableScroll();
});

// Enhanced Responsive Table Scroll Functionality - Only for Smaller Devices
function setupResponsiveTableScroll() {
    var $tableResponsive = $('.table-responsive');
    
    // Only enable scroll functionality on smaller devices
    function checkScreenSize() {
        return window.innerWidth <= 1200;
    }
    
    function enableScrollFeatures() {
        if (!checkScreenSize()) return; // Exit if large screen
        
        // Add scroll event listener
        $tableResponsive.on('scroll.responsive', function() {
            var scrollLeft = $(this).scrollLeft();
            var scrollWidth = this.scrollWidth;
            var clientWidth = this.clientWidth;
            
            // Update scroll indicators
            if (scrollLeft > 0) {
                $(this).addClass('scrolled-left');
            } else {
                $(this).removeClass('scrolled-left');
            }
            
            if (scrollLeft < scrollWidth - clientWidth - 1) {
                $(this).addClass('scrolled-right');
            } else {
                $(this).removeClass('scrolled-right');
            }
        });
        
        // Initialize scroll indicators
        $tableResponsive.trigger('scroll.responsive');
        
        // Add smooth scrolling for touch devices
        if ('ontouchstart' in window) {
            $tableResponsive.css({
                '-webkit-overflow-scrolling': 'touch',
                'scroll-behavior': 'smooth'
            });
        }
        
        // Add keyboard navigation
        $tableResponsive.on('keydown.responsive', function(e) {
            var scrollStep = 100;
            switch(e.keyCode) {
                case 37: // Left arrow
                    e.preventDefault();
                    $(this).animate({scrollLeft: $(this).scrollLeft() - scrollStep}, 200);
                    break;
                case 39: // Right arrow
                    e.preventDefault();
                    $(this).animate({scrollLeft: $(this).scrollLeft() + scrollStep}, 200);
                    break;
            }
        });
        
        // Make table focusable for keyboard navigation
        $tableResponsive.attr('tabindex', '0');
        
        // Add scroll hint for first-time users on small screens
        if ($tableResponsive[0].scrollWidth > $tableResponsive[0].clientWidth) {
            setTimeout(function() {
                var $scrollHint = $('<div class="scroll-hint">← Scroll horizontally to view all columns →</div>');
                $scrollHint.css({
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)',
                    background: 'rgba(102, 126, 234, 0.9)',
                    color: 'white',
                    padding: '10px 20px',
                    borderRadius: '20px',
                    fontSize: '14px',
                    fontWeight: '600',
                    zIndex: '1000',
                    pointerEvents: 'none',
                    animation: 'fadeInOut 4s ease-in-out'
                });
                
                $('body').append($scrollHint);
                
                setTimeout(function() {
                    $scrollHint.fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 3500);
            }, 1000);
        }
    }
    
    function disableScrollFeatures() {
        if (checkScreenSize()) return; // Exit if small screen
        
        // Remove scroll event listeners
        $tableResponsive.off('scroll.responsive keydown.responsive');
        
        // Remove scroll indicators
        $tableResponsive.removeClass('scrolled-left scrolled-right');
        
        // Remove tabindex
        $tableResponsive.removeAttr('tabindex');
    }
    
    // Initialize based on current screen size
    if (checkScreenSize()) {
        enableScrollFeatures();
    }
    
    // Handle window resize
    $(window).on('resize.responsiveTable', function() {
        if (checkScreenSize()) {
            enableScrollFeatures();
        } else {
            disableScrollFeatures();
        }
    });
}

// Add CSS animation for scroll hint
$('<style>').text(`
    @keyframes fadeInOut {
        0%, 100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
        20%, 80% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }
`).appendTo('head');

// Clear filters function
function clearFilters() {
    document.getElementById('customer_id').value = '0';
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
}

// Export to Excel function
function exportToExcel() {
    // Get table data
    var table = document.getElementById('financial_table');
    var wb = XLSX.utils.table_to_book(table, {sheet: "Sales Financial Report"});
    
    // Generate file name with current date
    var date = new Date();
    var fileName = 'Sales_Financial_Report_' + 
                   date.getFullYear() + '-' + 
                   String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                   String(date.getDate()).padStart(2, '0') + '.xlsx';
    
    // Save file (requires SheetJS library)
    try {
        XLSX.writeFile(wb, fileName);
    } catch (e) {
        alert('Excel export requires additional library. Feature will be available in future updates.');
    }
}

// Enhanced table functionality
function highlightRow(row) {
    $(row).css('background-color', '#f0f8ff');
}

function unhighlightRow(row) {
    $(row).css('background-color', '');
}
</script>

<style>
/* Enhanced Financial Report Styling */
.financial-report {
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Enhanced Professional Filter Panel */
.search_panel {
    background: white !important;
    border-radius: 15px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    overflow: hidden !important;
    margin-bottom: 25px !important;
    border: 1px solid #e9ecef !important;
}

.search_header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    margin: 0 !important;
    padding: 20px 25px !important;
    font-size: 18px !important;
    font-weight: 600 !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    border-bottom: none !important;
}

.search_conent {
    padding: 25px !important;
    background: #fafbfc !important;
}

.search_panel .row {
    display: flex !important;
    align-items: flex-end !important;
    gap: 20px !important;
    flex-wrap: wrap !important;
    margin: 0 0 15px 0 !important;
}

.search_panel .row > div {
    margin-bottom: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    min-width: 200px !important;
    flex: 1 !important;
}

.search_panel .form-group {
    display: flex !important;
    flex-direction: column !important;
    height: auto !important;
    justify-content: flex-start !important;
    margin-bottom: 0 !important;
}

.search_panel .control-label {
    margin-bottom: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    color: #2c3e50 !important;
    white-space: nowrap !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

.search_panel .control-label::before {
    content: "📋" !important;
    font-size: 16px !important;
    filter: grayscale(0.3) !important;
}

.search_panel .form-control,
.search_panel select {
    height: 45px !important;
    padding: 12px 15px !important;
    border: 2px solid #e1e5e9 !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-family: inherit !important;
    line-height: 1.4 !important;
    background-color: #fff !important;
    color: #333 !important;
    transition: all 0.3s ease !important;
    box-sizing: border-box !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

.search_panel select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6,9 12,15 18,9"></polyline></svg>') !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 12px !important;
    padding-right: 40px !important;
    cursor: pointer !important;
}

.search_panel .form-control:focus,
.search_panel select:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    outline: none !important;
    background-color: #fafbfc !important;
}

.search_panel .form-control:hover,
.search_panel select:hover {
    border-color: #c1c7cd !important;
}

.search_panel .btn {
    height: 45px !important;
    padding: 12px 24px !important;
    border-radius: 25px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    border: none !important;
    cursor: pointer !important;
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    min-width: 120px !important;
    text-decoration: none !important;
}

.search_panel .btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4) !important;
    background: linear-gradient(135deg, #34495e 0%, #2980b9 100%) !important;
}

.search_panel .btn-primary::before {
    content: "🔍" !important;
    font-size: 16px !important;
}

.search_panel .btn-secondary {
    background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%) !important;
    box-shadow: 0 4px 15px rgba(149, 165, 166, 0.3) !important;
}

.search_panel .btn-secondary:hover {
    background: linear-gradient(135deg, #7f8c8d 0%, #95a5a6 100%) !important;
    box-shadow: 0 8px 25px rgba(149, 165, 166, 0.4) !important;
}

.search_panel .btn-secondary::before {
    content: "🔄" !important;
    font-size: 16px !important;
}

/* Chosen Select Enhancement for Party Dropdown */
.search_panel .chosen-container {
    width: 100% !important;
    font-size: 14px !important;
    font-family: inherit !important;
}

.search_panel .chosen-container-single .chosen-single {
    padding: 12px 14px !important;
    border: 2px solid #e1e5e9 !important;
    border-radius: 8px !important;
    background: white !important;
    height: 45px !important;
    line-height: 21px !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    color: #333 !important;
    font-size: 14px !important;
}

.search_panel .chosen-container-single .chosen-single:hover {
    border-color: #c1c7cd !important;
}

.search_panel .chosen-container-active.chosen-with-drop .chosen-single {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    background-color: #fafbfc !important;
}

.search_panel .chosen-container .chosen-drop {
    border: 2px solid #667eea !important;
    border-radius: 8px !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    margin-top: 4px !important;
}

.search_panel .chosen-container .chosen-results li.highlighted {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
}

/* Responsive Design for Mobile Devices */
@media (max-width: 768px) {
    .search_panel .row {
        flex-direction: column !important;
        gap: 15px !important;
    }
    
    .search_panel .row > div {
        width: 100% !important;
        min-width: unset !important;
        flex: unset !important;
    }
    
    .search_conent {
        padding: 20px 15px !important;
    }
    
    .search_header {
        padding: 15px 20px !important;
        font-size: 16px !important;
    }
    
    .search_panel .control-label {
        font-size: 13px !important;
    }
    
    .search_panel .form-control,
    .search_panel select,
    .search_panel .btn {
        font-size: 16px !important; /* Prevent zoom on iOS */
    }
}

/* Enhanced Field Icons */
.search_panel .control-label[for="customer_id"]::before {
    content: "👥" !important;
}

.search_panel .control-label[for="start_date"]::before,
.search_panel .control-label[for="end_date"]::before {
    content: "📅" !important;
}

/* Action Buttons Container */
.search_panel .row > div:nth-last-child(2),
.search_panel .row > div:nth-last-child(1) {
    min-width: 140px !important;
    flex: 0 0 140px !important;
}

/* Enhanced Focus States */
.search_panel .form-control:focus::placeholder,
.search_panel select:focus::placeholder {
    color: #667eea !important;
    opacity: 0.7 !important;
}

/* Loading State for Buttons */
.search_panel .btn:active {
    transform: translateY(0) !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
}

/* Professional Gradient Animation */
.search_panel .btn {
    background-size: 200% 200% !important;
    animation: gradient-shift 3s ease infinite !important;
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.report-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.summary-metrics {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.metric-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin: 10px 5px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    border-left: 4px solid;
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.metric-card.success { border-left-color: #28a745; }
.metric-card.info { border-left-color: #17a2b8; }
.metric-card.warning { border-left-color: #ffc107; }
.metric-card.danger { border-left-color: #dc3545; }

.metric-value {
    font-size: 24px;
    font-weight: bold;
    margin: 5px 0;
}

.metric-label {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
}

.metric-subtitle {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}

/* Enhanced Responsive Table Container */
.table-container {
    background: white;
    border-radius: 12px;
    padding: 0;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    border: 1px solid #e9ecef;
    overflow: hidden;
    margin-bottom: 20px;
}

.table-responsive {
    border-radius: 12px;
    overflow: visible; /* Default: no scroll on large screens */
    max-width: 100%;
    position: relative;
}

/* Custom Scrollbar Styling */
.table-responsive::-webkit-scrollbar {
    height: 12px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 6px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6b4190 100%);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

/* Scrollbar for Firefox */
.table-responsive {
    scrollbar-width: thin;
    scrollbar-color: #667eea #f8f9fa;
}

/* Table Styling */
#financial_table {
    background: white;
    margin: 0 !important;
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    table-layout: auto; /* Auto layout for large screens */
}

/* Enhanced Professional Table Headers */
#financial_table thead th {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #3498db 100%);
    color: white;
    font-weight: 700;
    text-align: center;
    padding: 15px 8px;
    font-size: 12px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.4);
    border-right: 1px solid rgba(255,255,255,0.2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: sticky;
    top: 0;
    z-index: 10;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border: none;
}

#financial_table thead th:hover {
    background: linear-gradient(135deg, #34495e 0%, #2980b9 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Column-specific widths for better layout */
#financial_table thead th:nth-child(1) { min-width: 80px; } /* Invoice No */
#financial_table thead th:nth-child(2) { min-width: 90px; } /* Date */
#financial_table thead th:nth-child(3) { min-width: 100px; } /* Vehicle No */
#financial_table thead th:nth-child(4) { min-width: 150px; } /* Customer Name */
#financial_table thead th:nth-child(5) { min-width: 90px; } /* Payment Status */
#financial_table thead th:nth-child(6) { min-width: 100px; } /* Sub Total */
#financial_table thead th:nth-child(7) { min-width: 90px; } /* Transport */
#financial_table thead th:nth-child(8) { min-width: 90px; } /* Loading */
#financial_table thead th:nth-child(9) { min-width: 110px; } /* Grand Total */
#financial_table thead th:nth-child(10) { min-width: 100px; } /* Paid Amount */
#financial_table thead th:nth-child(11) { min-width: 100px; } /* Balance */

#financial_table tbody td {
    padding: 12px 8px;
    border-bottom: 1px solid #dee2e6;
    border-right: 1px solid #f8f9fa;
    vertical-align: middle;
    transition: all 0.2s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 11px;
}

#financial_table tbody td:last-child {
    border-right: none;
}

#financial_table tbody tr {
    transition: all 0.3s ease;
    background: white;
}

#financial_table tbody tr:hover {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid #3498db;
}

#financial_table tbody tr:nth-child(even) {
    background: linear-gradient(135deg, #fdfdfe 0%, #f8f9fa 100%);
}

#financial_table tbody tr:nth-child(even):hover {
    background: linear-gradient(135deg, #f1f3f4 0%, #e9ecef 100%) !important;
}

#financial_table tbody tr:hover td {
    border-bottom-color: #007bff;
}

#financial_table tfoot th {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    border: none;
    font-weight: bold;
    text-align: center;
    padding: 15px 8px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.4);
    border-right: 1px solid rgba(255,255,255,0.2);
    position: sticky;
    bottom: 0;
    z-index: 5;
}

/* DataTables Controls Enhancement */
.dataTables_wrapper {
    margin: 0;
    padding: 0;
}

.top-controls {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.left-controls, .center-controls, .right-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.dataTables_length select {
    padding: 8px 12px;
    border: 2px solid #e1e5e9;
    border-radius: 6px;
    background: white;
    font-size: 13px;
    transition: all 0.3s ease;
}

.dataTables_length select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    outline: none;
}

.dataTables_filter input {
    padding: 8px 15px;
    border: 2px solid #e1e5e9;
    border-radius: 20px;
    background: white;
    font-size: 13px;
    transition: all 0.3s ease;
    min-width: 250px;
}

.dataTables_filter input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    outline: none;
    transform: translateY(-1px);
}

.bottom-controls {
    background: #f8f9fa;
    padding: 15px 20px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.dataTables_info {
    color: #6c757d;
    font-size: 13px;
    font-weight: 500;
}

.dataTables_paginate {
    display: flex;
    gap: 5px;
}

.dataTables_paginate .paginate_button {
    padding: 8px 12px;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    background: white;
    color: #6c757d;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.dataTables_paginate .paginate_button:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #20c997;
    color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

/* Financial columns styling */
.amount-positive {
    color: #28a745;
    font-weight: bold;
}

.amount-negative {
    color: #dc3545;
    font-weight: bold;
}

.amount-zero {
    color: #6c757d;
}

/* Responsive Design - Scrolling Only for Smaller Devices */
@media (max-width: 1200px) {
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto; /* Enable horizontal scroll on tablets */
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }
    
    #financial_table {
        min-width: 1200px; /* Maintain minimum width for horizontal scroll */
        font-size: 11px;
        table-layout: fixed; /* Fixed layout for consistent columns */
    }
    
    #financial_table thead th,
    #financial_table tbody td,
    #financial_table tfoot th {
        padding: 10px 6px;
        font-size: 11px;
    }
    
    .top-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .left-controls, .center-controls, .right-controls {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .dataTables_filter input {
        min-width: 200px;
    }
}

@media (max-width: 768px) {
    .table-container {
        margin: 0 -15px;
        border-radius: 0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    
    .table-responsive {
        border-radius: 0;
        overflow-x: auto; /* Enable horizontal scroll on mobile */
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }
    
    #financial_table {
        min-width: 1000px; /* Smaller minimum width for mobile */
        font-size: 10px;
        table-layout: fixed;
    }
    
    #financial_table thead th,
    #financial_table tbody td,
    #financial_table tfoot th {
        padding: 8px 4px;
        font-size: 10px;
    }
    
    .top-controls {
        padding: 10px 15px;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .left-controls, .center-controls, .right-controls {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .dataTables_filter input {
        width: 100%;
        min-width: unset;
        max-width: 300px;
    }
    
    .bottom-controls {
        padding: 10px 15px;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .dataTables_paginate {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .dataTables_paginate .paginate_button {
        padding: 6px 10px;
        font-size: 11px;
    }
}

/* Sticky Table Headers Enhancement - Only for Large Screens */
@media (min-width: 1201px) {
    /* Large screens: Enable vertical scrolling with sticky headers */
    .table-responsive {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: visible; /* No horizontal scroll needed */
    }
    
    #financial_table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #financial_table tfoot th {
        position: sticky;
        bottom: 0;
        z-index: 5;
        box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
    }
}

/* Medium and Small Screens: Horizontal scrolling with visible headers */
@media (max-width: 1200px) {
    #financial_table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #financial_table tfoot th {
        position: sticky;
        bottom: 0;
        z-index: 5;
        box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
    }
}

/* Print-specific responsive adjustments */
@media print {
    .table-responsive {
        overflow: visible !important;
        max-height: none !important;
    }
    
    #financial_table {
        min-width: auto !important;
        width: 100% !important;
        font-size: 8px !important;
    }
    
    #financial_table thead th,
    #financial_table tbody td,
    #financial_table tfoot th {
        padding: 4px 2px !important;
        font-size: 8px !important;
    }
    
    .dataTables_wrapper > div:not(.table-responsive) {
        display: none !important;
    }
}

/* Enhanced scroll indicators - Only for smaller devices */
@media (max-width: 1200px) {
    .table-responsive::before,
    .table-responsive::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 20px;
        pointer-events: none;
        z-index: 2;
        transition: opacity 0.3s ease;
    }

    .table-responsive::before {
        left: 0;
        background: linear-gradient(to right, rgba(255,255,255,0.8), transparent);
        opacity: 0;
    }

    .table-responsive::after {
        right: 0;
        background: linear-gradient(to left, rgba(255,255,255,0.8), transparent);
        opacity: 1;
    }

    .table-responsive.scrolled-left::before {
        opacity: 1;
    }

    .table-responsive.scrolled-right::after {
        opacity: 0;
    }
}

/* Status badges */
.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-paid {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-unpaid {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.status-partial {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

/* Action buttons */
.action-btn {
    padding: 4px 8px;
    margin: 0 2px;
    border-radius: 4px;
    font-size: 11px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #17a2b8;
    color: white;
}

.btn-delete {
    background: #dc3545;
    color: white;
}

.btn-approve {
    background: #28a745;
    color: white;
}

.btn-print {
    background: #6c757d;
    color: white;
}

/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .report-header {
        background: #2c3e50 !important;
        -webkit-print-color-adjust: exact;
    }
    
    #financial_table thead th {
        background: #2c3e50 !important;
        -webkit-print-color-adjust: exact;
    }
    
    #financial_table tfoot th {
        background: #2c3e50 !important;
        -webkit-print-color-adjust: exact;
    }
}

/* DataTables Enhanced Styling */
.dataTables_wrapper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Top Controls Styling */
.top-controls {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.left-controls, .center-controls, .right-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Length Menu (Show entries dropdown) */
.dataTables_length {
    display: flex;
    align-items: center;
    gap: 8px;
}

.dataTables_length label {
    color: #2c3e50;
    font-weight: 600;
    font-size: 13px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dataTables_length select {
    background: white;
    border: 2px solid #007bff;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 600;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 80px;
}

.dataTables_length select:hover {
    border-color: #0056b3;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.dataTables_length select:focus {
    outline: none;
    border-color: #0056b3;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

/* Search Box Styling */
.dataTables_filter {
    display: flex;
    align-items: center;
    gap: 8px;
}

.dataTables_filter label {
    color: #2c3e50;
    font-weight: 600;
    font-size: 13px;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dataTables_filter input {
    background: white;
    border: 2px solid #28a745;
    border-radius: 25px;
    padding: 8px 16px;
    font-size: 13px;
    width: 250px;
    transition: all 0.3s ease;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23666" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
    background-repeat: no-repeat;
    background-position: 12px center;
    padding-left: 40px;
}

.dataTables_filter input:focus {
    outline: none;
    border-color: #20c997;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
    width: 300px;
}

.dataTables_filter input::placeholder {
    color: #6c757d;
    font-style: italic;
}

/* Bottom Controls Styling */
.bottom-controls {
    background: #f8f9fa;
    padding: 15px 20px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

/* Info Styling */
.dataTables_info {
    color: #495057;
    font-size: 13px;
    font-weight: 500;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 8px 16px;
    border-radius: 20px;
    border: 1px solid #90caf9;
}

/* Pagination Styling */
.dataTables_paginate {
    display: flex;
    gap: 5px;
}

.dataTables_paginate .paginate_button {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 2px solid #dee2e6;
    color: #495057 !important;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    min-width: 40px;
    text-align: center;
}

.dataTables_paginate .paginate_button:hover {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border-color: #0056b3;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #20c997;
    color: white !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

.dataTables_paginate .paginate_button.disabled {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d !important;
    cursor: not-allowed;
    opacity: 0.6;
}

.dataTables_paginate .paginate_button.disabled:hover {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d !important;
    transform: none;
    box-shadow: none;
}

/* Processing indicator */
.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    margin-left: -100px;
    margin-top: -26px;
    text-align: center;
    padding: 12px;
    background: rgba(40, 167, 69, 0.9);
    color: white;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Custom buttons styling */
.dataTables_wrapper .dt-buttons {
    display: flex;
    gap: 8px;
}

.dt-button {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dt-button:hover {
    background: linear-gradient(135deg, #5a6268 0%, #343a40 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Responsive design */
@media (max-width: 768px) {
    .metric-card {
        margin: 10px 0;
    }
    
    #financial_table {
        font-size: 11px;
    }
    
    #financial_table thead th,
    #financial_table tbody td,
    #financial_table tfoot th {
        padding: 6px 4px;
    }
    
    .top-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .left-controls, .center-controls, .right-controls {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .dataTables_filter input {
        width: 100%;
        max-width: 300px;
    }
    
    .bottom-controls {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .dataTables_paginate {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .dataTables_paginate .paginate_button {
        padding: 6px 8px;
        font-size: 11px;
        min-width: 35px;
    }
    
    .dataTables_length select {
        min-width: 60px;
        padding: 4px 8px;
    }
    
    .dataTables_filter input {
        padding: 6px 12px;
        padding-left: 35px;
        font-size: 12px;
    }
}
</style>

<div class="financial-report">
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        

                        <!-- Alert Messages -->
                        <?php if($this->session->flashdata('msg')): ?>
                        <div class="alert alert-success no-print">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Search Panel -->
                        <div class="search_panel no-print">
                            <h3 class="search_header">
                                <i class="icon-search"></i> Financial Report Filters
                            </h3>

                            <div class="search_conent">
                                <form id="financial_search" action="<?php echo site_url("admin/sales/search_sales");?>" enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="span3">
                                            <div class="form-group">
                                                <label for="customer_id" class="control-label">Select Party</label>
                                                <select id="customer_id" class="chosen-select form-control" name="customer_id">
                                                    <option value="0">-All Parties-</option>
                                                    <?php foreach($customer as $pr): ?>
                                                    <option <?php if($pr['id'] == $customer_id): ?> selected="selected" <?php endif; ?> 
                                                        value="<?php echo $pr['id']; ?>">
                                                        <?php echo $pr['name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="span2">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">Start Date</label>
                                                <input type="text" id="start_date" value="<?php echo $start_date; ?>" 
                                                       name="start_date" class="form-control datepicker" 
                                                       placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>

                                        <div class="span2">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label">End Date</label>
                                                <input type="text" id="end_date" value="<?php echo $end_date; ?>" 
                                                       name="end_date" class="form-control datepicker" 
                                                       placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>

                                        <div class="span2">
                                            <div class="form-group">
                                                <label class="control-label" style="visibility: hidden;">Action</label>
                                                <input type="submit" value="Search" class="btn btn-primary" />
                                            </div>
                                        </div>

                                        <div class="span2">
                                            <div class="form-group">
                                                <label class="control-label" style="visibility: hidden;">Action</label>
                                                <button type="button" onclick="clearFilters()" class="btn btn-secondary">
                                                    Clear
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Financial Summary Dashboard -->
                        <div class="summary-metrics">
                            <h4 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">
                                <i class="icon-dashboard"></i> Financial Performance Dashboard
                            </h4>
                            
                            <div class="row">
                                <?php 
                                // Calculate summary totals
                                $summary_sub_total = 0;
                                $summary_transport = 0; 
                                $summary_loading = 0;
                                $summary_grand_total = 0;
                                $summary_paid = 0;
                                $summary_balance = 0;
                                $paid_count = 0;
                                $unpaid_count = 0;
                                
                                foreach ($sales as $s) {
                                    $sub_total = isset($s['sub_total']) ? $s['sub_total'] : 0;
                                    $transport = isset($s['transportation_charge']) ? $s['transportation_charge'] : 0;
                                    $loading = isset($s['loading_charge']) ? $s['loading_charge'] : 0;
                                    $grand_total = $s['total_amount'];
                                    $paid = isset($s['paid_amount']) ? $s['paid_amount'] : 0;
                                    $balance = $grand_total - $paid;
                                    
                                    $summary_sub_total += $sub_total;
                                    $summary_transport += $transport;
                                    $summary_loading += $loading;
                                    $summary_grand_total += $grand_total;
                                    $summary_paid += $paid;
                                    $summary_balance += $balance;
                                    
                                    if ($balance <= 0) $paid_count++;
                                    else $unpaid_count++;
                                }
                                
                                $collection_rate = $summary_grand_total > 0 ? ($summary_paid / $summary_grand_total) * 100 : 0;
                                ?>
                                
                                <div class="span2">
                                    <div class="metric-card success">
                                        <div class="metric-label">Total Sales Revenue</div>
                                        <div class="metric-value" style="color: #28a745;">₹<?php echo number_format($summary_grand_total, 2); ?></div>
                                        <div class="metric-subtitle"><?php echo count($sales); ?> transactions</div>
                                    </div>
                                </div>
                                
                                <div class="span2">
                                    <div class="metric-card info">
                                        <div class="metric-label">Amount Collected</div>
                                        <div class="metric-value" style="color: #17a2b8;">₹<?php echo number_format($summary_paid, 2); ?></div>
                                        <div class="metric-subtitle"><?php echo number_format($collection_rate, 1); ?>% collection rate</div>
                                    </div>
                                </div>
                                
                                <div class="span2">
                                    <div class="metric-card <?php echo ($summary_balance > 0) ? 'danger' : 'success'; ?>">
                                        <div class="metric-label">Outstanding Amount</div>
                                        <div class="metric-value" style="color: <?php echo ($summary_balance > 0) ? '#dc3545' : '#28a745'; ?>;">
                                            ₹<?php echo number_format($summary_balance, 2); ?>
                                        </div>
                                        <div class="metric-subtitle"><?php echo $unpaid_count; ?> pending payments</div>
                                    </div>
                                </div>
                                
                              
                                
                            
                                
                                <!-- <div class="span2">
                                    <div class="metric-card info">
                                        <div class="metric-label">Products Revenue</div>
                                        <div class="metric-value" style="color: #17a2b8;">₹<?php echo number_format($summary_sub_total, 2); ?></div>
                                        <div class="metric-subtitle">Core business income</div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- Financial Data Table -->
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="financial_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Vehicle No</th>
                                        <th>Customer Name</th>
                                        <th>Payment Status</th>
                                        <th>Sub Total</th>
                                        <th>Transport</th>
                                        <th>Loading</th>
                                        <th>Grand Total</th>
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                        <?php foreach ($products as $pm): ?>
                                        <th><?php echo $pm['name']; ?></th>
                                        <?php endforeach; ?>
                                        <th class="no-print">Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach ($sales as $fm): 
                                        $allitem = $fm['allitem'];
                                        
                                        // Calculate financial data
                                        $sub_total = isset($fm['sub_total']) ? $fm['sub_total'] : 0;
                                        $transport_charge = isset($fm['transportation_charge']) ? $fm['transportation_charge'] : 0;
                                        $loading_charge = isset($fm['loading_charge']) ? $fm['loading_charge'] : 0;
                                        $grand_total = $fm['total_amount'];
                                        $paid_amount = isset($fm['paid_amount']) ? $fm['paid_amount'] : 0;
                                        $balance = $grand_total - $paid_amount;
                                        
                                        // Determine payment status
                                        $payment_status_class = '';
                                        $payment_status_text = '';
                                        if ($balance <= 0) {
                                            $payment_status_class = 'status-paid';
                                            $payment_status_text = 'Paid';
                                        } elseif ($paid_amount > 0) {
                                            $payment_status_class = 'status-partial';
                                            $payment_status_text = 'Partial';
                                        } else {
                                            $payment_status_class = 'status-unpaid';
                                            $payment_status_text = 'Unpaid';
                                        }
                                    ?>
                                    <tr>
                                        <td><strong><?php echo $fm['sl_no']; ?></strong></td>
                                        <td><?php echo date('d-m-Y', strtotime($fm['bill_date'])); ?></td>
                                        <td><?php echo $fm['vehicle_number']; ?></td>
                                        <td><strong><?php echo $fm['customername']; ?></strong></td>
                                        <td>
                                            <span class="status-badge <?php echo $payment_status_class; ?>">
                                                <?php echo $payment_status_text; ?>
                                            </span>
                                        </td>
                                        
                                        <!-- Financial Breakdown -->
                                        <td style="text-align: right;" data-value="<?php echo $sub_total; ?>">
                                            <span class="<?php echo ($sub_total > 0) ? 'amount-positive' : 'amount-zero'; ?>">
                                                ₹<?php echo number_format($sub_total, 2); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;" data-value="<?php echo $transport_charge; ?>">
                                            <span class="<?php echo ($transport_charge > 0) ? 'amount-positive' : 'amount-zero'; ?>">
                                                ₹<?php echo number_format($transport_charge, 2); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;" data-value="<?php echo $loading_charge; ?>">
                                            <span class="<?php echo ($loading_charge > 0) ? 'amount-positive' : 'amount-zero'; ?>">
                                                ₹<?php echo number_format($loading_charge, 2); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;" data-value="<?php echo $grand_total; ?>">
                                            <strong class="amount-positive">₹<?php echo number_format($grand_total, 2); ?></strong>
                                        </td>
                                        <td style="text-align: right;" data-value="<?php echo $paid_amount; ?>">
                                            <span class="<?php echo ($paid_amount > 0) ? 'amount-positive' : 'amount-zero'; ?>">
                                                ₹<?php echo number_format($paid_amount, 2); ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;" data-value="<?php echo $balance; ?>">
                                            <strong class="<?php echo ($balance > 0) ? 'amount-negative' : 'amount-positive'; ?>">
                                                ₹<?php echo number_format($balance, 2); ?>
                                            </strong>
                                        </td>
                                        
                                        <!-- Product Quantities -->
                                        <?php 
                                        // Create array for quick lookup of quantities by product_id
                                        $sale_quantities = array();
                                        foreach ($allitem as $am) {
                                            $sale_quantities[$am['product_id']] = $am['stock'];
                                        }
                                        
                                        // Show all products, with quantity if exists, blank if not
                                        foreach ($products as $pm): 
                                            $quantity = isset($sale_quantities[$pm['id']]) ? $sale_quantities[$pm['id']] : '';
                                        ?>
                                        <td style="text-align: center; font-weight: bold; color: #dc3545;">
                                            <?php echo $quantity; ?>
                                        </td>
                                        <?php endforeach; ?>
                                        
                                        <!-- Actions -->
                                        <td class="no-print" style="text-align: center;">
                                            <?php if ($fm['trash'] == 0): ?>
                                                <?php if ($fm['status'] == 0): ?>
                                                    <a href="<?php echo site_url('admin/sales/edit_sales')."/".$fm['id']; ?>" 
                                                       class="action-btn btn-edit" title="Edit Sale">
                                                        <i class="icon-edit"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('admin/sales/delete')."/".$fm['id']; ?>" 
                                                       class="action-btn btn-delete" title="Delete Sale"
                                                       onclick="return confirm('Are you sure you want to delete this sale?')">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('admin/sales/approve')."/".$fm['id']; ?>" 
                                                       class="action-btn btn-approve" title="Approve Sale">
                                                        <i class="icon-ok"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="status-badge status-paid">Approved</span>
                                                    <a href="<?php echo site_url('admin/sales/chalan')."/".$fm['id']; ?>" 
                                                       class="action-btn btn-print" title="Print Challan">
                                                        <i class="icon-print"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="status-badge status-unpaid">Deleted</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">TOTALS:</th>
                                        <th></th> <!-- Sub Total -->
                                        <th></th> <!-- Transport -->
                                        <th></th> <!-- Loading -->
                                        <th></th> <!-- Grand Total -->
                                        <th></th> <!-- Paid -->
                                        <th></th> <!-- Balance -->
                                        <th colspan="<?php echo (count($products) + 1); ?>"></th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>

                        <!-- Additional Actions -->
                        <div class="no-print" style="background: white; padding: 15px; border-radius: 8px; margin-top: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                            <div class="row">
                                <div class="span12">
                                    <h5 style="color: #2c3e50; margin-bottom: 15px;">
                                        <i class="icon-cog"></i> Report Actions
                                    </h5>
                                    <button onclick="window.print()" class="btn btn-info" 
                                            style="margin-right: 10px; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; padding: 10px 20px; border-radius: 25px; font-weight: 600; transition: all 0.3s ease;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i class="icon-print"></i> Print Report
                                    </button>
                                    <button onclick="exportToExcel()" class="btn btn-success" 
                                            style="margin-right: 10px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; padding: 10px 20px; border-radius: 25px; font-weight: 600; transition: all 0.3s ease;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i class="icon-download"></i> Export to Excel
                                    </button>
                                    <a href="<?php echo site_url('admin/sales/view_sales'); ?>" class="btn btn-secondary" 
                                       style="margin-right: 10px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; padding: 10px 20px; border-radius: 25px; font-weight: 600; text-decoration: none; color: white; transition: all 0.3s ease;"
                                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i class="icon-list"></i> Standard View
                                    </a>
                                    <a href="<?php echo site_url('admin/sales/index'); ?>" class="btn btn-primary"
                                       style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); border: none; padding: 10px 20px; border-radius: 25px; font-weight: 600; text-decoration: none; color: white; transition: all 0.3s ease;"
                                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
                                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i class="icon-plus"></i> Add New Sale
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Picker Scripts -->
<script src="<?php echo base_url()?>assets/validate/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/ui/jquery-ui.css" />
<script src="<?php echo base_url()?>assets/ui/jquery-ui.js"></script>
<script>
$(function() {
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true
    });
});
</script>