/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready(function() {
    $( ".menu-button" ).click(function() {
        var name = $( this ).data('name');
        var ruta = $( this ).data('ruta');
        var info = $( this ).data('info');
        var data = JSON.stringify({ info: info, data: name });
        _ajaxPetition(ruta, data, name);        
    });
});

_ajaxPetition = function(ruta, data, name){
    $.ajax(ruta, {
        type: 'POST',  // http method
        data: data,
        processData: false,
        contentType: "application/json; charset=UTF-8",
        success: function (data, status, xhr) {
            var data = JSON.parse(data);
            if(data.code == 200){
                if(data.result == '' || data.result.error){
                    if(data.result.error){
                        $('#content').html(data.result.error);
                    }else{
                        $('#content').html('No se encontró información');
                    }                    
                }else{
                    switch(name){
                        case 'registrar_materias':
                            $('#content').html(_register(data.result));                            
                            break;
                        case 'guardar_materias':
                            $( ".menu-button" ).each(function() {
                                if($(this).data('name') == 'ver_materias'){
                                    $(this).trigger( "click" );
                                }
                            });
                            break;
                        case 'ver_materias':
                            $('#content').html(_view(data.result));
                            break;
                    }                    
                }
            }
            $('#sidebar').addClass('inactive');
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log(jqXhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}

_view = function (data){
    var table = '<table id="materias_estudiante">';    
        table += '<tr><th>Materia</th><th>Profesor</th><th>Estudiantes</th></tr>' ;
    $.each(data.estudiante, function (i, item) {
        table += '<tr>';
            table += '<td>'+item.nombre_materia+'</td><td>'+item.nombre_profesor+' '+item.apellido_profesor+'</td>';
            table += '<td>';
            $.each(data.companeros, function (i, itemCompanero) {
                if(item.id_materia == itemCompanero.id_materia && item.id_profesor == itemCompanero.id_profesor){
                    table += itemCompanero.nombre_estudiante+' '+itemCompanero.apellido_estudiante+'<br>';
                }                
            });
            table += '</td>';
        table += '</tr>';
    });

    table += '</table>';
    
    return table;
};

_register = function (data){
    
    var form = $("<form id='registrar_materias' name='registrar_materias' method='POST' action='/registrar_materias'></form>");
    var selectMaterias = "<select id='materias' name='materias'>";
    $.each(data.materias, function (i, item) {        
        selectMaterias += "<option value="+item.id+">"+item.nombre+"</option>";
    });
    selectMaterias += "</select>";
    form.append(selectMaterias);
    
    var selectProfesores = "<select id='profesores' name='profesores'>";
    $.each(data.profesores, function (i, item) {
        selectProfesores += "<option value="+item.id+">"+item.nombres+" "+item.apellidos+"</option>";
    });
    selectProfesores += "</select>";
    form.append(selectProfesores);
    form.append('<input type="hidden" id="info" value="'+data.info+'">');
    form.append('<br><input class="registrar" type="button" id="registrar" value="Registrar">');   
    $(document).on('click',".registrar", function(){
        var name = 'guardar_materias';
        var ruta = '/v1/inter/registrar/materias';
        var materias = $('#materias').val();
        var profesores = $('#profesores').val();
        var info = $('#info').val();
        var data = JSON.stringify({ info: info, materias: materias, profesores: profesores });
        _ajaxPetition(ruta, data, name);
    });
    return form;
};
