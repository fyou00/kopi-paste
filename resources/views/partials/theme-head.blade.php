<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=JetBrains+Mono:wght@500;600;700&family=Playfair+Display:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    espresso: '#1A110B',
                    roast: '#2D1B12',
                    brown: '#6B4423',
                    caramel: '#C67A34',
                    gold: '#E8B86D',
                    'gold-dark': '#D49E48',
                    cream: '#FAF5EE',
                    latte: '#EFE4D6',
                },
                fontFamily: {
                    sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    serif: ['Playfair Display', 'Georgia', 'serif'],
                    script: ['Dancing Script', 'cursive'],
                    mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
                }
            }
        }
    };
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/kopi-paste.css') }}">
