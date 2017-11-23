$('.itemName').select2({
      placeholder: 'Start typing property address... ',
      ajax: {
        url: 'PHP/propertyList.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });

    $(document).ready(function(){
    $('input#agentID').on('keyup keypress blur focus',function(){
        var agentID = $('input#agentID').val(); 

        if(isNaN(agentID)){
           $('div#agentID').attr('class', 'form-group has-error has-feedback');
            $('span#agentID').attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        if(!isNaN(agentID)){
           $('div#agentID').attr('class', 'form-group has-success has-feedback');
            $('span#agentID').attr('class', 'glyphicon glyphicon-ok form-control-feedback');
            $("input#submit").prop('disabled', false);
        }
        if(agentID.length < 7){
           $('div#agentID').attr('class', 'form-group has-warning has-feedback');
            $('span#agentID').attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        console.log(agentID);
    });
    $("input#fname").on('keyup keypress blur focus',function(){
        var fname = $('input#fname').val(); 

        if(!isNaN(fname)){
           $('div#fname').attr('class', 'form-group has-error has-feedback');
            $('span#fname').attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        if(fname.length > 4){
           $('div#fname').attr('class', 'form-group has-success has-feedback');
            $('span#fname').attr('class', 'glyphicon glyphicon-ok form-control-feedback');
            $("input#submit").prop('disabled', false);
        }
        if(fname.length < 4){
           $('div#fname').attr('class', 'form-group has-warning has-feedback');
            $('span#fname').attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        console.log(fname);
    });
    $("input#ofcname").on('keyup keypress blur focus',function(){
        var ofcname = $('input#ofcname').val(); 

        if(!isNaN(ofcname)){
           $('div#ofcname').attr('class', 'form-group has-error has-feedback');
            $('span#ofcname').attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        if(ofcname.length > 4){
           $('div#ofcname').attr('class', 'form-group has-success has-feedback');
            $('span#ofcname').attr('class', 'glyphicon glyphicon-ok form-control-feedback');
            $("input#submit").prop('disabled', false);
        }
        if(ofcname.length < 4){
           $('div#ofcname').attr('class', 'form-group has-warning has-feedback');
            $('span#ofcname').attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        console.log(ofcname);
    });
     $("input#phone").on('keyup keypress blur focus',function(){
        var phone = $('input#phone').val(); 

        if(isNaN(phone)){
           $('div#phone').attr('class', 'form-group has-error has-feedback');
            $('span#phone').attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        if(!isNaN(phone)){
           $('div#phone').attr('class', 'form-group has-success has-feedback');
            $('span#phone').attr('class', 'glyphicon glyphicon-ok form-control-feedback');
            $("input#submit").prop('disabled', false);
        }
        if(phone.length < 10){
           $('div#phone').attr('class', 'form-group has-warning has-feedback');
            $('span#phone').attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
            $("input#submit").prop('disabled', true);
        }
        console.log(phone);
    });
});