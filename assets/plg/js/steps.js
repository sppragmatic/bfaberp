$('#psteps_horiz_layout').psteps({
    traverse_titles: 'always',
    steps_width_percentage: true,
    alter_width_at_viewport: '1300',
    steps_height_equalize: true,
    content_height_equalize: true,
    validate_use_error_msg: false,
    content_headings: true,
    step_order: false,
    steps_show: function() {
        var cur_step = $(this);
        var loaded_tooltips = cur_step.siblings('.step-loaded').find('.step-tooltip');
        loaded_tooltips.tooltip('hide');
    },
    steps_onload: function() {
        var cur_step = $(this);
        var step_tooltip = cur_step.find('.step-tooltip');
        step_tooltip.tooltip({
            placement: 'right'
        });
        if (cur_step.hasClass('pstep1')) {
            setTimeout(function() {
                step_tooltip.tooltip('show');
            }, 3000);
        } else {
            setTimeout(function() {
                step_tooltip.tooltip('show');
            }, 1000);
        }
        if (cur_step.hasClass('pstep2')) {
            cur_step.find('[name=birthdate]').datepicker({
                maxDate: 0,
                changeMonth: true,
                changeYear: true,
                yearRange: '-120',
                defaultDate: '-25y',
                dateFormat: 'yy-mm-dd'
            });
        }
        if (cur_step.hasClass('pstep4')) {
            var radio_public = cur_step.find('[name=public]');
            var radio_private = cur_step.find('[name=private]');
            radio_public.click(function() {
                if (radio_private.prop('checked') && radio_private.attr('checked')) {
                    radio_private.removeProp('checked').removeAttr('checked');
                }
            });
            radio_private.click(function() {
                if (radio_public.prop('checked') && radio_public.attr('checked')) {
                    radio_public.removeProp('checked').removeAttr('checked');
                }
            });
        }
    },
    validation_rule: function() {
        var cur_step = $(this);
        var toggle_completed = function(input, show) {
                if (!show) input.closest('label').find('.pf-required').show().end().find('.pf-completed').hide();
                elseinput.closest('label').find('.pf-required').hide().end().find('.pf-completed').show();
            }
        var validate_step = function(errors, warnings, false_results) {
                if (errors > 0) return 'error';
                else if (false_results > 0) return false;
                else if (warnings > 0) return 'warning';
                else return true;
            }
        if (cur_step.hasClass('pstep1')) {
            var active = cur_step.hasClass('step-active'); /* Validation Rule for Step 1 */
            var count_false = 0,
                count_warning = 0,
                count_error = 0; /* Username */
            var input = cur_step.find('.step-validate:[name=username]');
            var input_val = input.val();
            if (input_val == '') {
                count_false++;
                toggle_completed(input, false);
            } else if (input_val.length < 6 || input_val.length > 12) {
                if (active && input.hasClass('cur-validate')) alert('Please type a username that is 6-12 characters.');
                toggle_completed(input, false);
                count_error++;
            } else {
                toggle_completed(input, true);
            } /* Password */
            var input = cur_step.find('.step-validate:[name=password]');
            var input_val = input.val();
            if (input_val == '') {
                count_false++;
                toggle_completed(input, false);
            } else if (input_val.length < 7) {
                if (active && input.hasClass('cur-validate')) alert('Please type a password that is longer than 6 characters.');
                toggle_completed(input, false);
                count_error++;
            }
            elsetoggle_completed(input, true); /* Email */
            var input = cur_step.find('.step-validate:[name=retype_email]');
            var input_compare = cur_step.find('.step-validate:[name=email]');
            var input_val = input.val();
            var input_compare_val = input_compare.val();
            if (input_val == '') {
                count_false++;
                toggle_completed(input, false);
            } else if (input_val != input_compare_val) {
                if (active && (input.hasClass('cur-validate') || input_compare.hasClass('cur-validate'))) alert('Please re-type your email so that both email fields match.');
                toggle_completed(input, false);
                count_error++;
            }
            elsetoggle_completed(input, true);
            cur_step.find('.step-validate').removeClass('cur-validate');
            return validate_step(count_error, count_warning, count_false);
        } else if (cur_step.hasClass('pstep2')) { /* Validation Rule for Step 2 */
            var active = cur_step.hasClass('step-active');
            var count_false = 0,
                count_warning = 0,
                count_error = 0; /* Birth Date */
            var input = cur_step.find('.step-validate:[name=birthdate]');
            var input_val = input.val();
            if (input_val == '') {
                count_false += 1;
                toggle_completed(input, false);
            } else if (input_val.length < 6 || input_val.length > 12) {
                if (active && input.hasClass('cur-validate')) alert('Please type a username that is 6-12 characters.');
                toggle_completed(input, false);
                count_error += 1;
            }
            elsetoggle_completed(input, true);
            return validate_step(count_error, count_warning, count_false);
        } else if (cur_step.hasClass('pstep3')) { /* Validation Rule for Step 3 */
            var active = cur_step.hasClass('step-active');
            var count_false = 0,
                count_warning = 0,
                count_error = 0; /* Terms of Service */
            var check_box = cur_step.find('.step-validate:[name=terms]');
            if (check_box.prop('checked') && check_box.attr('checked')) {
                toggle_completed(check_box, true);
            } else if (check_box.hasClass('cur-validate')) {
                count_error++;
                toggle_completed(check_box, false);
            } else {
                count_false++;
                toggle_completed(check_box, false);
            }
            return validate_step(count_error, count_warning, count_false);
        } else if (cur_step.hasClass('pstep4')) { /* Validation Rule for Step 3 */
            var radio_public = cur_step.find('.step-validate:[name=public]');
            var radio_private = cur_step.find('.step-validate:[name=private]');
            if (radio_public.hasClass('cur-validate') || radio_private.hasClass('cur-validate')) return true;
            else return false;
        }
    },
    before_next: 'Please complete the all fields before advancing to the next section.',
    before_submit: 'Please complete all sections before submitting.'
}).find('.step-validate').on('focusout', function() {
    var elem = $(this);
    elem.addClass('cur-validate') 
	if (elem.attr('name') == 'birthdate') {
        setTimeout(function() {
            elem.trigger('validate.psteps');
        }, 500);
    }
    elseelem.trigger('validate.psteps');
}).end().find('pf-completed').hide();