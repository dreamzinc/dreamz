<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
        document.documentElement.classList.add('dark');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
        document.documentElement.classList.remove('dark');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        if (localStorage.getItem('theme')) {
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    });
</script>
<script>
function filterCategory(category) {
    const allCards = document.querySelectorAll('.product-card');
    const allBtns = document.querySelectorAll('.filter-btn');
    
    allBtns.forEach(btn => {
    btn.classList.remove('bg-purple-800');
    btn.classList.add('bg-purple-700');
    });

    if (category === 'all') {
    allCards.forEach(card => {
        card.style.display = 'block';
    });
    } else {
    allCards.forEach(card => {
        if (card.classList.contains(category)) {
        card.style.display = 'block';
        } else {
        card.style.display = 'none';
        }
    });
    }
    
    const selectedBtn = document.getElementById(`${category}-btn`) || document.getElementById('all-btn');
    selectedBtn.classList.remove('bg-purple-700');
    selectedBtn.classList.add('bg-purple-800');
}
</script>