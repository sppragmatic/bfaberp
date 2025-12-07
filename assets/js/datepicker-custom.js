$(document).ready(function() {
    // Simple datepicker without problematic button panel, now using class selector
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
        showButtonPanel: false, // Disable problematic button panel
        yearRange: '-10:+5',
        showAnim: 'fadeIn',
        duration: 'fast'
    });

    // Add manual clear buttons next to the input fields
    $(".datepicker").each(function() {
        var $input = $(this);
        var $clearBtn = $('<button type="button" class="date-clear-btn">Clear</button>');

        $clearBtn.click(function() {
            $input.val('').focus();
        });

        $input.after($clearBtn);
    });

    // Auto-focus enhancement: when selecting a date in start_date, focus end_date
    $("input[name='start_date']").datepicker("option", "onSelect", function(selectedDate) {
        $("input[name='end_date']").focus();
    });

    // Add today button functionality for all datepicker fields
    $(document).on('keydown', '.datepicker', function(e) {
        // Press 'T' key to set today's date
        if (e.keyCode === 84) { // 'T' key
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            $(this).val(dd + '/' + mm + '/' + yyyy);
            e.preventDefault();
        }
    });
});
