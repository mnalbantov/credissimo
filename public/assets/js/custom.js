var timer,cartItems,countItems;
$(document).ready(function(){
    var countItems = $('#countHidden').val();
    var base_url =  $('input[name=base_url]').val();
    var token =  $('input[name=_token]').val();
    if(countItems > 0){
        timer = setInterval(checkSeconds,10000);
    }
   var selectedCountry = $('#country').find(':selected').val();
    if(selectedCountry > 0 || (selectedCountry != undefined || selectedCountry != '') ){
        loadState(selectedCountry,base_url,token);
    }

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
                //$('#cc_list').prepend(item);
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.success('Your item is added to cart!', 'Notification');
                }, 1300);
                if(countCards == 1){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 6000
                        };
                        toastr.info('You have 60 seconds to order from your cart!', 'Notification');
                    }, 1600);
                    timer = setInterval(checkSeconds,10000);
                }
                button.html('Added');
            });
        }

    });
    //buy Now button in Cards page
    $('.buyNow').on('click',function(e){
        e.preventDefault();
        $(this).prop('disabled',true);
        $(this).html("Loading...");
        id = this.id;
        var balance;
        balance = $('#blncAmnt').val();
        //@todo change the 1 with 000 or btc amount zero!
        if(balance == 1){
            $('#myModal4').modal();
            $(this).prop('disabled',false);
            $(this).html("Buy Now");
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
    $('input#getBTC').on('focus',function(){
        alert('heeheheh');
    })
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
          $('#tblCart').remove();
          showNothingFound();
           clearInterval(timer);
            timer = 0;
       }
    });
}
function notify(msg){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.error(msg, 'Notification');
    }, 1300);
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



