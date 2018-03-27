var timer,cartItems,countItems,path;
document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
$(document).ready(function(){
    var countItems = $('#countHidden').val();
    var base_url =  $('input[name=base_url]').val();
    var token =  $('input[name=_token]').val();
    path = window.location.pathname;
    url = window.location.href;
    var res = encodeURI(url);
    console.log(res);

    if(countItems > 0){
        timer = setInterval(checkSeconds,5000);
    }
   var selectedCountry = $('#country').find(':selected').val();
    if(path == '/cards'){
        if(selectedCountry > 0 || (selectedCountry != undefined || selectedCountry != '') ){
            loadState(selectedCountry,base_url,token);
        }
    }

    $('#uDeleteTicket').on('click',function(e){
        e.preventDefault();
        $('#uDelTicket').modal();
    });
    //on change country in filter
    $('#country').on("change",function(){
      var base_url =  $('input[name=base_url]').val();
      var token =  $('input[name=_token]').val();
        $('#city').prop("disabled",true);
        $('#city').children().remove();
        loadState($(this).find(':selected').val(),base_url,token)
    });
    //on change state in filter
    $("#state").change(function () {
        var base_url =  $('input[name=base_url]').val();
        var token =  $('input[name=_token]').val();
        loadCity($(this).find(':selected').val(),base_url,token)
    });

    $('#balanceBtc').on('click',function(){
       $('#myModal4').modal();
    });
    $('#viewData').on('click',function(e){
        e.preventDefault();
        $('#myModal2').modal();
    });
    $('.check').on('click',function(e){
        if(!this.id){
            return false;
        }
        e.preventDefault();
        $(this).prop('disabled',true);
        $(this).html("Checking...");
        checkCard(this.id);
    });
    //add to cart items !
    $('.addToCart').click(function(e){
        var base_url =  $('input[name=base_url]').val();
        var token =  $('input[name=_token]').val();
        var button = $(this);
        e.preventDefault();
            id = this.id;
        $(this).prop('disabled',true);
        $(this).html("Loading...");
        var balance;
        $('#'+id+'').hide();
        balance = $('#blncAmnt').val();
        //@todo change the 1 with 000 or btc amount zero!
        if(balance == 1){
            $('#myModal4').modal();
            $(this).prop('disabled',false);
            $(this).html("Add to Cart");
            $('#'+id+'').show();
            return false;
        }
        else{
            $.ajax({
                url: base_url + '/ajaxAdd',
                type:'POST',
                data:{
                    "_token": token,
                    "id":id
                },
                dataType:'json'
            }).done(function(result){
                if(result['error']){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.error('This item is added by another person.Try another item or try after 60 seconds!', 'Error');
                    }, 1300);
                    button.html('Used item');
                    return false;
                }
                var  countCards = result['countItems'];
                $('span.countItems').html(countCards);
                //this is for hidden count - there is set timer
                $('#countHidden').val(countCards);
                if(countCards == 1){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'fadeIn',
                            timeOut: 7000
                        };
                        toastr.info('You have 60 seconds to order from your cart!', 'Notification');
                    }, 1300);
                    timer = setInterval(checkSeconds,5000);
                }
                button.html('Added');
            });
        }

    });
    //buy Now button in Cards page
    $('.buyNow').on('click',function(e){
        e.preventDefault();
        $('.buyNow').prop('disabled',true);
        $('.addToCart').prop('disabled',true);
        $(this).html("Loading...");
        id = this.id;
        var balance;
        balance = $('#blncAmnt').val();
        //@todo change the 1 with 000 or btc amount zero!
        if(balance == 1){
            $('#myModal4').modal();
            $(this).prop('disabled',false);
            $('.buyNow').html("Buy Now");
            $('.buyNow').prop('disabled',false);
            $('.addToCart').prop('disabled',false);

        }
        else{
            $('<input />').attr('type', 'hidden')
                .attr('name', "cid")
                .attr('value', id)
                .appendTo('#cards');
            $(this).prop('disabled',true);
            $('#cards').submit();
        }

    });
    //remove item from cart's page
    $('.removeItem').on('click',function(e){
        e.preventDefault();
        $(this).prop('disabled',true);
        $(this).html("Loading...");
        var id = this.id;
        removeItem(id,base_url,token);
        $(this).html("Removed");
        $('.row_'+id).remove();
    });
    $('button#buyAll').on('click',function(){
        $('#summary').attr('action',base_url+'/buyAll').submit();
    });
    $('button#genBTC').on('click',function () {
        // $(this).prop('disabled',true);
        $('input#btcAddr').val('Generating...Please wait!');
        generate('btc',token);
    });
    $('#refresh').on('click',function(){
       $(this).html('<i class="fa fa-refresh"></i>CHECKING...');
       $(this).prop('disabled',true);
       refresh(token);
    });

    $('.updateUser').on('click',function(){
        var id = this.id;
        var name = $('input[name="name"]').val();
        var jabber = $('input[name="jabber"]').val();
        var password = $('input[name="pass"]').val();
        updateUser(id,name,jabber,password);
    });
});
function loadState(countryId,url,token){
    $('#state option:first-child').html('Loading..');
    $.ajax({
       type:'POST',
        url:url + '/ajaxState',
        dataType:'json',
        data:{
            "_token": token,
            "get":"state",
            "countryId":countryId
        }
    }).done(function(result){
        $('#state').children().remove();
        $('#state').prop("disabled",false);
        $('#state').prepend('<option selected="selected" value="">Please Select...</option>');
        jQuery.each(result,function(){
           $('#state').append($('<option>',{
               value:this.id,
               text:this.name
           }));
        });
        var base_url =  $('input[name=base_url]').val();
        var token =  $('input[name=_token]').val();
        //loadCity($("#state").find(':selected').val(),base_url,token);
    }).fail(function(){
        $('#state').children().remove();

    });
}

