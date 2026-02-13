/* Food Slider Logic */
document.addEventListener('DOMContentLoaded', function () {
    const sliderData = [
        {
            title: "ROYAL<br>MASALA DOSA",
            badge: "NEW",
            spiciness: 2, // 1-3 scale
            desc: "A crispy, golden-brown fermented crepe stuffed with a spiced potato filling. Served with coconut chutney and tangy sambar. A South Indian classic.",
            price: "₹150",
            oldPrice: "₹180",
            image: "https://images.unsplash.com/photo-1589301760014-d929f3979dbc?auto=format&fit=crop&q=80&w=600", // Dosa
            calories: "320",
            fat: "8g",
            protein: "6g",
            color: "#FFC107" // Saffron/Yellow
        },
        {
            title: "HYDERABADI<br>CHICKEN BIRYANI",
            badge: "BESTSELLER",
            spiciness: 3,
            desc: "Aromatic basmati rice cooked with tender chicken, exotic spices, and saffron. Served with raita and mirchi ka salan. The crown jewel of Hyderabadi cuisine.",
            price: "₹350",
            oldPrice: "₹450",
            image: "https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&q=80&w=600", // Biryani
            calories: "550",
            fat: "18g",
            protein: "25g",
            color: "#FF9800" // Orange
        },
        {
            title: "CLASSIC<br>IDLI VADA",
            badge: "BREAKFAST",
            spiciness: 1,
            desc: "Soft, fluffy steamed rice cakes paired with crispy savory donuts (vada). A healthy, protein-packed breakfast served with trio chutneys.",
            price: "₹120",
            oldPrice: "₹150",
            image: "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=600", // Idli Vada
            calories: "280",
            fat: "5g",
            protein: "8g",
            color: "#8BC34A" // Light Green
        },
        {
            title: "KERALA<br>FISH CURRY",
            badge: "SIGNATURE",
            spiciness: 3,
            desc: "Spicy and tangy fish curry cooked with cambodge (kudampuli) and coconut milk. Best enjoyed with steamed tapioca or rice.",
            price: "₹280",
            oldPrice: "₹320",
            image: "https://images.unsplash.com/photo-1610057099443-fde8c4d50f91?auto=format&fit=crop&q=80&w=600", // New Fish Curry Image
            calories: "320",
            fat: "14g",
            protein: "22g",
            color: "#E64A19" // Deep Orange
        },
        {
            title: "VEN<br>PONGAL",
            badge: "TRADITIONAL",
            spiciness: 1,
            desc: "Comfort food made of rice and lentils, seasoned with cumin, ginger, black pepper, and curry leaves in ghee. Melt in your mouth goodness.",
            price: "₹100",
            oldPrice: "₹130",
            image: "https://images.unsplash.com/photo-1514843319088-335682855f41?auto=format&fit=crop&q=80&w=600", // Pongal (Generic South Indian dish image)
            calories: "350",
            fat: "12g",
            protein: "10g",
            color: "#FBC02D"
        }
    ];

    let currentIndex = 0;

    // PRELOAD IMAGES to prevent lag/flash
    sliderData.forEach(item => {
        const img = new Image();
        img.src = item.image;
    });

    const dom = {
        title: document.querySelector('.slider-title'),
        badge: document.querySelector('.food-slider-section .badge'),
        description: document.querySelector('.slider-description'),
        price: document.querySelector('.price-tag .fw-bold'),
        oldPrice: document.querySelector('.price-tag .text-muted'),
        image: document.querySelector('.food-img'),
        spiciness: document.querySelector('.spiciness'),
        bgCol: document.querySelector('.slider-image-col'),
        nutriCal: document.querySelector('.nutrition-cards > div:nth-child(1) span'),
        nutriFat: document.querySelector('.nutrition-cards > div:nth-child(2) span'),
        nutriProt: document.querySelector('.nutrition-cards > div:nth-child(3) span'),
        btnNext: document.getElementById('nextFood'),
        btnPrev: document.getElementById('prevFood')
    };

    function updateSpiciness(level) {
        let html = '';
        for (let i = 0; i < 3; i++) {
            if (i < level) html += '<i class="fa fa-fire text-danger"></i> ';
            else html += '<i class="fa fa-fire-o text-muted"></i> ';
        }
        const text = level === 1 ? 'Mild' : level === 2 ? 'Medium Spicy' : 'Spicy';
        html += `<span class="text-muted ms-2 fs-6 text-uppercase fw-bold" style="letter-spacing: 1px;">${text}</span>`;
        dom.spiciness.innerHTML = html;
    }

    function animateSlide(direction) {
        // 1. Fade Out Elements
        const textElements = [dom.title, dom.description, dom.price, dom.badge];
        textElements.forEach(el => el.style.opacity = '0');

        // 2. Animate Image OUT
        const moveOutX = direction === 'next' ? '-50px' : '50px';
        dom.image.style.transition = 'all 0.3s ease-in';
        dom.image.style.transform = `translateX(${moveOutX}) scale(0.9)`;
        dom.image.style.opacity = '0';

        setTimeout(() => {
            // 3. Update Data (Instant Swap since preloaded)
            const data = sliderData[currentIndex];

            dom.title.innerHTML = data.title;
            dom.badge.innerText = data.badge;
            dom.description.innerText = data.desc;
            dom.price.innerText = data.price;
            dom.oldPrice.innerText = data.oldPrice;
            dom.image.src = data.image;
            updateSpiciness(data.spiciness);

            dom.nutriCal.innerText = data.calories;
            dom.nutriFat.innerText = data.fat;
            dom.nutriProt.innerText = data.protein;

            // 4. Prepare for Animation IN (Instant Reset)
            const moveInX = direction === 'next' ? '50px' : '-50px';
            dom.image.style.transition = 'none';
            dom.image.style.transform = `translateX(${moveInX}) scale(0.9)`;

            // Force Reflow
            void dom.image.offsetWidth;

            // 5. Animate Image IN
            dom.image.style.transition = 'all 0.4s ease-out';
            dom.image.style.transform = 'translateX(0) scale(1.1)'; // Slight zoom for focus
            dom.image.style.opacity = '1';

            // 6. Animate Text IN
            textElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                }, index * 50);
            });

        }, 300); // Reduced delay to 300ms
    }

    if (dom.btnNext && dom.btnPrev) {
        dom.btnNext.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % sliderData.length;
            animateSlide('next');
        });

        dom.btnPrev.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + sliderData.length) % sliderData.length;
            animateSlide('prev');
        });
    }
});
