function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            this.Livewire.processTicket(decodedText);
            console.log(`Scan result: ${decodedText}`, decodedResult);
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 500 });
        html5QrcodeScanner.render(onScanSuccess);
        Livewire.on('ticketProcessed', context => {
            console.log(context)
            alert('A post was added with the id of: ' + context['success']);
        })