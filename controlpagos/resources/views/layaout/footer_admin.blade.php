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
    <script type="text/javascript" src="{{ URL::asset('js/moment.min2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/datepicker/daterangepicker.js') }}"></script>
    <!-- input mask -->
    <script src="{{ URL::asset('js/input_mask/jquery.inputmask.js') }}"></script> 
    <!-- tags -->
    <script src="{{ URL::asset('js/tags/jquery.tagsinput.min.js') }}"></script> 

    <!-- color picker -->
    <script src="{{ URL::asset('js/colorpicker/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ URL::asset('js/colorpicker/docs.js') }}"></script> 

    <!-- select2 -->
    <script src="{{ URL::asset('js/select/select2.full.js') }}"></script>      

    <!-- form validation -->
    <script src="{{ URL::asset('js/validator/validator.js') }}"></script>
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';
        validator.message['number'] = 'not a real number';

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

            if (submit) {
                <?php if (strpos($_SERVER['REQUEST_URI'],"nuevo_cirugia") !== false)  { ?>
                     var f=eval("document.forms[0]");
                     var SelBranchVal = "";
                     var x = 0;

                     for (x=0;x<f.seguro.length;x++)
                     {
                        if (f.seguro[x].selected)
                        {
                         SelBranchVal += f.seguro[x].text+",";
                        }
                     }
                     SelBranchVal+=f.seguro_nuevo.value;
                     f.seguros.value=SelBranchVal;
                    this.submit();
                    return false;
                <?php } else { ?>
                    this.submit();
                    return false;
                <?php } ?>
            }                        //
                
            
        });
    </script> 

    <!-- input_mask -->
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
    <!-- /input mask -->

    <?php if (strpos($_SERVER['REQUEST_URI'],"nuevo_medico") !== false || strpos($_SERVER['REQUEST_URI'],"consultarmedico") !== false || strpos($_SERVER['REQUEST_URI'],"nuevo_cirugia") !== false || strpos($_SERVER['REQUEST_URI'],"consultarcirugia") !== false || strpos($_SERVER['REQUEST_URI'],"solo_cirugia") !== false) { ?>
        <!-- input tags -->
        <script>
            function onAddTag(tag) {
                alert("Added a tag: " + tag);
            }

            function onRemoveTag(tag) {
                alert("Removed a tag: " + tag);
            }

            function onChangeTag(input, tag) {
                alert("Changed a tag: " + tag);
            }

            $(function () {
                $('#especialidad').tagsInput({
                    width: 'auto'
                });
            });
        </script>
        <!-- /input tags -->    

		
        <!-- Date Picker -->
    <script>
    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();       
        $("#fecha_nacimiento").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });
	
    $(function() {
        $("#fecha_cirugia").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy'
            /*minDate: start_date, */
        });	
    });	
	
    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();
        $("#fecha_carga").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });	

    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();       
        $("#fecha_alta").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });
	
    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();       
        $("#fecha_cirugia_edit").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });	
	
    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();
        $("#fecha_carga_edit").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });	

    $(function() {
        var start_date = new Date ('1910-01-01');
        var end_date = new Date();       
        $("#fecha_alta_edit").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            /*minDate: start_date, */
            maxDate: end_date
        });	
    });
	
    </script>
		
    <?php } ?>		
    <!-- /datepicker -->

    <!-- select2 -->
    <script>
        $(document).ready(function () {
            $(".select2_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
            $(".select2_group").select2({});
            $(".select2_multiple").select2({
                maximumSelectionLength: 10,
                placeholder: "Maximo 10 seguros a seleccionar",
                allowClear: true
            });
        });
    </script>
    <!-- /select2 -->

    <!-- /footer content -->
</body>
</html>