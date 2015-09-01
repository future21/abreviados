$(document).ready(function(){ //cuando el html fue cargado iniciar
   $('#tabla_lista_usuarios').dataTable();


    //a�ado la posibilidad de editar al presionar sobre edit
    $('#tabla_lista_usuarios tbody').on('click','.edit', function(){
        //this = es el elemento sobre el que se hizo click en este caso el link
        //obtengo el id que guardamos en data-id
        var id=$(this).attr('data-id');
        //preparo los parametros
        params={};
        params.id=id;
        params.action="edit2Client";
        $('#popupbox').load('main.php', params,function(){
            $('#block').show();
            $('#popupbox').show();
        })

    })

    $('#tabla_lista_usuarios tbody').on('click','.delete',function(){
        //obtengo el id que guardamos en data-id
        var id=$(this).attr('data-id');
        //preparo los parametros
        params={};
        params.id=id;
        params.action="delete2Client";
        $('#popupbox').load('main.php', params,function(){
            $('#content').load('main.php',{action:"refreshGrid"});
        })
        location.reload(true);


    })

    $(document).on('click','.button',function(){
        params={};
        params.action="new2Client";
        $('#popupbox').load('main.php', params,function(){
            $('#block').show();
            $('#popupbox').show();
        })
    })

    // boton cancelar, uso live en lugar de bind para que tome cualquier boton
    // nuevo que pueda aparecer
    $('#cancel').live('click',function(){
        $('#block').hide();
        $('#popupbox').hide();
    })


     $('#client').live('submit',function(){
        var params={};
        params.action='save2Client';
        params.id=$('#id').val();
        params.nombre=$('#nombre').val();
        params.apellido=$('#apellido').val();
        params.email=$('#email').val();
        params.encrypted_password=$('#encrypted_password').val();
        params.salt=$('#salt').val();
        params.created_at=$('#created_at').val();

        params.adm_=$('#adm_').val();
        params.adm=$('#adm').val();
        //Alert($('#adm').val());

        $.post('index.php',params,function(){
            $('#block').hide();
            $('#popupbox').hide();
            $('#content').load('main.php',{action:"refresh2Grid"});
        })
        location.reload(true);
        return false;
    })



     $('#pass').live('click',function(){
        var params={};
        params.id=$('#id').val();
        params.email=$('#email').val();
        params.action="pass";

        $('#popupbox').load('main.php', params,function(){
            $('#block').hide();

            $('#popupbox').hide();

        })


        //location.reload(true);
        return false;

     })

})

NS={};
