$(document).ready(function() {
    console.log( "ready!" );
    $("#email_input").removeClass('d-flex').addClass('d-none');
    $("#num_input").removeClass('d-flex').addClass('d-none');
    $("#pwd_input").removeClass('d-flex').addClass('d-none');
    console.log( $( ".login-form select" ).text() );
    $( ".login-form select" ).change(function() {
        console.log( $( ".login-form select option:selected" ).val() );
        if($( ".login-form select option:selected" ).val() === '1'){
            console.log( "etudiant!" );
            $("#num_input input").attr('required', true);
            $("#email_input input").attr('required', false);
            $("#email_input").removeClass('d-flex').addClass('d-none');
            $("#num_input").addClass('d-flex').removeClass('d-none');
            $("#pwd_input").addClass('d-flex').removeClass('d-none');
        }
        else{
            console.log( "pas etudiant" );
            $("#email_input input").attr('required', true);
            $("#num_input input").attr('required',false);
            $("#email_input").addClass('d-flex').removeClass('d-none');
            $("#num_input").removeClass('d-flex').addClass('d-none');
            $("#pwd_input").addClass('d-flex').removeClass('d-none');
        }
    });

   
});