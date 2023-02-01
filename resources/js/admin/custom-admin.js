$(document).ready(function () {
    $(document).on('click', '.pagination-custom a', function (e) {
        console.log('vao day');
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        let key = document.getElementById('key-name-search').value;
        if (key.trim().length !== 0) {
            let data = {"key-name": key}
            getPostsWithKey(page, data)
        } else getPosts(page);
    });

    function getPosts(page) {
        $.ajax({
            type: "GET",
            url: '?page=' + page,
            success: function (data) {
                $("#contentproductadmin").html(data);
                console.log('vao no key');
            }
        });
    }

    function getPostsWithKey(page, data) {
        $.ajax({
            type: "GET",
            url: '?page=' + page,
            data: data,
            success: function (data) {
                $("#contentproductadmin").html(data);
                console.log('vao key');
            }
        });
    }

// change img product
    const oldSrcImgProduct = document.getElementById('product-img-admin');
    if (oldSrcImgProduct) {
        let oldSrcImgProductVal = oldSrcImgProduct.src;
    }
    let btnChangeImgProduct = document.getElementById('label-change-avatar-product');
    let imgFileProduct = document.getElementById('img-file-product-admin');
    if (btnChangeImgProduct) {
        let oldFileProduct = imgFileProduct.files;
        btnChangeImgProduct.onclick = function () {
            let imgSrc = document.getElementById('img-file-product-admin');
            let oldFile = imgSrc.files;
            imgSrc.addEventListener('change', function () {
                const file = this.files[0];
                console.log(this.files.length);
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(file.name)) {
                    document.getElementById('product-img-admin').src = oldSrcImgProductVal;
                    this.files = oldFileProduct;
                } else if (file) {
                    const reader = new FileReader();

                    reader.onload = function () {
                        const img = document.getElementById('product-img-admin');
                        img.src = this.result;
                    }

                    reader.readAsDataURL(file);
                }
            });
        }
    }

// change avatar admin
    if (document.getElementById('avatar-admin-id')) {
        const oldSrcImgAvatarAdmin = document.getElementById('avatar-admin-id').src;
    }
    let btnChangeAvatar = document.getElementById('label-change-avatar');
    let imgSrc = document.getElementById('avatar-admin');
    if (imgSrc) {
        let oldFile = imgSrc.files;
    }

    if (btnChangeAvatar) {
        let btnCancel = document.getElementsByClassName('cancel-avatar')[0];
        btnChangeAvatar.onclick = function () {
            imgSrc.addEventListener('change', function () {
                const file = this.files[0];
                console.log(file);
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(file.name)) {
                    document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
                    this.files = oldFile;
                } else if (file) {
                    const reader = new FileReader();

                    reader.onload = function () {
                        const img = document.getElementById('avatar-admin-id');
                        img.src = this.result;
                    }

                    reader.readAsDataURL(file);
                }
            });
        }

        btnCancel.onclick = function () {
            document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
            imgSrc.files = oldFile;
        }

    }

    let btnChangeSubimg = document.getElementById('btn-add-subimg');
    if (btnChangeSubimg) {
        btnChangeSubimg.onclick = function () {
            let divShow = document.getElementById('contain-subimg-add');
            let count = divShow.children.length + 1;
            let count2 = count - 1;
            let fileSubImgCheck = document.getElementById('sub-img-no-' + count2);
            // kiểm tra nếu inputfile bị khởi tạo nhưng không add thì xóa bỏ cái input đó đi
            if (fileSubImgCheck !== null && fileSubImgCheck.value.length == 0) {
                console.log(divShow.children[divShow.children.length - 1]);
                divShow.children[divShow.children.length - 1].remove();
            }
            count = divShow.children.length + 1;
            var html = `<div class="img-item item" style="margin-right: 15px; cursor: pointer;">
                        <label for="sub-img-no-` + count + `" id="label-change-subimg-` + count + `" class="label-change-subimg-add">
                            <input class="form-control" type="file" name="sub_img[no` + count + `]"
                                accept="image/*" id="sub-img-no-` + count + `"
                                style="position: absolute; left: -9999px;">
                        </label>
                    </div>`;

            divShow.insertAdjacentHTML('beforeend', html);
            let labelChange2 = document.getElementById('label-change-subimg-' + count + '');
            labelChange2.click();
            let fileSubImg = document.getElementById('sub-img-no-' + count);
            fileSubImg.addEventListener('change', function () {
                if (!labelChange2.children[1]) {
                    labelChange2.insertAdjacentHTML('beforeend', `<img id="sub-img-admin-no-` + count + `" style="height: 100%; width: 136px; cursor: pointer;" src="" alt="">`);
                }
                let file = this.files[0];
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(file.name)) {
                    // document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
                    // this.files = oldFile;
                } else if (file) {
                    let reader = new FileReader();

                    reader.onload = function () {
                        let img = document.getElementById('sub-img-admin-no-' + count);
                        img.src = this.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    }
    ;

    let labelsChange = document.getElementsByClassName('label-change-subimg');
    for (let labelChange of labelsChange) {
        labelChange.onclick = function () {
            console.log('vo day');
            let fileInput = this.children[0];
            let img = this.children[1];
            fileInput.addEventListener('change', function () {
                let file = this.files[0];
                console.log(file);
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (!allowedExtensions.exec(file.name)) {
                    // document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
                    // this.files = oldFile;
                } else if (file) {
                    let reader = new FileReader();

                    reader.onload = function () {
                        if (img) {
                            img.src = this.result;
                        }
                    }

                    reader.readAsDataURL(file);
                }
            });
        }
    }

// screen amount min max
    let amounts = document.getElementsByClassName('amount-size-admin');
    for (let amount of amounts) {
        amount.oninput = function () {
            let min = parseInt(this.min);
            if (parseInt(this.value) < min) {
                this.value = min
            }
            ;
        };
    }

// delete action

    let btns = document.getElementsByClassName('btn-delete-product-instock');

    for (let btn of btns) {
        btn.onclick = function () {
            let form = btn.parentElement;
            Swal.fire({
                title: 'Are you sure?',
                text: "Product is instock, you still want to delete this product",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    }

//change avatar shop

    const oldSrcImgShop = document.getElementById('shop-img-admin');
    if (oldSrcImgShop) {
        let oldSrcImgShopVal = oldSrcImgShop.src;

        let btnChangeImgUser = document.getElementById('label-change-avatar-shop');
        let imgFileShop = document.getElementById('img-file-shop-admin');
        if (btnChangeImgUser) {
            let oldFileUser = imgFileShop.files;
            btnChangeImgUser.onclick = function () {
                let imgSrc = document.getElementById('img-file-user-admin');
                let oldFile = imgSrc.files;
                imgSrc.addEventListener('change', function () {
                    const file = this.files[0];
                    console.log(this.files.length);
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                    if (!allowedExtensions.exec(file.name)) {
                        document.getElementById('shop-img-admin').src = oldSrcImgShopVal;
                        this.files = oldFileUser;
                    } else if (file) {
                        const reader = new FileReader();

                        reader.onload = function () {
                            const img = document.getElementById('shop-img-admin');
                            img.src = this.result;
                        }

                        reader.readAsDataURL(file);
                    }
                });
            }
        }
    }

// change avatar user

    const oldSrcImgUser = document.getElementById('user-img-admin');
    if (oldSrcImgUser) {
        let oldSrcImgUserVal = oldSrcImgUser.src;

        let btnChangeImgUser = document.getElementById('label-change-avatar-user');
        let imgFileUser = document.getElementById('img-file-user-admin');
        if (btnChangeImgUser) {
            let oldFileUser = imgFileUser.files;
            btnChangeImgUser.onclick = function () {
                let imgSrc = document.getElementById('img-file-user-admin');
                let oldFile = imgSrc.files;
                imgSrc.addEventListener('change', function () {
                    const file = this.files[0];
                    console.log(this.files.length);
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                    if (!allowedExtensions.exec(file.name)) {
                        document.getElementById('user-img-admin').src = oldSrcImgUserVal;
                        this.files = oldFile;
                    } else if (file) {
                        const reader = new FileReader();

                        reader.onload = function () {
                            const img = document.getElementById('user-img-admin');
                            img.src = this.result;
                        }

                        reader.readAsDataURL(file);
                    }
                });
            }
        }
    }

// carousel
    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 3
            }
        }
    });

    let modalShow = document.getElementById('modal-add-address');
    if (modalShow && modalShow.classList.contains("message-error")) {
        console.log(modalShow);
        console.log($("#modal-add-address"));
        $("#modal-add-address").modal();
    }

    let modalShowRole = document.getElementById('modal-add-role');
    if (modalShowRole && modalShowRole.classList.contains("message-error")) {
        console.log('vao day');
        $("#modal-add-role").modal();
    }

/////////////////////////////

    let btnsChangeStatus = document.getElementsByClassName('btn-change-status-user');
    for (let btnChangeStatus of btnsChangeStatus) {
        btnChangeStatus.onclick = function () {
            let form = btnChangeStatus.parentElement;
            Swal.fire({
                title: 'Are you sure?',
                text: "You will change now status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    }
    $('.select-custom').select2();
    $("select").select2("readonly", true);
});

let keyInput = document.getElementById("key-name-search");
if (keyInput) {
    keyInput.onkeyup = function (e) {
        e.preventDefault();
        let key = this.value;
        let link = this.getAttribute("data-link");
        if (key.trim().length !== 0) {
            let data = {"key-name": key.trim()}
            $.ajax({
                url: link,
                type: 'GET',
                data: data,
                success: function (result) {
                    $("#contentproductadmin").html(result);
                    console.log(result);
                }
            })
        }
    }
}
