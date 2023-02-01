/*price range*/
if ($('#sl2')) {
    $('#sl2').slider();
}

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });

    let taga = document.getElementsByClassName('queryhome');
    if (taga) {
        for (let i = 0; i < taga.length; i++) {
            taga[i].onclick = () => {
                let priceRange = document.getElementsByClassName("tooltip-inner")[0].innerHTML.split(":");
                let priceStart = priceRange[0];
                let priceFinish = priceRange[1];
                taga[i].href += '&price_start=' + priceStart + '&price_finish=' + priceFinish;
            }
        }
    }

    let buttonSeach = document.getElementById('button-search-home');
    if (buttonSeach) {
        buttonSeach.onclick = () => {
            let form = document.getElementById('myformhome-custom');
            let key = document.getElementById('key-word-home').value;
            let priceRange = document.getElementsByClassName("tooltip-inner")[0].innerHTML.split(":");
            let priceStart = priceRange[0];
            let priceFinish = priceRange[1];
            form.innerHTML = `
			<input type="text" name="key_word" value="` + key + `">
			<input type="hidden" name="price_start" value="` + priceStart + `">
			<input type="hidden" name="price_finish" value="` + priceFinish + `">
		`;
            form.submit();
        }
    }

    let buttonSize = document.getElementsByClassName('custom-radio-size');
    if (buttonSize) {
        for (let i = 0; i < buttonSize.length; i++) {
            buttonSize[i].onclick = () => {
                let sizeName = buttonSize[i].innerHTML;
                let spanAmount = document.getElementById('amount-' + sizeName).innerHTML;
                let inputQuantity = document.getElementById('quantity-size');
                inputQuantity.setAttribute("max", spanAmount)
            }
        }
    }

    function resetStarRating() {
        $('.fa-star-cus').css('color', '#D8D8D8');
    }

    var clickedStar = -1;

    $('.fa-star-cus').mouseenter(function () {
        resetStarRating();
        var currentIndex = parseInt($(this).data('index'));
        for (var i = 0; i < currentIndex; i++) {
            $('.fa-star-cus:eq(' + i + ')').css('color', '#fe980f');
        }
    })

    $('.fa-star-cus').click(function () {
        clickedStar = parseInt($(this).data('index'));
    })

    $('.fa-star-cus').mouseleave(function () {
        resetStarRating();
        if (clickedStar != -1) {
            for (var i = 0; i < clickedStar; i++) {
                $('.fa-star-cus:eq(' + i + ')').css('color', '#fe980f');
            }
        }
    })

    $('.owl-cus-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        center: true,
        autoplay: true,
        autoplayTimeout: 4000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 4000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    let buttonAddCart = document.getElementById("btn-add-to-cart");
    if (buttonAddCart) {
        buttonAddCart.onclick = () => {
            document.getElementById('form-add-to-cart').submit();
        }
    }

    let amountInputForm = document.getElementById('quantity-size');
    if (amountInputForm) {
        amountInputForm.oninput = function () {
            let max = parseInt(this.max)
            let min = parseInt(this.min)
            if (parseInt(this.value) > max) {
                this.value = max
            }
            if (parseInt(this.value) < min) {
                this.value = min
            }
        }
    }

    let btnsChoseSize = document.getElementsByClassName('size-custom-label');
    if (btnsChoseSize) {
        for (let btnChoseSize of btnsChoseSize) {
            btnChoseSize.onclick = function () {
                let maxAmount = this.children[2].innerText;
                let tagAmount = document.getElementById('quantity-size');
                tagAmount.max = maxAmount;
                if (Number(tagAmount.value) > Number(tagAmount.max)) {
                    tagAmount.value = 1;
                }
            }
        }
    }

    let itemsProduct = document.getElementsByClassName("item-product");
    if (itemsProduct) {
        for (let item of itemsProduct) {
            item.onclick = function () {
                let link = this.getAttribute("data-link");
                window.location.href = link;
            }
        }
    }
});
