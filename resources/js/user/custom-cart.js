let btnsPlus = document.getElementsByClassName("btn-plus-product-cart");
if (btnsPlus) {
    for (let btnPlus of btnsPlus) {
        btnPlus.onclick = function (e) {
            e.preventDefault();
            let amountInput = this.parentElement.parentElement.children[1];
            let parentDiv = amountInput.parentElement.parentElement.parentElement.parentElement;
            let totalDiv = parentDiv.children[4].children[0];
            let priceDiv = parentDiv.children[2].children[0].innerHTML.trim();
            let checkboxDiv = parentDiv.children[0].children[0];
            console.log('vao day');
            if (amountInput.value == amountInput.max) {
                Swal.fire({
                    icon: 'error',
                    title: "Error",
                    text: 'can\'t add products anymore',
                })
            } else {
                let link = this.href;
                let data = {"amount": amountInput.value, _token: $('input[name="_token"]').val()};
                $.ajax({
                    url: link,
                    type: 'PUT',
                    data: data,
                    success: function (result) {
                        console.log('tinh dung');
                        amountInput.setAttribute('value', result['amount']);
                        checkboxDiv.setAttribute('value', result['amount']);
                        totalDiv.innerHTML = priceDiv * result['amount'];
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: "Error",
                            text: error.responseJSON['message'],
                        });
                        amountInput.value = error.responseJSON['oldAmount'];
                    }
                });
            }
        }
    }
}

let btnsMinus = document.getElementsByClassName("btn-minus-product-cart");
if (btnsMinus) {
    if (btnsMinus) {
        for (let btnMinus of btnsMinus) {
            btnMinus.onclick = function (e) {
                e.preventDefault();
                let amountInput = this.parentElement.parentElement.children[1];
                let totalDiv = amountInput.parentElement.parentElement.parentElement.parentElement.children[4].children[0];
                let priceDiv = totalDiv.parentElement.parentElement.children[2].children[0].innerHTML.trim();
                let checkboxDiv = this.parentElement.parentElement.parentElement.parentElement.parentElement.children[0].children[0];
                if (amountInput.value == 1) {
                    Swal.fire('minimum product in the cart is 1')
                } else {
                    let link = this.href;
                    let data = {"amount": amountInput.value, _token: $('input[name="_token"]').val()};
                    $.ajax({
                        url: link,
                        type: 'PUT',
                        data: data,
                        success: function (result) {
                            amountInput.setAttribute('value', result['amount']);
                            checkboxDiv.setAttribute('value', result['amount']);
                            totalDiv.innerHTML = priceDiv * result['amount'];
                        },
                        error: function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: "Error",
                                text: error.responseJSON['message'],
                            });
                            amountInput.value = error.responseJSON['oldAmount'];
                        }
                    });
                }
            }
        }
    }
}

let inputsQuantity = document.getElementsByClassName('quantity-input-product-cart');
if (inputsQuantity) {
    for (let inputQuantity of inputsQuantity) {
        inputQuantity.onfocus = function () {
            this.oldvalue = this.value;
        }
        inputQuantity.onchange = function (e) {
            let link = this.getAttribute('data-link');
            let totalDiv = this.parentElement.parentElement.parentElement.parentElement.children[4].children[0];
            let priceDiv = this.parentElement.parentElement.parentElement.parentElement.children[2].children[0].innerHTML.trim();
            let amount = this.value;
            console.log(Number(amount))
            if (Number(amount) > Number(this.max)) {
                this.value = this.oldvalue;
                Swal.fire('you can buy max ' + this.max);
            } else if (Number(amount) == 0) {
                this.value = this.oldvalue;
            } else {
                let data = {"amount": this.value, _token: $('input[name="_token"]').val()};
                $.ajax({
                    url: link,
                    type: 'PUT',
                    data: data,
                    success: function (result) {
                        console.log(result['amount']);
                        this.value = result['amount'];
                        totalDiv.innerHTML = priceDiv * result['amount']
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: "Error",
                            text: error.responseJSON['message'],
                        });
                        amountInput.value = error.responseJSON['oldAmount'];
                    }
                });
            }
        };
    }
}

let btnsDeleteProductCart = document.getElementsByClassName('btn-delete-product-cart');
if (btnsDeleteProductCart) {
    for (let btnDeleteProductCart of btnsDeleteProductCart) {
        btnDeleteProductCart.onclick = function (e) {
            e.preventDefault();
            let link = this.children[0].href;
            let data = {_token: $('input[name="_token"]').val()};
            $.ajax({
                url: link,
                type: 'DELETE',
                data: data,
                success: function () {
                    location.reload();
                }
            })
        }
    }
}
