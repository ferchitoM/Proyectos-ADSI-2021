function generarPDF(div, nombre_archivo, nueva_ventana) {
    
    const pagina = document.getElementById(div);

    var opt = {
        margin: 0, //[0.5, 0.5, 0.5, 0.5],
        filename: nombre_archivo + '.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 3,
            width: 1060,
            height: 680,
            windowWidth: 1050,
            windowHeight: 680,
        },
        jsPDF: {
            unit: 'px', //en centimetros
            format: [1050, 680],
            orientation: 'landscape',
            hotfixes: ["px_scaling"],
        }
    };

    //SI SE DESEA VER EL PDF EN UNA NUEVA VENTANA
    if(nueva_ventana) {

        html2pdf().set(opt).from(pagina).toPdf().get('pdf').then(function(pdf) {
            window.open(pdf.output('bloburl'), '_blank');
        });

    }

    //SINO ENTONCES SE DESCARGA
    return html2pdf().set(opt).from(pagina);
    
}