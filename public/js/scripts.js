
$('document').ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html: true
        })
      })

    $(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        })
      })
      
    $('#app-modal').on('show.bs.modal', function(e){
        var _trigger = $(e.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title').html(_trigger.data('title'));
        modal.find('.modal-body').html($(_trigger.data('content')).clone());
      });

      $('#app-modal').on('hidden.bs.modal', function (e) {
        $('.modal-title').empty();
        $('.modal-body').empty();
    });

    function simpleProduct(){
        $('div#simple-stocks').show();
          $('div#variants-container').hide();
      }

    function variableProduct(){
              $('div#variants-container').show();
              $('div#simple-stocks').hide();
      }

          
    /**
     * 
     * @param {*} original original content to duplicate
     * @param {*} container container to add the duplicate to
     */
    function duplicate(original,container){
        var duplicate = container.replace('.','')+'-duplicate-'+$(container).find(original).length;//unique indentifier for each duplicate
        var newItem = $(container).find(original).eq(0).clone().attr('duplicate',duplicate);
        newItem.find('input').val('');//if there is any input inside, cleaer the values
        var removerContainer = $('<div></div>').attr('class','text-right text-danger');
        var remover = $('<span></span>').attr('class','fa fa-minus-circle text-right').attr('remove', duplicate);
        removerContainer.append(remover);
        newItem.children().first().before(removerContainer);
        $(container).append(newItem);
        $(container).on('click', '[remove = "'+duplicate+'"]', function(e){
            $(container).find("[duplicate = '"+duplicate+"']").remove()
        })
          
    }


function confirmDelete(trigger,confirmationContainer){
    var container = $('#'+confirmationContainer);
    var form = container.find('form');
    var no = container.find('.confirm-no');
    var yes = container.find('.confirm-yes');
    container.toggle();
    no.bind('click',function(e){
        container.hide();
    })
    yes.bind('click',function(){
        form.submit();
    });
}

    
      if($("select#product-type-selector option[selected]").val() == 'simple'){
        simpleProduct()
      }else if($("select#product-type-selector option[selected]").val() == 'variable'){
        variableProduct();
      }
    
       $('select#product-type-selector').bind('change',function(e){
         
           if($(this).val() == 'variable'){
                variableProduct();
           }
           else if($(this).val() == 'simple'){
                simpleProduct();
           }
        });

        


});
 
