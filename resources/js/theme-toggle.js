
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const lightIcon = document.querySelector('.light-icon');
    const darkIcon = document.querySelector('.dark-icon');
    const currentTheme = localStorage.getItem('theme') || 'light';
  
    if (currentTheme === 'dark') {
      document.documentElement.classList.add('dark');
      lightIcon.classList.add('hidden');
      darkIcon.classList.remove('hidden');
    } else {
      document.documentElement.classList.remove('dark');
      lightIcon.classList.remove('hidden');
      darkIcon.classList.add('hidden');
    }
  
    themeToggle.addEventListener('click', function() {
      document.documentElement.classList.toggle('dark');
      let theme = 'light';
  
      if (document.documentElement.classList.contains('dark')) {
        theme = 'dark';
        lightIcon.classList.add('hidden');
        darkIcon.classList.remove('hidden');
      } else {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      }
  
      localStorage.setItem('theme', theme);
    });
  });
  