function loadCity(stateId,url,token){
    $('#city option:first-child').html('Loading..');
    $.ajax({
        type:'POST',
        url:url + '/ajaxCity',
        dataType:'json',
        data:{
            "_token": token,
            "get":"city",
            "stateId":stateId
        }
    }).done(function(result){
        $('#city').children().remove();
        $('#city').prop("disabled",false);
        $('#city').prepend('<option selected="selected" value="">Please Select...</option>');
        jQuery.each(result,function(){
            $('#city').append($('<option>',{
                value:this.name,
                text:this.name
            }));
        });
    }).fail(function(){
        $('#city').children().remove();
    });
}

function refresh(token){
    $.ajax({
        url: '/refresh',
        type:'POST',
        data:{
            "_token": token,
        },
        dataType:'json'
    }).done(function(data){

        if(data.balance == false) {
            notify("You haven't active balance yet.<br/>Send coins to the given addresses or wait confirmations!");
            $('#refresh').html('<i class="fa fa-refresh"></i>CHECK BALANCE');
            $('#refresh').prop('disabled',false);
            return;
        }
        if(data.response == false){
            notify("Could not check your balance. Try again later!");
            $('#refresh').html('<i class="fa fa-refresh"></i>CHECK BALANCE');
            $('#refresh').prop('disabled',false);
            return;
        }
        if(data.response == 'success'){
            $('span#balance').fadeOut('slow');
            $('span#balance').html('$'+ data.amount);
            $('span#balance').fadeIn('slow');
            $('#refresh').html('<i class="fa fa-refresh"></i>CHECK BALANCE');
            $('#refresh').prop('disabled',false);
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Your amount pop up into active balance!', 'Success');
            }, 1300);
        }
    });
}
function removeItem(itemId,base_url,token){
    if(itemId){
        $.ajax({
            url: base_url + '/remove',
            type:'POST',
            data:{
                "_token": token,
                "id":itemId
            },
            dataType:'json'
        }).done(function(data){
            if(data.countItems == 0){
                clearInterval(timer);
                timer = 0;
                var msg = 'Your cart is empty!';
                notify(msg);
                $('button#buyAll').remove();
            }
            $('span.countItems').html(data.countItems);
            $('#countHidden').val(data.countItems);
        });
    }
}
function checkSeconds(){
    var base_url =  $('input[name=base_url]').val();
    var token =  $('input[name=_token]').val();
    $.ajax({
        url: base_url + '/checkStatus',
        type:'POST',
        data:{
            "_token": token
        },
        dataType:'json'
    }).done(function(result){
      if(result.removed == 1){
           setTimeout(function() {
               toastr.options = {
                   closeButton: true,
                   progressBar: true,
                   showMethod: 'slideDown',
                   timeOut: 4000
               };
               toastr.error('Time ended.Your cart is empty!', 'Notification');
           }, 1300);

          $('span.countItems').html(0);
          $('#countHidden').val(0);
          var pathname = window.location.pathname;
            if(pathname == '/cart'){
                $('#tblCart').remove();
                showNothingFound();
            }
           clearInterval(timer);
            timer = 0;
       }
    });
}
function notify(msg){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            showMethod: 'fadeIn',
            closeMethod:'fadeOut',
            closeEasing:'swing',
            timeOut: 4000
        };
        toastr.error(msg, 'Notification');
    });
}
function showNothingFound(){

    var table = '<table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">' +
        '<tbody><tr><br/><br/>' +
        '<td rowspan="3" colspan="12" class="text-center"><div class="alert alert-danger">Nothing found!</div></td>' +
        '</tr></tbody></table>';
    $('.summary').html(table);
}

