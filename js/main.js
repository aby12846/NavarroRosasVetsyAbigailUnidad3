/**
 * js/main.js - Lógica interactiva de Adopta una Mascota
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Manejo elegante de imágenes que pudieran fallar
    const fallbackDog = 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=800&q=80';
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            if (!this.dataset.triedFallback) {
                this.dataset.triedFallback = 'true';
                this.src = fallbackDog;
            }
        });
    });

    // 2. Filtro interactivo en vivo en el catálogo de mascotas (mascotas.php)
    const searchInput = document.getElementById('searchPet');
    const filterSpecies = document.querySelectorAll('.filter-species-btn');
    const filterAge = document.getElementById('filterAge');
    const filterSize = document.getElementById('filterSize');
    const filterSex = document.getElementById('filterSex');
    const petGrid = document.getElementById('petGrid');
    const petCards = document.querySelectorAll('.pet-col-item');
    const countBadge = document.getElementById('petResultsCount');

    if (petGrid && petCards.length > 0) {
        let currentSpecies = 'all';

        // Eventos para botones rápidos de especie
        filterSpecies.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                filterSpecies.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentSpecies = this.getAttribute('data-species');
                applyFilters();
            });
        });

        // Eventos en campos de entrada
        if (searchInput) searchInput.addEventListener('input', applyFilters);
        if (filterAge) filterAge.addEventListener('change', applyFilters);
        if (filterSize) filterSize.addEventListener('change', applyFilters);
        if (filterSex) filterSex.addEventListener('change', applyFilters);

        function applyFilters() {
            const query = (searchInput ? searchInput.value.toLowerCase().trim() : '');
            const selectedAge = (filterAge ? filterAge.value.toLowerCase() : '');
            const selectedSize = (filterSize ? filterSize.value.toLowerCase() : '');
            const selectedSex = (filterSex ? filterSex.value.toLowerCase() : '');

            let visibleCount = 0;

            petCards.forEach(col => {
                const name = col.getAttribute('data-name')?.toLowerCase() || '';
                const breed = col.getAttribute('data-breed')?.toLowerCase() || '';
                const location = col.getAttribute('data-location')?.toLowerCase() || '';
                const species = col.getAttribute('data-species')?.toLowerCase() || '';
                const age = col.getAttribute('data-age')?.toLowerCase() || '';
                const size = col.getAttribute('data-size')?.toLowerCase() || '';
                const sex = col.getAttribute('data-sex')?.toLowerCase() || '';

                const matchesQuery = !query || name.includes(query) || breed.includes(query) || location.includes(query);
                const matchesSpecies = (currentSpecies === 'all' || species === currentSpecies);
                const matchesAge = (!selectedAge || age === selectedAge);
                const matchesSize = (!selectedSize || size === selectedSize);
                const matchesSex = (!selectedSex || sex === selectedSex);

                if (matchesQuery && matchesSpecies && matchesAge && matchesSize && matchesSex) {
                    col.style.display = '';
                    visibleCount++;
                } else {
                    col.style.display = 'none';
                }
            });

            if (countBadge) {
                countBadge.textContent = `${visibleCount} mascota${visibleCount === 1 ? '' : 's'} encontrada${visibleCount === 1 ? '' : 's'}`;
            }

            // Mostrar u ocultar mensaje de "no hay resultados"
            const noResults = document.getElementById('noResultsMessage');
            if (noResults) {
                noResults.classList.toggle('d-none', visibleCount > 0);
            }
        }
    }

    // 3. Confirmaciones de borrado para el panel administrativo
    document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const itemName = this.getAttribute('data-item') || 'este elemento';
            if (!confirm(`¿Estás seguro de que deseas eliminar ${itemName}? Esta acción no se puede deshacer.`)) {
                e.preventDefault();
            }
        });
    });

    // 4. Auto-dismiss de alertas flash tras 6 segundos
    const flashAlerts = document.querySelectorAll('.alert-dismissible');
    flashAlerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 6000);
    });

    // 5. Selector interactivo para Google Maps de Centros de Adopción
    const shelterCards = document.querySelectorAll('.shelter-card');
    const shelterMapIframe = document.getElementById('shelterMapIframe');

    if (shelterCards.length > 0 && shelterMapIframe) {
        shelterCards.forEach(card => {
            card.addEventListener('click', function() {
                const mapUrl = this.getAttribute('data-map-url');
                if (mapUrl) {
                    shelterCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    shelterMapIframe.src = mapUrl;
                }
            });
        });
    }
});

