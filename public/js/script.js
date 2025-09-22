const searchInput = document.getElementById('student-search');
const searchbar = document.querySelector('.searchbar');
const dropdown = document.getElementById('search-dropdown');

const students = window.students || [];

let currentFocus = -1;

searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    dropdown.innerHTML = '';
    currentFocus = -1;

    if (query.length === 0) {
        dropdown.style.display = 'none';
        return;
    }

    const matches = students.filter(s =>
        s.studentName.toLowerCase().startsWith(query)
    );

    if (matches.length === 0) {
        dropdown.style.display = 'none';
        return;
    }

    matches.forEach((s) => {
        const option = document.createElement('div');
        option.textContent = s.studentName;
        option.tabIndex = 0;
        option.addEventListener('mousedown', function () {
            window.location.href = `detailstudent.php?studentId=${s.studentId}`;
        });
        dropdown.appendChild(option);
    });

    dropdown.style.display = 'block';
});

// Keyboard navigatie
searchInput.addEventListener('keydown', function (e) {
    const items = dropdown.querySelectorAll('div');
    if (!items.length || dropdown.style.display === 'none') return;

    if (e.key === 'ArrowDown') {
        currentFocus++;
        if (currentFocus >= items.length) currentFocus = 0;
        setActive(items, currentFocus);
        e.preventDefault();
    }
    if (e.key === 'ArrowUp') {
        currentFocus--;
        if (currentFocus < 0) currentFocus = items.length - 1;
        setActive(items, currentFocus);
        e.preventDefault();
    }
    if (e.key === 'Enter' && currentFocus > -1) {
        items[currentFocus].dispatchEvent(new MouseEvent('mousedown'));
        e.preventDefault();
    }
});

function setActive(items, index) {
    items.forEach((item, i) => {
        if (i === index) {
            item.style.backgroundColor = '#2e1a85';
            item.style.color = '#fff';
            item.scrollIntoView({ block: 'nearest' });
        } else {
            item.style.backgroundColor = '#fff';
            item.style.color = '#2e1a85';
        }
    });
}

// Zoekbalk openen/sluiten
searchInput.addEventListener('focus', () => {
    searchbar.classList.add('open');
    if (dropdown.innerHTML.trim() !== '') {
        dropdown.style.display = 'block';
    }
});
searchInput.addEventListener('blur', () => {
    setTimeout(() => {
        searchbar.classList.remove('open');
        dropdown.style.display = 'none';
        currentFocus = -1;
    }, 200); // kleine delay voor klik op dropdown
});

// Verberg dropdown als je buiten klikt
document.addEventListener('click', function (e) {
    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
        searchbar.classList.remove('open');
        dropdown.style.display = 'none';
        currentFocus = -1;
    }
});