function buyAll(url,token,data){

}

function checkCard(id){
    var base_url =  $('input[name=base_url]').val();
    var token =  $('input[name=_token]').val();
    $.ajax({
        url: base_url + '/check',
        type:'POST',
        data:{
            "_token": token,
            "id":id
        },
        dataType:'json'
    }).done(function(data){
       if(data.overtime){
           notify('Your time was exceeded!');
           $('.check').html('Exceeded');
           return false;
       }
       if(data.checked){
           notify('This card is already checked!');
           $('.check').html('Checked!');
           return false;
       }
        if(data.dead){
            notify('CC is dead,you will receive your funds back!');
            $('.check').html('Not Aproved');
            $('.check').add('i').addClass('fa fa-thumbs-o-down');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-danger');
            return false;
        }
        if(data.timeout){
            notify('Connection timed out.Try again!');
            $('.check').html('Check again');
            $('.check').prop('disabled',false);
            return false;
        }
        if(data.invalid){
            notify('Invalid format or missing fields!');
            $('.check').html('INVALID');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-danger');
            return false;
        }
        if(data.unknown){
            notify('Unknown response.Try again!');
            $('.check').html('UNKNOWN');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-danger');
            return false;
        }
        if(data.cantcheck){
            notify('Checker can`t check the cc.Try later!');
            $('.check').html('Cant`t check!');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-danger');
            return false;
        }
        if(data.error){
            notify('Error!');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-danger');
            return false;
        }
        if(data.live){
            $('.check').html('Aproved');
            $('.check').add('i').addClass('fa fa-thumbs-o-up');
            $('.check').removeClass('btn-warning');
            $('.check').addClass('btn-success');
        }
    });
}

function updateUser(id,name,jabber,password){
    var base_url =  $('input[name=base_url]').val();
    var token =  $('input[name=_token]').val();
    $.ajax({
        url: base_url + '/update',
        type:'POST',
        data:{
            "_token": token,
            "id":id,
            "name":name,
            "email":jabber,
            "password":password
        },
        dataType:'json'
    }).done(function(data){
        if(data.updated == true){
            $('#error-name').html('').hide();
            $('#error-email').html('').hide();
            $('#error-password').html('').hide();
            $('#name').parent().removeClass('has-error');
            $('#email').parent().removeClass('has-error');
            $('#password').parent().removeClass('has-error');
            $('#password').val('');
        }
    }).fail(function(data){
        var errors = $.parseJSON(data.responseText);
        $.each(errors, function (key, value) {
            $('#' + key).parent().addClass('has-error');
            $('#error-' + key).html(value).addClass('text-danger').show();
        });
    });
}

function isOnline(){
    $.ajax({
        url: base_url + '/onlineStatus',
        type:'POST',
        data:{
            "_token": token
        },
        dataType:'json'
    }).done(function(data){
        if(data.offline){
            var statusOnline = isOnline;
            clearInterval(statusOnline);
            statusOnline = 0;
        }
    });
}




