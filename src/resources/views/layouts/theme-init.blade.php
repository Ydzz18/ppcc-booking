<script>
    (() => {
        let theme;

        try {
            theme = localStorage.getItem('theme');
        } catch (error) {}

        if (theme !== 'dark' && theme !== 'light') {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        document.documentElement.classList.toggle('dark', theme === 'dark');
        document.documentElement.setAttribute('data-theme', theme);
    })();
</script>