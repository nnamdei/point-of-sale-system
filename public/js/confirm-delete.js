function confirmDelete(trigger,confirmationContainer){
    var container = document.querySelector('#'+confirmationContainer);
    var form = container.querySelectorAll('form')[0];
    var no = container.querySelectorAll('.confirm-no')[0];
    var yes = container.querySelectorAll('.confirm-yes')[0];
    
    if(container.style.display == '' || container.style.display == 'none'){
        container.style.display = 'block';//show the confirmation dialog
    }else{
        container.style.display = 'none';//hide the confirmation dialog
    }

    no.addEventListener('click',function(){
        container.style.display = 'none';
    });
    yes.addEventListener('click',function(){
        form.submit();
    });
}