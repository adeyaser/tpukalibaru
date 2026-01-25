<!-- Icon Picker Modal -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="iconSearch" placeholder="Cari icon...">
                </div>
                
                <ul class="nav nav-tabs mb-3" id="iconTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bi-tab" data-bs-toggle="tab" data-bs-target="#bi-content" type="button" role="tab">Bootstrap Icons</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fa-tab" data-bs-toggle="tab" data-bs-target="#fa-content" type="button" role="tab">Font Awesome</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="iconTabContent">
                    <div class="tab-pane fade show active" id="bi-content" role="tabpanel">
                        <div class="row row-cols-4 row-cols-md-6 g-3" id="bi-icons-container">
                            <!-- Icons will be populated by JS -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fa-content" role="tabpanel">
                        <div class="row row-cols-4 row-cols-md-6 g-3" id="fa-icons-container">
                             <!-- Icons will be populated by JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.querySelector('input[name="icon"]');
    if (!iconInput) return;

    const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
    
    // Open modal on click
    iconInput.addEventListener('click', function() {
        modal.show();
    });
    
    // Icon Data
    const biIcons = [
        'bi-house', 'bi-grid', 'bi-people', 'bi-person', 'bi-file-text', 'bi-gear', 'bi-list', 
        'bi-trash', 'bi-pencil', 'bi-plus-circle', 'bi-search', 'bi-bell', 'bi-calendar',
        'bi-wallet', 'bi-cash', 'bi-bank', 'bi-graph-up', 'bi-folder', 'bi-flower1', 'bi-flower2',
        'bi-heart', 'bi-star', 'bi-check-circle', 'bi-exclamation-circle', 'bi-info-circle',
        'bi-geo-alt', 'bi-map', 'bi-clock', 'bi-envelope', 'bi-telephone', 'bi-printer',
        'bi-download', 'bi-upload', 'bi-box-arrow-right', 'bi-box-arrow-in-right', 'bi-power'
    ];
    
    const faIcons = [
        'fa-solid fa-user', 'fa-solid fa-users', 'fa-solid fa-house', 'fa-solid fa-gear', 
        'fa-solid fa-folder', 'fa-solid fa-file', 'fa-solid fa-book', 'fa-solid fa-calendar',
        'fa-solid fa-money-bill', 'fa-solid fa-chart-simple', 'fa-solid fa-pen', 'fa-solid fa-trash',
        'fa-solid fa-plus', 'fa-solid fa-minus', 'fa-solid fa-check', 'fa-solid fa-xmark',
        'fa-solid fa-mosque', 'fa-solid fa-church', 'fa-solid fa-cross', 'fa-solid fa-star-and-crescent',
        'fa-solid fa-hand-holding-heart', 'fa-solid fa-dove', 'fa-solid fa-clipboard-list',
        'fa-solid fa-print', 'fa-solid fa-receipt', 'fa-solid fa-sack-dollar'
    ];

    // Render Icons
    function renderIcons(containerId, icons, isBi) {
        const container = document.getElementById(containerId);
        container.innerHTML = icons.map(icon => `
            <div class="col text-center icon-item" data-icon="${icon}" style="cursor: pointer;">
                <div class="p-3 border rounded hover-bg-light">
                    <i class="${isBi ? 'bi ' + icon : icon} fs-3 mb-2"></i>
                    <div class="small text-truncate" style="font-size: 0.7em;">${icon}</div>
                </div>
            </div>
        `).join('');
    }

    renderIcons('bi-icons-container', biIcons, true);
    renderIcons('fa-icons-container', faIcons, false);

    // Search functionality
    document.getElementById('iconSearch').addEventListener('keyup', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.icon-item').forEach(item => {
            const iconName = item.getAttribute('data-icon');
            if (iconName.includes(term)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Handle icon selection
    document.querySelectorAll('.icon-item').forEach(item => {
        item.addEventListener('click', function() {
            const icon = this.getAttribute('data-icon');
            iconInput.value = icon;
            modal.hide();
        });
    });
});
</script>

<style>
.hover-bg-light:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd !important;
}
</style>
