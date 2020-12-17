<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Menu;
use App\Entidades\Especialidad;
use App\Entidades\Agenda;
use App\Entidades\Paciente;
use App\Entidades\Profesional;
use App\Entidades\Turno_estado;
use App\Entidades\Importe;
use App\Entidades\Especialidad_Profesional;

require app_path() . '/start/constants.php';

use Session;

class ControladorTurno extends Controller
{

    public function nuevo()
    {
        $titulo = "Nuevo turno";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("TURNOALTA")) {
                $codigo = "TURNOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
            $especialidad = new Especialidad();
            $array_especialidades = $especialidad->obtenerTodos();
            
            $paciente = new Paciente();
            $array_pacientes = $paciente->obtenerTodos();

            $profesional = new Profesional();
            $array_profesional = $profesional->obtenerTodos();

            $estado = new Turno_estado();
            $array_estado = $estado->obtenerTodos();

            $importe = new Importe();
            $array_importe = $importe->obtenerTodos();

            $espprofesional = new Especialidad_Profesional();
            $array_especialidad_profesional = $espprofesional->obtenerTodos();


            return view('turno.turno-nuevo', compact('titulo', 'array_especialidades', 'array_pacientes', 'array_profesional', 'array_estado', 'array_importe'));
            }
         } else {
                return redirect('admin/turnos');
            }
        }

    public function index()
    {
        $titulo = "Menú";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("TURNOCONSULTA")) {
                $codigo = "TURNOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('turno.turno-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request){
        try {
            $titulo = "Agendar turno";
            $especialidad = new Especialidad();
            $array_especialidades = $especialidad->obtenerTodos();
        
            $paciente = new Paciente();
            $array_pacientes = $paciente->obtenerTodos();

            $profesional = new Profesional();
            $array_profesional = $profesional->obtenerTodos();

            $estado = new Turno_estado();
            $array_estado = $estado->obtenerTodos();

            $importe = new Importe();
            $array_importe = $importe->obtenerTodos();
            
            $entidad = new Agenda();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->fk_idpaciente == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
    
                $_POST["id"] = $entidad->idagenda;
                return view('turno.turno-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idagenda;
        $turno = new Agenda();
        $turno->obtenerPorId($id);

        return view('turno.turno-nuevo', compact('msg', 'turno', 'titulo', 'array_especialidades', 'array_pacientes', 'array_profesional', 'array_estado', 'array_importe')) . '?id=' . $turno->idagenda;
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadAgenda= new Agenda();
        $aAgenda =$entidadAgenda->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aAgenda) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aAgenda) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $aAgenda[$i]->apellido_profesional . ", " . $aAgenda[$i]->nombre_profesional . '</a>';
                $row[] = $aAgenda[$i]->nombre_especialidad;
                $row[] = '<a href="/admin/turno/' . $aAgenda[$i]->idagenda . '">' . date_format(date_create( $aAgenda[$i]->fecha_desde), 'd/m/Y H:i') .'</a>';
                $row[] = $aAgenda[$i]->duracion;
                $row[] = $aAgenda[$i]->documento . " " . $aAgenda[$i]->apellido_paciente . ", " . $aAgenda[$i]->nombre_paciente;
                $row[] = $aAgenda[$i]->nombre_estado;
                $row[] = "$". number_format($aAgenda[$i]->importe, 2, ",",".");
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aAgenda), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aAgenda),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
    public function editar($id)
    {
        $titulo = "Modificar turno";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("TURNOMODIFICACION")) {
                $codigo = "TURNOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $turno = new Agenda();
                $turno->obtenerPorId($id);

                $especialidad = new Especialidad();
                $array_especialidades = $especialidad->obtenerTodos();
        
                $paciente = new Paciente();
                $array_pacientes = $paciente->obtenerTodos();

                $profesional = new Profesional();
                $array_profesional = $profesional->obtenerTodos();

                $importe = new Importe();
                $array_importe = $importe->obtenerTodos();

                $estado = new Turno_estado();
                $array_estado = $estado->obtenerTodos();
            

                return view('turno.turno-nuevo', compact(
                    'turno', 
                    'titulo', 
                    'especialidad', 
                    'paciente', 
                    'profesional', 
                    'importe',
                    'estado',
                    "array_pacientes",
                    "array_profesional",
                    "array_estado",
                    "array_importe",
                    "array_especialidades"));
            }
        } else {
            return redirect('admin/turnos');
        }
    }
    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("TURNOELIMINAR")){

                $turno = new Agenda();
                $turno->idagenda = $id;
                $turno->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "TURNOELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }

    public function buscarEspecialidad(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("TURNOELIMINAR")){

          

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "TURNOELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }



}
