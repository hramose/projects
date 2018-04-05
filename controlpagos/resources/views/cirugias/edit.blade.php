<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Session;
use View;
use Form;
use App\Http\Controllers\FuncionesControllers;

?>


@include ('layaout.header_admin')

    {!! Form::open(array('url' => 'guardar_cirugia_edicion', 'method' => 'post', 'class' =>  "form-horizontal", 'files'=>true)) !!}

        <input type="hidden" name="id" value="<?=$id?>" />

                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h2>Consulta de Cirugia</h2>
                        </div>
						<span class="msj">{{ Session::get("mensaje") }}</span>
                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <!-- Smart Wizard -->
                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                        <ul class="wizard_steps">
                                            <li>
                                                <a href="#step-1">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">
                                            Paso 1<br />
                                            <small>Medico</small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-2">
                                                    <span class="step_no">2</span>
                                                    <span class="step_descr">
                                            Paso 2<br />
                                            <small>Clinicas</small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-3">
                                                    <span class="step_no">3</span>
                                                    <span class="step_descr">
                                            Paso 3<br />
                                            <small>Paciente</small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-4">
                                                    <span class="step_no">4</span>
                                                    <span class="step_descr">
                                            Paso 4<br />
                                            <small>Cirugia</small>
                                        </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-5">
                                                    <span class="step_no">5</span>
                                                    <span class="step_descr">
                                            Paso 5<br />
                                            <small>Datos Cirugia</small>
                                        </span>
                                                </a>
                                            </li>                                            
                                        </ul>

                                        @include ('cirugias.paso1_edit')
                                        
                                        @include ('cirugias.paso2_edit')

                                        @include ('cirugias.paso3_edit')
                                        
                                        @include ('cirugias.paso4_edit')

                                        @include ('cirugias.paso5_edit')

                                    </div>
                                    <!-- End SmartWizard Content -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        <br />
        <div class="ln_solid"></div>
    {!! Form::close() !!}

    <!-- form wizard -->
    <script src="../js/wizard/jquery.smartWizard.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Smart Wizard     
            $('#wizard').smartWizard();

            function onFinishCallback() {
                $('#wizard').smartWizard('showMessage', 'Finish Clicked');
                //alert('Finish Clicked');
            }
        });
    </script>    

@include ('layaout.footer_admin')