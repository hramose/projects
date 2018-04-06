</div>
            <!-- footer content -->
            <footer>
                <div class="">
                    <p class="pull-right">RRHH. |
                        <span class="lead"> RRHH</span>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
        <!-- /page content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    <!-- chart js -->
    <script src="{{ URL::asset('js/chartjs/chart.min.js') }}"></script>
    <!-- bootstrap progress js -->
    <script src="{{ URL::asset('js/progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ URL::asset('js/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <!-- icheck -->
    <script src="{{ URL::asset('js/icheck/icheck.min.js') }}"></script>
    <script src="{{ URL::asset('js/custom.js') }}"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>    

    <!-- form validation -->
    <script src="{{ URL::asset('js/validator/validator.js') }}"></script>
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        $('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                //this.submit();
                validar_especialidad();
            return false;
        });
    </script>    
<!-- /footer content -->

</body>

</html>