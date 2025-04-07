document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('baixar').addEventListener('click', function() {
        const element = document.getElementById('pdf');

        const opt = {
            margin:       0.5,
            filename:     'carterinha_associado.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 5 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save();
    });
});