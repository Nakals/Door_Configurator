async function save_send(data) {
    var element = document.getElementsByClassName('configurator_construct_wrapper')[0];
    var contentDataURL;
    await html2canvas(document.querySelector(".configurator_construct_wrapper")).then(canvas => {
        contentDataURL = canvas.toDataURL('image/png');
    });
    
    $.ajax({
                type: 'POST',
                url: 'https://www.contentimo.com/door/Query/sendform.php',
                data: {form:data,image:contentDataURL}
            }).done(function(){
                $('.send_info').text('Данные отправлены');
                $('.send_info').css('display', 'block');
        });
}

$('document').ready(function(){
    $('form.sendForm').submit(function(e) {
        e.preventDefault();
        let valid = true;
        $(".sendForm input[type=text]").each(function(e){
            if($(this).val() == ''){
                valid = false;
            }
        });
  
        if(valid){
            save_send ($('form.sendForm').serialize());
        }
    });
});