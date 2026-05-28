const savedTheme = localStorage.getItem('theme') || 'light';
applyTheme(savedTheme);

document.getElementById('darkModeBtn').addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-bs-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    localStorage.setItem('theme', next);
});

function applyTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    const icon = document.getElementById('darkModeIcon');
    icon.className = theme === 'dark' ? 'fi fi-rr-sun' : 'fi fi-rr-moon';
}

const sidebarToggle = document.getElementById('sidebarToggle');
const body = document.body;

if (localStorage.getItem('sidebar') === 'collapsed') {
    body.classList.add('sidebar-collapsed');
}

sidebarToggle.addEventListener('click', () => {
    body.classList.toggle('sidebar-collapsed');
    const isCollapsed = body.classList.contains('sidebar-collapsed');
    localStorage.setItem('sidebar', isCollapsed ? 'collapsed' : 'expanded');
});

document.querySelectorAll('.nav-item').forEach(item => {
    const label = item.querySelector('.nav-label');
    if (label) {
        item.setAttribute('data-tooltip', label.textContent.trim());
    }
});