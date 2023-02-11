async function save_send(data) {
    var element = document.getElementsByClassName('configurator_wrapper')[0];
    var pdf_base = await html2pdf().from(element).set({
        margin: 0.5,
        filename: 'door.pdf',
        html2canvas: {
            scale: 0.8
        },
        jsPDF: {
            orientation: 'landscape',
            unit: 'in',
            format: 'A4',
            compressPDF: true
        }
        
    }).outputPdf();
    
    
    $.ajax({
                type: 'POST',
                url: 'https://www.contentimo.com/door/Query/sendform.php',
                data: {form:data,pdf:btoa(pdf_base)}
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