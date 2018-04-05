                    <div class="menu_section">
                        <h3>&nbsp;</h3>
                        <ul class="nav side-menu">
						<?php if (Session::get("tipo")==1) { ?>
                            <li><a><i class="fa fa-user-md"></i> Medico <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_medico') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_medicos') }}">Consulta</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-user"></i> Paciente <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_paciente') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_paciente') }}">Consulta</a>
                                    </li>                               
                                </ul>
                            </li>
						<?php } ?>
                            <li><a><i class="fa fa-briefcase"></i> Paciente <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <?php if (Session::get("activo")==1) { ?>
                                    <li><a href="{{ URL::asset('nuevo_cirugia') }}">Nuevo</a></li>
                                    <?php } ?>
                                    <li><a href="{{ URL::asset('consulta_cirugia') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>                        
                            <li><a><i class="fa fa-hospital-o"></i> Clinica <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_clinica') }}">Nuevo</a></li>
                                    <li><a href="{{ URL::asset('consulta_clinica') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>
						<?php if (Session::get("tipo")==1) { ?>
                            <li><a><i class="fa fa-medkit"></i> Seguro <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_seguro') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_seguro') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>                                                  
                            <li><a><i class="fa fa-money"></i> Moneda <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_moneda') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_moneda') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>     
                            <!--li><a><i class="fa fa-users"></i> Usuario <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_usuario_sist') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_usuario_sist') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li-->  
                            <li><a><i class="fa fa-dot-circle-o"></i> Especialidades <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('nuevo_especialidad') }}">Nuevo</a>
                                    </li>
                                    <li><a href="{{ URL::asset('consulta_especialidad') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>    
						<?php } ?>
                            <li><a><i class="fa fa-credit-card"></i> Pagos <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
									<?php if (Session::get("activo")==1) { ?>
                                    <!--li><a href="{{ URL::asset('nuevo_pago') }}">Nuevo</a></li-->
									<?php } ?>
                                    <li><a href="{{ URL::asset('nuevo_pago_deudas') }}">Consulta de Pagos 1</a>
                                    <li><a href="{{ URL::asset('nuevo_pago_deudas_2') }}">Consulta de Pagos 2</a>
                                    <li><a href="{{ URL::asset('consulta_pago') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li>
                            <li><a><i class="fa fa-dot-circle-o"></i> Reportes x Paciente <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac') }}">Pacientes</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xcli') }}">Pacientes x Clinica</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xAte') }}">Pacientes x Atención</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xRol') }}">Pacientes x Rol</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xRolxCir') }}">Pacientes x Rol x Cirujano</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xDia') }}">Pacientes x Diagnóstico</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xSegxAte') }}">Pacientes x Seguro x Atención</a></li>
                                    <li><a href="{{ URL::asset('rpts/rpt_med_pac_xAtexCir') }}">Pacientes x Atención x Cirugia</a></li>
                                </ul>
                            </li>    
                            <!--li><a><i class="fa fa-plus"></i> Suscripciones <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
									<?php if (Session::get("activo")==1) { ?>
                                    <li><a href="{{ URL::asset('nuevo_suscripcion') }}">Nuevo</a></li>
									<?php } ?>
                                    <li><a href="{{ URL::asset('consulta_suscripcion') }}">Consulta</a>
                                    </li>  
                                </ul>
                            </li-->                                                                                                                                                             
                        </ul>
                    </div>