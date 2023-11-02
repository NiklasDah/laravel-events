<div class="bg-white" wire:ignore>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div id="notification" class="h-0 flex justify-center align-center text-center text-white transition-all">
    </div>
    <a class="hidden bg-green-500 bg-orange-500 bg-red-500">This is so that the classes can generate</a>
    <div class="w-full h-full" id="reader"></div>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            @this.processTicket(decodedText);
            console.log(`Scan result: ${decodedText}`, decodedResult);
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 500 });
        html5QrcodeScanner.render(onScanSuccess);
        document.addEventListener('livewire:initialized', () => {
            @this.on('ticketProcessed', context  => {
                context = context[0];
                notification = document.getElementById("notification");
                notification.innerText = context["message"];
                notification.classList.add(context["class"]);
                notification.classList.add("h-20");
                notification.classList.remove("h-0");
                if(context["followup"]) {
                    override = confirm(context['message'])
                    if(override) {
                        @this.processTicket(context['ticket'], true);
                    }
                }
                setTimeout(() => {
                    notification.classList.remove(context["class"]);
                    notification.classList.remove("h-20");
                    notification.classList.add("h-0");
                    notification.innerText = "";
                }, 5000);
            });
        });
    </script>
</div>
