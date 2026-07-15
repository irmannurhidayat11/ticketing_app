<script>
    let ticketCount = 0;
    function addTicket() {
        const container = document.getElementById('ticket-container');
        const div = document.createElement('div');
        div.className = 'card bg-base-200 p-4 mb-2';
        div.innerHTML = `
            <div class="grid grid-cols-3 gap-4">
                <select name="tikets[${ticketCount}][tipe]" class="select"><option value="reguler">Reguler</option><option value="premium">Premium</option></select>
                <input type="number" name="tikets[${ticketCount}][harga]" placeholder="Harga" class="input">
                <input type="number" name="tikets[${ticketCount}][stok]" placeholder="Stok" class="input">
            </div>`;
        container.appendChild(div);
        ticketCount++;
    }
    // Tambahkan tiket otomatis saat load
    addTicket();
</script>