function convertHTMLToPDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('1', 'mm', [880, 1200]);
    var pdfjs = document.getElementById('html-template');
    var fileName = 'invoice_' + Date.now() + '.pdf';

    doc.html(pdfjs, {
        callback: function (doc) {
            var pdfData = doc.output('blob');
            var formData = new FormData();
            formData.append('pdf', pdfData, fileName);
            fetch('save_to_server.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.text();
            })
			.then(data => {
				console.log(data);
			})
            .catch(error => {
                console.error('Error uploading PDF file:', error);
            });
        },
        x: 10,
        y: 10
    });
}