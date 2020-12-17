<?php

if (!defined('ID_NULO')) define("ID_NULO", "0");
if (!defined('STRING_EMPTY')) define("STRING_EMPTY", "");
if (!defined('EXIT_SUCCESS')) define("EXIT_SUCCESS", "0");
if (!defined('EXIT_FAILURE')) define("EXIT_FAILURE", "1");
if (!defined('ACTIVO')) define("ACTIVO", "1");
if (!defined('CERO')) define("CERO", 0);
if (!defined('UNO')) define("UNO", 1);

if (!defined('OKINSERT')) define("OKINSERT", "Registro guardado.");
if (!defined('ERRORINSERT')) define("ERRORINSERT", "No se pudo guardar el registro.");
if (!defined('MSG_WARNING')) define("MSG_WARNING", "warning");
if (!defined('MSG_SUCCESS')) define("MSG_SUCCESS", "success");
if (!defined('MSG_ERROR')) define("MSG_ERROR", "danger");
if (!defined('MSG_INFO')) define("MSG_INFO", "info");
if (!defined('MSG_NOEXIST')) define("MSG_NOEXIST", "El registro no existe.");
if (!defined('ERR_RANGO_DE_FECHA')) define("ERR_RANGO_DE_FECHA", "El rango de fecha y hora es incorrecto.");
if (!defined('ERR_OPERACION')) define("ERR_OPERACION", "Error en la operaci&oacute;n.");

//Modulo permisos
if (!defined('PERMISOFALTANOMBRE')) define("PERMISOFALTANOMBRE", "Debe ingresar un nombre");

//Modulo grupo
if (!defined('GRUPOFALTANOMBRE')) define("GRUPOFALTANOMBRE", "Debe ingresar un nombre");

if (!defined('FALTANOMBRE')) define("FALTANOMBRE", "Debe ingresar un nombre");
if (!defined('CAMPOOBLIGATORIO')) define("CAMPOOBLIGATORIO", "Complete todos los campos obligatorios");

//Modulo usuarios
if (!defined('USUARIOFALTACAMPOS')) define("USUARIOFALTACAMPOS", "Complete todos los campos obligatorios");
if (!defined('USURIONOEXISTEENLDAP')) define("USURIONOEXISTEENLDAP", "Usuario o contrase&ntilde;a incorrecto");
if (!defined('USUARIOBLOQUEADO')) define("USUARIOBLOQUEADO", "Usuario bloqueado. Comun&iacute;quese con el administrador");
if (!defined('USUARIOINCORRECTO')) define("USUARIOINCORRECTO", "El usuario no est&aacute; autorizado a usar el sistema. Comun&iacute;quese con el administrador");
if (!defined('INCIDENTE_ASIGNADO')) define("INCIDENTE_ASIGNADO", 2);
if (!defined('INCIDENTE_RESUELTO')) define("INCIDENTE_RESUELTO", 5);
if (!defined('INCIDENTE_CERRADO')) define("INCIDENTE_CERRADO", 6);

if (!defined('INCIDENTE_ESTADO_NUEVO')) define("INCIDENTE_ESTADO_NUEVO", 1);
if (!defined('INCIDENTE_ESTADO_ENCURSO')) define("INCIDENTE_ESTADO_ENCURSO", 2);
if (!defined('INCIDENTE_ESTADO_ENESPERA')) define("INCIDENTE_ESTADO_ENESPERA", 4);
if (!defined('INCIDENTE_ESTADO_RESUELTO')) define("INCIDENTE_ESTADO_RESUELTO", 5);
if (!defined('INCIDENTE_ESTADO_CERRADO')) define("INCIDENTE_ESTADO_CERRADO", 6);

//Modulo incidente
if (!defined('INCIDENTE_USUARIO_SOLICITANTE')) define("INCIDENTE_USUARIO_SOLICITANTE", "S");
if (!defined('INCIDENTE_USUARIO_OBSERVADOR')) define("INCIDENTE_USUARIO_OBSERVADOR", "O");
if (!defined('INCIDENTE_USUARIO_ASIGNADO')) define("INCIDENTE_USUARIO_ASIGNADO", "A");

if (!defined('INCIDENTE_SEGUIMIENTO_APROBADO')) define("INCIDENTE_SEGUIMIENTO_APROBADO", "A");
if (!defined('INCIDENTE_SEGUIMIENTO_SOLUCION')) define("INCIDENTE_SEGUIMIENTO_SOLUCION", "S");
if (!defined('INCIDENTE_SEGUIMIENTO_INFORMATIVO')) define("INCIDENTE_SEGUIMIENTO_INFORMATIVO", "I");
if (!defined('INCIDENTE_SEGUIMIENTO_TEXTO')) define("INCIDENTE_SEGUIMIENTO_TEXTO", "T");
if (!defined('INCIDENTE_SEGUIMIENTO_RECHAZADO')) define("INCIDENTE_SEGUIMIENTO_RECHAZADO", "R");

//Nota materias
if (!defined('NOTA_UNO')) define("NOTA_UNO", "1");
if (!defined('NOTA_DOS')) define("NOTA_DOS", "2");
if (!defined('NOTA_TRES')) define("NOTA_TRES", "3");
if (!defined('NOTA_CUATRO')) define("NOTA_CUATRO", "4");
if (!defined('NOTA_CINCO')) define("NOTA_CINCO", "5");
if (!defined('NOTA_SEIS')) define("NOTA_SEIS", "6");
if (!defined('NOTA_SIETE')) define("NOTA_SIETE", "7");
if (!defined('NOTA_OCHO')) define("NOTA_OCHO", "8");
if (!defined('NOTA_NUEVE')) define("NOTA_NUEVE", "9");
if (!defined('NOTA_DIEZ')) define("NOTA_DIEZ", "10");
if (!defined('NOTA_AP')) define("NOTA_AP", "11");
if (!defined('NOTA_RE')) define("NOTA_RE", "12");
if (!defined('NOTA_AU')) define("NOTA_AU", "13");
if (!defined('NOTA_EX')) define("NOTA_EX", "14");
if (!defined('NOTA_NOINFORMADO')) define("NOTA_NOINFORMADO", "15");

//Estado alumno
if (!defined('ASPIRANTE')) define("ASPIRANTE", "1");
if (!defined('PREINSCRIPTO')) define("PREINSCRIPTO", "2");
if (!defined('INSCRIPTO')) define("INSCRIPTO", "3");
if (!defined('ALUMNO')) define("ALUMNO", "4");

?>